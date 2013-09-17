<?php

/**
 * CHH 後台對上傳文件的處理類(實現圖片上傳，圖片縮小， 增加水印)
 * 需要定義以下常量
 *
 * ============================================================================
 * 
 * ============================================================================
 * Author: shsing1
 * Id: cls_json.php 2009-11-04 17:00:00
*/

if (!defined('IN_CHH'))
{
    die('Hacking attempt');
}

class cls_file
{
    var $error_no    = 0;
    var $error_msg   = '';
    var $images_dir  = IMAGE_DIR;
    var $suffix     = '';

    function __construct()
    {
        $this->cls_file();
    }

    function cls_file()
    {
    }

    /**
     * 檔案上傳的處理函數
     *
     * @access      public
     * @param       array       upload       包含上傳的文件信息的數組
     * @param       array       dir          文件要上傳在$this->data_dir下的目錄名。如果為空圖片放在則在$this->images_dir下以當月命名的目錄下
     * @param       array       file_name    上傳檔案名稱，為空則隨機生成
     * @return      mix         如果成功則返回文件名，否則返回false
     */
    function upload_file($upload, $dir = '', $file_name = '')
    {
        /* 沒有指定目錄默認為根目錄images */
        if (empty($dir))
        {
            /* 創建當月目錄 */
            $dir = date('Ym');
            $dir = ROOT_PATH . $this->images_dir . '/' . $dir . '/';
        }
        else
        {
            /* 創建目錄 */
            $dir = ROOT_PATH . $this->images_dir . '/' . $dir . '/';
            if ($file_name)
            {
                $file_name = $dir . $file_name; // 將檔案定位到正確地址
            }
        }

        /* 如果目標目錄不存在，則創建它 */
        if (!file_exists($dir))
        {
            if (!make_dir($dir))
            {
                /* 創建目錄失敗 */
                $this->error_msg = sprintf($GLOBALS['_LANG']['directory_readonly'], $dir);
                $this->error_no  = ERR_DIRECTORY_READONLY;

                return false;
            }
        }
		
		/* 設定檔案後綴名 */
		$this->suffix = $this->get_filetype($upload['name']);

        if (empty($file_name))
        {
            $file_name = $this->unique_name($dir);
            $file_name = $dir . $file_name . $this->suffix;
        }

//        if (!$this->check_img_type($upload['type']))
//        {
//            $this->error_msg = $GLOBALS['_LANG']['invalid_upload_image_type'];
//            $this->error_no  =  ERR_INVALID_IMAGE_TYPE;
//            return false;
//        }

//        /* 允許上傳的文件類型 */
//        $allow_file_types = '|GIF|JPG|JEPG|PNG|BMP|SWF|';
//        if (!check_file_type($upload['tmp_name'], $file_name, $allow_file_types))
//        {
//            $this->error_msg = $GLOBALS['_LANG']['invalid_upload_image_type'];
//            $this->error_no  =  ERR_INVALID_IMAGE_TYPE;
//            return false;
//        }

        if ($this->move_file($upload, $file_name))
        {
            return str_replace(ROOT_PATH, '', $file_name);
        }
        else
        {
            $this->error_msg = sprintf($GLOBALS['_LANG']['upload_failure'], $upload['name']);
            $this->error_no  = ERR_UPLOAD_FAILURE;

            return false;
        }
    }

    /**
     * 返回錯誤信息
     *
     * @return  string   錯誤信息
     */
    function error_msg()
    {
        return $this->error_msg;
    }

    /**
     * 生成隨機的數字串
     *
     * @author: weber liu
     * @return string
     */
    function random_filename()
    {
        $str = '';
        for($i = 0; $i < 9; $i++)
        {
            $str .= mt_rand(0, 9);
        }

        return gmtime() . $str;
    }

    /**
     *  生成指定目錄不重名的文件名
     *
     * @access  public
     * @param   string      $dir        要檢查是否有同名文件的目錄
     *
     * @return  string      文件名
     */
    function unique_name($dir)
    {
        $filename = '';
        while (empty($filename))
        {
            $filename = $this->random_filename();
            if (file_exists($dir . $filename . $this->suffix) )
            {
                $filename = '';
            }
        }

        return $filename;
    }

    /**
     *  返回文件後綴名，如『.php』
     *
     * @access  public
     * @param
     *
     * @return  string      文件後綴名
     */
    function get_filetype($path)
    {
        $pos = strrpos($path, '.');
        if ($pos !== false)
        {
            return substr($path, $pos);
        }
        else
        {
            return '';
        }
    }

     /**
     * 根據來源文件的文件類型創建一個圖像操作的標識符
     *
     * @access  public
     * @param   string      $img_file   圖片文件的路徑
     * @param   string      $mime_type  圖片文件的文件類型
     * @return  resource    如果成功則返回圖像操作標誌符，反之則返回錯誤代碼
     */
    function img_resource($img_file, $mime_type)
    {
        switch ($mime_type)
        {
            case 1:
            case 'image/gif':
                $res = imagecreatefromgif($img_file);
                break;

            case 2:
            case 'image/pjpeg':
            case 'image/jpeg':
                $res = imagecreatefromjpeg($img_file);
                break;

            case 3:
            case 'image/x-png':
            case 'image/png':
                $res = imagecreatefrompng($img_file);
                break;

            default:
                return false;
        }

        return $res;
    }

    /**
     * 獲得服務器上的 GD 版本
     *
     * @access      public
     * @return      int         可能的值為0，1，2
     */
    function gd_version()
    {
        static $version = -1;

        if ($version >= 0)
        {
            return $version;
        }

        if (!extension_loaded('gd'))
        {
            $version = 0;
        }
        else
        {
            // 嘗試使用gd_info函數
            if (PHP_VERSION >= '4.3')
            {
                if (function_exists('gd_info'))
                {
                    $ver_info = gd_info();
                    preg_match('/\d/', $ver_info['GD Version'], $match);
                    $version = $match[0];
                }
                else
                {
                    if (function_exists('imagecreatetruecolor'))
                    {
                        $version = 2;
                    }
                    elseif (function_exists('imagecreate'))
                    {
                        $version = 1;
                    }
                }
            }
            else
            {
                if (preg_match('/phpinfo/', ini_get('disable_functions')))
                {
                    /* 如果phpinfo被禁用，無法確定gd版本 */
                    $version = 1;
                }
                else
                {
                  // 使用phpinfo函數
                   ob_start();
                   phpinfo(8);
                   $info = ob_get_contents();
                   ob_end_clean();
                   $info = stristr($info, 'gd version');
                   preg_match('/\d/', $info, $match);
                   $version = $match[0];
                }
             }
        }

        return $version;
     }

    /**
     *
     *
     * @access  public
     * @param
     *
     * @return void
     */
    function move_file($upload, $target)
    {
        if (isset($upload['error']) && $upload['error'] > 0)
        {
            return false;
        }

        if (!move_upload_file($upload['tmp_name'], $target))
        {
            return false;
        }

        return true;
    }
}

?>