<?php
/**
 *  基本圖片處理，用於完成圖片縮入，浮水印添加
 *  當浮水印圖超過目標圖片尺寸時，浮水印圖能自動適應目標圖片而縮小
 *  浮水印圖可以設置跟背景的合併度
 *
 *  Copyright(c) 2005 by ustb99. All rights reserved
 *
 *  To contact the author write to {@link mailto:ustb80@163.com}
 *
 * @author 偶然
 * @version $Id: thumb.class.php,v 1.9 2006/09/30 09:31:56 zengjian Exp $
 * @package system
 */
 
/**
 * ThumbHandler
 * @access public
 */
 
/*
 使用方法:
    自動裁切:
    程式會按照圖片的尺寸從中部裁切最大的正方形，並按目標尺寸進行縮略
 
    $t->setSrcImg("img/test.jpg");
    $t->setCutType(1);//這一句就OK了
    $t->setDstImg("tmp/new_test.jpg");
    $t->createImg(60,60);
 
    手工裁切:
    程式會按照指定的位置從源圖上取圖
 
    $t->setSrcImg("img/test.jpg");
    $t->setCutType(2);//指明為手工裁切
    $t->setSrcCutPosition(100, 100);// 源圖起點座標
    $t->setRectangleCut(300, 200);// 裁切尺寸
    $t->setDstImg("tmp/new_test.jpg");
    $t->createImg(300,200); 	
*/
class ThumbHandler
{
    var $dst_img;// 目標檔
    var $h_src; // 圖片資源控制碼
    var $h_dst;// 新圖控制碼
    var $h_mask;// 浮水印控制碼
    var $img_create_quality = 100;// 圖片生成品質
    var $img_display_quality = 100;// 圖片顯示品質,默認為75
    var $img_scale = 0;// 圖片縮放比例
    var $src_w = 0;// 原圖寬度
    var $src_h = 0;// 原圖高度
    var $dst_w = 0;// 新圖總寬度
    var $dst_h = 0;// 新圖總高度
    var $fill_w;// 填充圖形寬
    var $fill_h;// 填充圖形高
    var $copy_w;// 拷貝圖形寬
    var $copy_h;// 拷貝圖形高
    var $src_x = 0;// 原圖繪製起始橫坐標
    var $src_y = 0;// 原圖繪製起始縱坐標
    var $start_x;// 新圖繪製起始橫坐標
    var $start_y;// 新圖繪製起始縱坐標
    var $mask_word;// 浮水印文字
    var $mask_img;// 浮水印圖片
    var $mask_pos_x = 0;// 浮水印橫坐標
    var $mask_pos_y = 0;// 浮水印縱坐標
    var $mask_offset_x = 0;// 浮水印橫向偏移
    var $mask_offset_y = 0;// 浮水印縱向偏移
    var $font_w;// 浮水印字體寬
    var $font_h;// 浮水印字體高
    var $mask_w;// 浮水印寬
    var $mask_h;// 浮水印高
    var $mask_font_color = "#ffffff";// 浮水印文字顏色
    var $mask_font = 2;// 浮水印字體
    var $font_size;// 尺寸
    var $mask_position = 0;// 浮水印位置
	var $mask_always_at_src = true; // 浮水印固定壓成原圖上
    var $mask_img_pct = 50;// 圖片合併程度,值越大，合併程式越低
    var $mask_txt_pct = 50;// 文字合併程度,值越小，合併程式越低
    var $img_border_size = 0;// 圖片邊框尺寸
    var $img_border_color;// 圖片邊框顏色
    var $_flip_x=0;// 水準翻轉次數
    var $_flip_y=0;// 垂直翻轉次數
 
    var $cut_type=0;// 剪切類型
 
 
    var $img_type;// 文件類型
 
    // 檔類型定義,並指出了輸出圖片的函數
    var $all_type = array(
        "jpg"  => array("output"=>"imagejpeg"),
        "gif"  => array("output"=>"imagegif"),
        "png"  => array("output"=>"imagepng"),
		"bmp" => array("output"=>"imagejpeg"),
        "wbmp" => array("output"=>"image2wbmp"),
        "jpeg" => array("output"=>"imagejpeg"));
 
    /**
     * 構造函數
     */
    function ThumbHandler()
    {
        $this->mask_font_color = "#ffffff";
        $this->font = 2;
        $this->font_size = 12;
    }
 
    /**
     * 取得圖片的寬
     */
    function getImgWidth($src)
    {
        return imagesx($src);
    }
 
    /**
     * 取得圖片的高
     */
    function getImgHeight($src)
    {
        return imagesy($src);
    }
 
    /**
     * 設置圖片生成路徑
     *
     * @param    string    $src_img   圖片生成路徑
     */
    function setSrcImg($src_img, $img_type=null)
    {
        if(!file_exists($src_img))
        {
            die("圖片不存在");
        }
        
        if(!empty($img_type))
        {
            $this->img_type = $img_type;
        }
        else
        {
            $this->img_type = $this->_getImgType($src_img);
        }
        
        $this->_checkValid($this->img_type);
 
        // file_get_contents函數要求php版本>4.3.0
        $src = '';
        if(function_exists("file_get_contents"))
        {
            $src = file_get_contents($src_img);
        }
        else
        {
            $handle = fopen ($src_img, "r");
            while (!feof ($handle))
            {
                $src .= fgets($fd, 4096);
            }
            fclose ($handle);
        }
        if(empty($src))
        {
            die("圖片源為空");
        }
        
		// 如果圖片是bmp的話則特別處理
		if($this->img_type == 'bmp'){
			$this->h_src = $this->imagecreatefrombmp($src_img);
		}else{
			$this->h_src = @ImageCreateFromString($src);
		}
		
        $this->src_w = $this->getImgWidth($this->h_src);
        $this->src_h = $this->getImgHeight($this->h_src);
    }
 
    /**
     * 設置圖片生成路徑
     *
     * @param    string    $dst_img   圖片生成路徑
     */
    function setDstImg($dst_img)
    {
        $arr  = explode('/',$dst_img);
        $last = array_pop($arr);
        $path = implode('/',$arr);
        $this->_mkdirs($path);
        $this->dst_img = $dst_img;
    }
 
    /**
     * 設置圖片的顯示品質
     *
     * @param    string      $n    品質
     */
    function setImgDisplayQuality($n)
    {
        $this->img_display_quality = (int)$n;
    }
 
    /**
     * 設置圖片的生成品質
     *
     * @param    string      $n    品質
     */
    function setImgCreateQuality($n)
    {
        $this->img_create_quality = (int)$n;
    }
 
    /**
     * 設置文字浮水印
     *
     * @param    string     $word    浮水印文字
     * @param    integer    $font    浮水印字體
     * @param    string     $color   浮水印字體顏色
     */
    function setMaskWord($word)
    {
        $this->mask_word .= $word;
    }
 
    /**
     * 設置字體顏色
     *
     * @param    string     $color    字體顏色
     */
    function setMaskFontColor($color="#ffffff")
    {
        $this->mask_font_color = $color;
    }
 
    /**
     * 設置浮水印字體
     *
     * @param    string|integer    $font    字體
     */
    function setMaskFont($font=2)
    {
        if(!is_numeric($font) && !file_exists($font))
        {
            die("字體檔不存在");
        }
        $this->font = $font;
    }
 
    /**
     * 設置文字字體大小,僅對truetype字體有效
     */
    function setMaskFontSize($size = "12")
    {
        $this->font_size = $size;
    }
 
    /**
     * 設置圖片浮水印
     *
     * @param    string    $img     浮水印圖片源
     */
    function setMaskImg($img)
    {
        $this->mask_img = $img;
    }
 
    /**
     * 設置浮水印橫向偏移
     *
     * @param    integer     $x    橫向偏移量
     */
    function setMaskOffsetX($x)
    {
        $this->mask_offset_x = (int)$x;
    }
 
    /**
     * 設置浮水印縱向偏移
     *
     * @param    integer     $y    縱向偏移量
     */
    function setMaskOffsetY($y)
    {
        $this->mask_offset_y = (int)$y;
    }
 
    /**
     * 指定浮水印位置
     *
     * @param    integer     $position    位置,1:左上,2:左下,3:右上,0/4:右下
     */
    function setMaskPosition($position=0)
    {
        $this->mask_position = (int)$position;
    }
 
    /**
     * 設置圖片合併程度
     *
     * @param    integer     $n    合併程度
     */
    function setMaskImgPct($n)
    {
        $this->mask_img_pct = (int)$n;
    }
 
    /**
     * 設置文字合併程度
     *
     * @param    integer     $n    合併程度
     */
    function setMaskTxtPct($n)
    {
        $this->mask_txt_pct = (int)$n;
    }
 
    /**
     * 設置縮略圖邊框
     *
     * @param    (類型)     (參數名)    (描述)
     */
    function setDstImgBorder($size=1, $color="#000000")
    {
        $this->img_border_size  = (int)$size;
        $this->img_border_color = $color;
    }
 
    /**
     * 水準翻轉
     */
    function flipH()
    {
        $this->_flip_x++;
    }
 
    /**
     * 垂直翻轉
     */
    function flipV()
    {
        $this->_flip_y++;
    }
 
    /**
     * 設置剪切類型
     *
     * @param    (類型)     (參數名)    (描述)
     */
    function setCutType($type)
    {
        $this->cut_type = (int)$type;
    }
 
    /**
     * 設置圖片剪切
     *
     * @param    integer     $width    矩形剪切
     */
    function setRectangleCut($width, $height)
    {
        $this->fill_w = (int)$width;
        $this->fill_h = (int)$height;
    }
 
    /**
     * 設置源圖剪切起始座標點
     *
     * @param    (類型)     (參數名)    (描述)
     */
    function setSrcCutPosition($x, $y)
    {
        $this->src_x  = (int)$x;
        $this->src_y  = (int)$y;
    }
 
    /**
     * 創建圖片,主函數
     * @param    integer    $a     當缺少第二個參數時，此參數將用作百分比，
     *                             否則作為寬度值
     * @param    integer    $b     圖片縮放後的高度

     */
    function createImg($a, $b=null)
    {
        $num = func_num_args();
        if(1 == $num)
        {
            $r = (int)$a;
            if($r < 1)
            {
                die("圖片縮放比例不得小於1");
            }
            $this->img_scale = $r;
            $this->_setNewImgSize($r);
        }
 
        if(2 == $num)
        {
            $w = (int)$a;
            $h = (int)$b;
            if(0 == $w)
            {
                die("目標寬度不能為0");
            }
            if(0 == $h)
            {
                die("目標高度不能為0");
            }
            $this->_setNewImgSize($w, $h);
        }
 
        if($this->_flip_x%2!=0)
        {
            $this->_flipH($this->h_src);
        }
 
        if($this->_flip_y%2!=0)
        {
            $this->_flipV($this->h_src);
        }
        $this->_createMask();
        $this->_output();
 
        // 釋放
        if(imagedestroy($this->h_src) && imagedestroy($this->h_dst))
        {
            Return true;
        }
        else
        {
            Return false;
        }
    }
 
    /**
     * 生成浮水印,調用了生成浮水印文字和浮水印圖片兩個方法
     */
    function _createMask()
    {
        if($this->mask_word)
        {
            // 獲取字體資訊
            $this->_setFontInfo();
 
            if($this->_isFull())
            {
                die("浮水印文字過大");
            }
            else
            {
                $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
                $white = ImageColorAllocate($this->h_dst,255,255,255);
                imagefilledrectangle($this->h_dst,0,0,$this->dst_w,$this->dst_h,$white);// 填充背景色
                $this->_drawBorder();
                imagecopyresampled( $this->h_dst, $this->h_src,
                                    $this->start_x, $this->start_y,
                                    $this->src_x, $this->src_y,
                                    $this->fill_w, $this->fill_h,
                                    $this->copy_w, $this->copy_h);
                $this->_createMaskWord($this->h_dst);
            }
        }
 
        if($this->mask_img)
        {
            $this->_loadMaskImg();//載入時，取得寬高
 
            if($this->_isFull())
            {
                // 將浮水印生成在原圖上再拷
                $this->_createMaskImg($this->h_src);
                $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
                $white = ImageColorAllocate($this->h_dst,255,255,255);
                imagefilledrectangle($this->h_dst,0,0,$this->dst_w,$this->dst_h,$white);// 填充背景色
                $this->_drawBorder();
                imagecopyresampled( $this->h_dst, $this->h_src,
                                    $this->start_x, $this->start_y,
                                    $this->src_x, $this->src_y,
                                    $this->fill_w, $this->fill_h,
                                    $this->copy_w, $this->copy_h);
            }
            else
            {
                // 創建新圖並拷貝
                $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
                $white = ImageColorAllocate($this->h_dst,255,255,255);
                imagefilledrectangle($this->h_dst,0,0,$this->dst_w,$this->dst_h,$white);// 填充背景色
                $this->_drawBorder();
                imagecopyresampled( $this->h_dst, $this->h_src,
                                    $this->start_x, $this->start_y,
                                    $this->src_x, $this->src_y,
                                    $this->fill_w, $this->fill_h,
                                    $this->copy_w, $this->copy_h);
                $this->_createMaskImg($this->h_dst);
            }
        }
 
        if(empty($this->mask_word) && empty($this->mask_img))
        {
            $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
            $white = ImageColorAllocate($this->h_dst,255,255,255);
            imagefilledrectangle($this->h_dst,0,0,$this->dst_w,$this->dst_h,$white);// 填充背景色
            $this->_drawBorder();
            imagecopyresampled( $this->h_dst, $this->h_src,
                        $this->start_x, $this->start_y,
                        $this->src_x, $this->src_y,
                        $this->fill_w, $this->fill_h,
                        $this->copy_w, $this->copy_h);
        }
    }
 
    /**
     * 畫邊框
     */
    function _drawBorder()
    {
        if(!empty($this->img_border_size))
        {
            $c = $this->_parseColor($this->img_border_color);
            $color = ImageColorAllocate($this->h_src,$c[0], $c[1], $c[2]);
            imagefilledrectangle($this->h_dst,0,0,$this->dst_w,$this->dst_h,$color);// 填充背景色
        }
    }
 
    /**
     * 生成浮水印文字
     */
    function _createMaskWord($src)
    {
        $this->_countMaskPos();
        $this->_checkMaskValid();
 
        $c = $this->_parseColor($this->mask_font_color);
        $color = imagecolorallocatealpha($src, $c[0], $c[1], $c[2], $this->mask_txt_pct);
 
        if(is_numeric($this->font))
        {
            imagestring($src,
                        $this->font,
                        $this->mask_pos_x, $this->mask_pos_y,
                        $this->mask_word,
                        $color);
        }
        else
        {
            imagettftext($src,
                        $this->font_size, 0,
                        $this->mask_pos_x, $this->mask_pos_y,
                        $color,
                        $this->font,
                        $this->mask_word);
        }
    }
 
    /**
     * 生成浮水印圖
     */
    function _createMaskImg($src)
    {
        $this->_countMaskPos();
        $this->_checkMaskValid();
        imagecopymerge($src,
                        $this->h_mask,
                        $this->mask_pos_x ,$this->mask_pos_y,
                        0, 0,
                        $this->mask_w, $this->mask_h,
                        $this->mask_img_pct);
 
        imagedestroy($this->h_mask);
    }
 
    /**
     * 載入浮水印圖
     */
    function _loadMaskImg()
    {
        $mask_type = $this->_getImgType($this->mask_img);
        $this->_checkValid($mask_type);
 
        // file_get_contents函數要求php版本>4.3.0
        $src = '';
        if(function_exists("file_get_contents"))
        {
            $src = file_get_contents($this->mask_img);
        }
        else
        {
            $handle = fopen ($this->mask_img, "r");
            while (!feof ($handle))
            {
                $src .= fgets($fd, 4096);
            }
            fclose ($handle);
        }
        if(empty($this->mask_img))
        {
            die("浮水印圖片為空");
        }
        $this->h_mask = ImageCreateFromString($src);
        $this->mask_w = $this->getImgWidth($this->h_mask);
        $this->mask_h = $this->getImgHeight($this->h_mask);
    }
 
    /**
     * 圖片輸出
     */
    function _output()
    {
        $img_type  = $this->img_type;
        $func_name = $this->all_type[$img_type]['output'];
        if(function_exists($func_name))
        {
            // 判斷流覽器,若是IE就不發送頭
            if(isset($_SERVER['HTTP_USER_AGENT']))
            {
                $ua = strtoupper($_SERVER['HTTP_USER_AGENT']);
                if(!preg_match('/^.*MSIE.*\)$/i',$ua) && empty($this->dst_img) )
                {
                    header("Content-type:$img_type");
                }
            }
			$this->img_display_quality = $func_name=='imagepng'?9:$this->img_display_quality;
            $func_name($this->h_dst, $this->dst_img, $this->img_display_quality);
        }
        else
        {
            Return false;
        }
    }
 
    /**
     * 分析顏色
     *
     * @param    string     $color    十六進位顏色
     */
    function _parseColor($color)
    {
        $arr = array();
        for($ii=1; $ii<strlen ($color); $ii++)
        {
            $arr[] = hexdec(substr($color,$ii,2));
            $ii++;
        }
 
        Return $arr;
    }
 
    /**
     * 計算出位置座標
     */
    function _countMaskPos()
    {
        if($this->_isFull())
        {
            switch($this->mask_position)
            {
                case 1:
                    // 左上
                    $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                    $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                    break;
 
                case 2:
                    // 左下
                    $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                    $this->mask_pos_y = $this->src_h - $this->mask_h - $this->mask_offset_y;
                    break;
 
                case 3:
                    // 右上
                    $this->mask_pos_x = $this->src_w - $this->mask_w - $this->mask_offset_x;
                    $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                    break;
 
                case 4:
                    // 右下
                    $this->mask_pos_x = $this->src_w - $this->mask_w - $this->mask_offset_x;
                    $this->mask_pos_y = $this->src_h - $this->mask_h - $this->mask_offset_y;
                    break;
 
                default:
                    // 默認將浮水印放到右下,偏移指定圖元
                    $this->mask_pos_x = $this->src_w - $this->mask_w - $this->mask_offset_x;
                    $this->mask_pos_y = $this->src_h - $this->mask_h - $this->mask_offset_y;
                    break;
            }
        }
        else
        {
            switch($this->mask_position)
            {
                case 1:
                    // 左上
                    $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                    $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                    break;
 
                case 2:
                    // 左下
                    $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                    $this->mask_pos_y = $this->dst_h - $this->mask_h - $this->mask_offset_y - $this->img_border_size;
                    break;
 
                case 3:
                    // 右上
                    $this->mask_pos_x = $this->dst_w - $this->mask_w - $this->mask_offset_x - $this->img_border_size;
                    $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                    break;
 
                case 4:
                    // 右下
                    $this->mask_pos_x = $this->dst_w - $this->mask_w - $this->mask_offset_x - $this->img_border_size;
                    $this->mask_pos_y = $this->dst_h - $this->mask_h - $this->mask_offset_y - $this->img_border_size;
                    break;
 
                default:
                    // 默認將浮水印放到右下,偏移指定圖元
                    $this->mask_pos_x = $this->dst_w - $this->mask_w - $this->mask_offset_x - $this->img_border_size;
                    $this->mask_pos_y = $this->dst_h - $this->mask_h - $this->mask_offset_y - $this->img_border_size;
                    break;
            }
        }
    }
 
    /**
     * 設置字體資訊
     */
    function _setFontInfo()
    {
        if(is_numeric($this->font))
        {
            $this->font_w  = imagefontwidth($this->font);
            $this->font_h  = imagefontheight($this->font);
 
            // 計算浮水印字體所占寬高
            $word_length   = strlen($this->mask_word);
            $this->mask_w  = $this->font_w*$word_length;
            $this->mask_h  = $this->font_h;
        }
        else
        {
            $arr = imagettfbbox ($this->font_size,0, $this->font,$this->mask_word);
            $this->mask_w  = abs($arr[0] - $arr[2]);
            $this->mask_h  = abs($arr[7] - $arr[1]);
        }
    }
 
    /**
     * 設置新圖尺寸
     *
     * @param    integer     $img_w   目標寬度
     * @param    integer     $img_h   目標高度
     */
    function _setNewImgSize($img_w, $img_h=null)
    {
        $num = func_num_args();
        if(1 == $num)
        {
            $this->img_scale = $img_w;// 寬度作為比例
            $this->fill_w = round($this->src_w * $this->img_scale / 100) - $this->img_border_size*2;
            $this->fill_h = round($this->src_h * $this->img_scale / 100) - $this->img_border_size*2;
 
            // 原始檔案起始座標
            $this->src_x  = 0;
            $this->src_y  = 0;
            $this->copy_w = $this->src_w;
            $this->copy_h = $this->src_h;
 
            // 目標尺寸
            $this->dst_w   = $this->fill_w + $this->img_border_size*2;
            $this->dst_h   = $this->fill_h + $this->img_border_size*2;
        }
 
        if(2 == $num)
        {
            $fill_w   = (int)$img_w - $this->img_border_size*2;
            $fill_h   = (int)$img_h - $this->img_border_size*2;
            if($fill_w < 0 || $fill_h < 0)
            {
                die("圖片邊框過大，已超過了圖片的寬度");
            }
            $rate_w = $this->src_w/$fill_w;
            $rate_h = $this->src_h/$fill_h;
 
            switch($this->cut_type)
            {
                case 0:
                    // 如果原圖大於縮略圖，產生縮小，否則不縮小
                    if($rate_w < 1 && $rate_h < 1)
                    {
                        $this->fill_w = (int)$this->src_w;
                        $this->fill_h = (int)$this->src_h;
                    }
                    else
                    {
                        if($rate_w >= $rate_h)
                        {
                            $this->fill_w = (int)$fill_w;
                            $this->fill_h = round($this->src_h/$rate_w);
                        }
                        else
                        {
                            $this->fill_w = round($this->src_w/$rate_h);
                            $this->fill_h = (int)$fill_h;
                        }
                    }
 
                    $this->src_x  = 0;
                    $this->src_y  = 0;
 
                    $this->copy_w = $this->src_w;
                    $this->copy_h = $this->src_h;
 
                    // 目標尺寸
                    $this->dst_w   = $this->fill_w + $this->img_border_size*2;
                    $this->dst_h   = $this->fill_h + $this->img_border_size*2;
                    break;
 
                // 自動裁切 - 裁切後為正方形
                case 1:
                    // 如果圖片是縮小剪切才進行操作
                    if($rate_w >= 1 && $rate_h >=1)
                    {
                        if($this->src_w > $this->src_h)
                        {
                            $src_x = round($this->src_w-$this->src_h)/2;
                            $this->setSrcCutPosition($src_x, 0);
                            $this->setRectangleCut($fill_h, $fill_h);
 
                            $this->copy_w = $this->src_h;
                            $this->copy_h = $this->src_h;
                            
                        }
                        elseif($this->src_w < $this->src_h)
                        {
                            $src_y = round($this->src_h-$this->src_w)/2;
                            $this->setSrcCutPosition(0, $src_y);
                            $this->setRectangleCut($fill_w, $fill_h);
 
                            $this->copy_w = $this->src_w;
                            $this->copy_h = $this->src_w;
                        }
                        else
                        {
                            $this->setSrcCutPosition(0, 0);
                            $this->copy_w = $this->src_w;
                            $this->copy_h = $this->src_w;
                            $this->setRectangleCut($fill_w, $fill_h);
                        }
                    }
                    else
                    {
                        $this->setSrcCutPosition(0, 0);
                        $this->setRectangleCut($this->src_w, $this->src_h);
 
                        $this->copy_w = $this->src_w;
                        $this->copy_h = $this->src_h;
                    }
 
                    // 目標尺寸
                    $this->dst_w   = $this->fill_w + $this->img_border_size*2;
                    $this->dst_h   = $this->fill_h + $this->img_border_size*2;
                    
                    break;				
 
                // 手工裁切
                case 2:
                    $this->copy_w = $this->fill_w;
                    $this->copy_h = $this->fill_h;
 
                    // 目標尺寸
                    $this->dst_w   = $this->fill_w + $this->img_border_size*2;
                    $this->dst_h   = $this->fill_h + $this->img_border_size*2;                
                    
                    break;
				// 自動裁切 - 截中間並符合輸出尺寸
                case 3:
                    // 如果圖片是縮小剪切才進行操作
                    if($rate_w >= 1 && $rate_h >=1)
                    {
						
						$ratio_src = $this->src_w / $this->src_h;
						// 以高為主
						if($ratio_src >= 1){
							$this->copy_h = round($fill_h*$rate_h);
							$this->copy_w = round($fill_w*$rate_h);							
							// 換算後的寬度大於原圖的寬度 - 以寬為主
							if($this->copy_w > $this->src_w){
								$this->copy_w = round($fill_w*$rate_w);
								$this->copy_h = round($fill_h*$rate_w);
							}
						// 以寬為主
						}else{							
							$this->copy_w = round($fill_w*$rate_w);
							$this->copy_h = round($fill_h*$rate_w);
							// 換算後的高度大於原圖的高度 - 以高為主
							if($this->copy_h > $this->src_h){
								$this->copy_h = round($fill_h*$rate_h);
								$this->copy_w = round($fill_w*$rate_h);
							}
						}
						$src_x = round($this->src_w - $this->copy_w)/2;
						$src_y = round($this->src_h - $this->copy_h)/2;
                        $this->setSrcCutPosition($src_x, $src_y);
                        $this->setRectangleCut($fill_w, $fill_h);
						
						/*
						$ratiothumb = (float) $fill_w / (float) $fill_h;
						
						if($ratiothumb >= 1)
						{
							$this->copy_h = $fill_h * $rate_w;
							while($this->copy_h > $this->src_h){
								$rate_w -= 0.1;
								$this->copy_h = $fill_h * $rate_w;
							}
							
							$this->copy_w = round($fill_w*$rate_w);
                            $this->copy_h = round($fill_h*$rate_w);
						
							$src_x = round($this->src_w - $this->copy_w)/2;
							$src_y = round($this->src_h - $this->copy_h)/2;
                            $this->setSrcCutPosition($src_x, $src_y);
                            $this->setRectangleCut($fill_w, $fill_h);
							
                        }
                        elseif($ratiothumb < 1)
                        {
							$this->copy_w = $fill_w * $rate_h;
							while($this->copy_w > $this->src_w){
								$rate_h -= 0.1;
								$this->copy_w = $fill_w * $rate_h;
							}
							
							$this->copy_w = round($fill_w*$rate_h);
                            $this->copy_h = round($fill_h*$rate_h);
						
							$src_x = round($this->src_w - $this->copy_w)/2;
							$src_y = round($this->src_h - $this->copy_h)/2;
                            $this->setSrcCutPosition($src_x, $src_y);
                            $this->setRectangleCut($fill_w, $fill_h);
							
                        }
                        else
                        {
                            $this->setSrcCutPosition(0, 0);
                            $this->copy_w = $this->src_w;
                            $this->copy_h = $this->src_w;
                            $this->setRectangleCut($fill_w, $fill_h);
                        }
						*/
                    }
                    else
                    {
						$this->setSrcCutPosition(0, 0);
                        $this->setRectangleCut($this->src_w, $this->src_h);
 
                        $this->copy_w = $this->src_w;
                        $this->copy_h = $this->src_h;
                    }
 
                    // 目標尺寸
                    $this->dst_w   = $this->fill_w + $this->img_border_size*2;
                    $this->dst_h   = $this->fill_h + $this->img_border_size*2;
                    
                    break;
                default:
                    break;
 
            }
        }
 
        // 目標檔起始座標
        $this->start_x = $this->img_border_size;
        $this->start_y = $this->img_border_size;
    }
 
    /**
     * 檢查浮水印圖是否大於生成後的圖片寬高
     */
    function _isFull()
    {
        Return (   $this->mask_w + $this->mask_offset_x > $this->fill_w
                || $this->mask_h + $this->mask_offset_y > $this->fill_h
				|| $this->mask_always_at_src
				)
                   ?true:false;
    }
 
    /**
     * 檢查浮水印圖是否超過原圖
     */
    function _checkMaskValid()
    {
        if(    $this->mask_w + $this->mask_offset_x > $this->src_w
            || $this->mask_h + $this->mask_offset_y > $this->src_h)
        {
            die("浮水印圖片尺寸大於原圖，請縮小浮水印圖");
        }
    }
 
    /**
     * 取得圖片類型
     *
     * @param    string     $file_path    檔路徑
     */
    function _getImgType($file_path)
    {
        $type_list = array("1"=>"gif","2"=>"jpg","3"=>"png","4"=>"swf","5" => "psd","6"=>"bmp","15"=>"wbmp");
        if(file_exists($file_path))
        {
            $img_info = @getimagesize ($file_path);
            if(isset($type_list[$img_info[2]]))
            {
                Return $type_list[$img_info[2]];
            }
        }
        else
        {
            die("檔不存在,不能取得檔類型!");
        }
    }
 
    /**
     * 檢查圖片類型是否合法,調用了array_key_exists函數，此函數要求
     * php版本大於4.1.0
     *
     * @param    string     $img_type    文件類型
     */
    function _checkValid($img_type)
    {
        if(!array_key_exists($img_type, $this->all_type))
        {
            Return false;
        }
    }
 
    /**
     * 按指定路徑生成目錄
     *
     * @param    string     $path    路徑
     */
    function _mkdirs($path)
    {
        $adir = explode('/',$path);
        $dirlist = '';
        $rootdir = array_shift($adir);
        if(($rootdir!='.'||$rootdir!='..')&&!file_exists($rootdir))
        {
            @mkdir($rootdir);
        }
        foreach($adir as $key=>$val)
        {
            if($val!='.'&&$val!='..')
            {
                $dirlist .= "/".$val;
                $dirpath = $rootdir.$dirlist;
                if(!file_exists($dirpath))
                {
                    @mkdir($dirpath);
                    @chmod($dirpath,0777);
                }
            }
        }
    }
 
    /**
     * 垂直翻轉
     *
     * @param    string     $src    圖片源
     */
    function _flipV($src)
    {
        $src_x = $this->getImgWidth($src);
        $src_y = $this->getImgHeight($src);
 
        $new_im = imagecreatetruecolor($src_x, $src_y);
        for ($y = 0; $y < $src_y; $y++)
        {
            imagecopy($new_im, $src, 0, $src_y - $y - 1, 0, $y, $src_x, 1);
        }
        $this->h_src = $new_im;
    }
 
    /**
     * 水準翻轉
     *
     * @param    string     $src    圖片源
     */
    function _flipH($src)
    {
        $src_x = $this->getImgWidth($src);
        $src_y = $this->getImgHeight($src);
 
        $new_im = imagecreatetruecolor($src_x, $src_y);
        for ($x = 0; $x < $src_x; $x++)
        {
            imagecopy($new_im, $src, $src_x - $x - 1, 0, $x, 0, 1, $src_y);
        }
        $this->h_src = $new_im;
    }
	
	/**
     * 增加對bmp圖檔的支援
     *
     * @param    string     $p_sFile    圖片源
     */
	public function imagecreatefrombmp($p_sFile)
    {
        //    Load the image into a string
        $file    =    fopen($p_sFile,"rb");
        $read    =    fread($file,10);
        while(!feof($file)&&($read<>""))
            $read    .=    fread($file,1024);
       
        $temp    =    unpack("H*",$read);
        $hex    =    $temp[1];
        $header    =    substr($hex,0,108);
       
        //    Process the header
        //    Structure: http://www.fastgraph.com/help/bmp_header_format.html
        if (substr($header,0,4)=="424d")
        {
            //    Cut it in parts of 2 bytes
            $header_parts    =    str_split($header,2);
           
            //    Get the width        4 bytes
            $width            =    hexdec($header_parts[19].$header_parts[18]);
           
            //    Get the height        4 bytes
            $height            =    hexdec($header_parts[23].$header_parts[22]);
           
            //    Unset the header params
            unset($header_parts);
        }
       
        //    Define starting X and Y
        $x                =    0;
        $y                =    1;
       
        //    Create newimage
        $image            =    imagecreatetruecolor($width,$height);
       
        //    Grab the body from the image
        $body            =    substr($hex,108);

        //    Calculate if padding at the end-line is needed
        //    Divided by two to keep overview.
        //    1 byte = 2 HEX-chars
        $body_size        =    (strlen($body)/2);
        $header_size    =    ($width*$height);

        //    Use end-line padding? Only when needed
        $usePadding        =    ($body_size>($header_size*3)+4);
       
        //    Using a for-loop with index-calculation instaid of str_split to avoid large memory consumption
        //    Calculate the next DWORD-position in the body
        for ($i=0;$i<$body_size;$i+=3)
        {
            //    Calculate line-ending and padding
            if ($x>=$width)
            {
                //    If padding needed, ignore image-padding
                //    Shift i to the ending of the current 32-bit-block
                if ($usePadding)
                    $i    +=    $width%4;
               
                //    Reset horizontal position
                $x    =    0;
               
                //    Raise the height-position (bottom-up)
                $y++;
               
                //    Reached the image-height? Break the for-loop
                if ($y>$height)
                    break;
            }
           
            //    Calculation of the RGB-pixel (defined as BGR in image-data)
            //    Define $i_pos as absolute position in the body
            $i_pos    =    $i*2;
            $r        =    hexdec($body[$i_pos+4].$body[$i_pos+5]);
            $g        =    hexdec($body[$i_pos+2].$body[$i_pos+3]);
            $b        =    hexdec($body[$i_pos].$body[$i_pos+1]);
           
            //    Calculate and draw the pixel
            $color    =    imagecolorallocate($image,$r,$g,$b);
            imagesetpixel($image,$x,$height-$y,$color);
           
            //    Raise the horizontal position
            $x++;
        }
       
        //    Unset the body / free the memory
        unset($body);
       
        //    Return image-object
        return $image;
    } 
}

/*
	//使用實例:
	require_once('lib/thumb.class.php');
	 
	$t = new ThumbHandler();
	 
	$t->setSrcImg("img/test.jpg");
	$t->setDstImg("tmp/new_test.jpg");
	$t->setMaskImg("img/test.gif");
	$t->setMaskPosition(1);
	$t->setMaskImgPct(80);
	$t->setDstImgBorder(4,"#dddddd");
	 
	// 指定縮放比例
	$t->createImg(300,200);
	
	//----------------------------------------
	
	require_once('lib/thumb.class.php');
	 
	$t = new ThumbHandler();
	 
	// 基本使用
	$t->setSrcImg("img/test.jpg");
	$t->setMaskWord("test");
	$t->setDstImgBorder(10,"#dddddd");
	 
	// 指定縮放比例
	$t->createImg(50);
	
	//-----------------------------------------
	
	require_once('lib/thumb.class.php');
	 
	$t = new ThumbHandler();
	 
	// 基本使用
	$t->setSrcImg("img/test.jpg");
	$t->setMaskWord("test");
	 
	// 指定固定寬高
	$t->createImg(200,200);
	
	//------------------------------------------
	
	require_once('lib/thumb.class.php');
	 
	$t = new ThumbHandler();
	 
	$t->setSrcImg("img/test.jpg");
	$t->setDstImg("tmp/new_test.jpg");
	$t->setMaskWord("test");
	 
	// 指定固定寬高
	$t->createImg(200,200);
	
	//-------------------------------------
	
	require_once('lib/thumb.class.php');
	 
	$t = new ThumbHandler();
	 
	$t->setSrcImg("img/test.jpg");
	 
	// 指定字體檔位址
	$t->setMaskFont("c:/winnt/fonts/arial.ttf");
	$t->setMaskFontSize(20);
	$t->setMaskFontColor("#ffff00");
	$t->setMaskWord("test3333333");
	$t->setDstImgBorder(99,"#dddddd");
	$t->createImg(50);
	 
	//---------------------------------------
	
	require_once('lib/thumb.class.php');
	 
	$t = new ThumbHandler();
	 
	$t->setSrcImg("img/test.jpg");
	$t->setMaskOffsetX(55);
	$t->setMaskOffsetY(55);
	$t->setMaskPosition(1);
	//$t->setMaskPosition(2);
	//$t->setMaskPosition(3);
	//$t->setMaskPosition(4);
	$t->setMaskFontColor("#ffff00");
	$t->setMaskWord("test");
	 
	// 指定固定寬高
	$t->createImg(50);
	
	//--------------------------------------
	
	require_once('lib/thumb.class.php');
	 
	$t = new ThumbHandler();
	 
	$t->setSrcImg("img/test.jpg");
	$t->setMaskFont("c:/winnt/fonts/simyou.ttf");
	$t->setMaskFontSize(20);
	$t->setMaskFontColor("#ffffff");
	$t->setMaskTxtPct(20);
	$t->setDstImgBorder(10,"#dddddd");
	$text = "中文";
	$str = mb_convert_encoding($text, "UTF-8", "gb2312");
	$t->setMaskWord($str);
	$t->setMaskWord("test");
	 
	// 指定固定寬高
	$t->createImg(50);
*/
?>