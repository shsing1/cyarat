<?php

/**
 * CHH 公用函數庫
 * ============================================================================
 * 
 * ============================================================================
 * Author: shsing1
 * Id: lib_common.php 2009-10-24 11:00:00
*/

if (!defined('IN_CHH'))
{
    die('Hacking attempt');
}

/**
 * 創建像這樣的查詢: "IN('a','b')";
 *
 * @access   public
 * @param    mix      $item_list      列表數組或字符串
 * @param    string   $field_name     字段名稱
 *
 * @return   void
 */
function db_create_in($item_list, $field_name = '')
{
    if (empty($item_list))
    {
        return $field_name . " IN ('') ";
    }
    else
    {
        if (!is_array($item_list))
        {
            $item_list = explode(',', $item_list);
        }
        $item_list = array_unique($item_list);
        $item_list_tmp = '';
        foreach ($item_list AS $item)
        {
            if ($item !== '')
            {
                $item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
            }
        }
        if (empty($item_list_tmp))
        {
            return $field_name . " IN ('') ";
        }
        else
        {
            return $field_name . ' IN (' . $item_list_tmp . ') ';
        }
    }
}

/**
 * 驗證輸入的郵件地址是否合法
 *
 * @access  public
 * @param   string      $email      需要驗證的郵件地址
 *
 * @return bool
 */
function is_email($user_email)
{
    $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false)
    {
        if (preg_match($chars, $user_email))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

/**
 * 驗證輸入的密碼是否合法
 *
 * @access  public
 * @param   string      $email      需要驗證的密碼
 *
 * @return bool
 */
function check_password($str)
{
    $b = false;
	if(str_len($str) >= 6 && preg_match('/\d+/', $str) && preg_match('/[a-zA-Z]+/', $str) ){
		$b = true;
	}
	return $b;
	
}

/**
 * 驗證輸入的電話是否合法
 *
 * @access  public
 * @param   string      $email      需要驗證的電話
 *
 * @return bool
 */
function is_phone($str)
{
	$str = str_replace(array('-', ' '), '', $str);
    $b = false;
	if(str_len($str) >= 9 && preg_match('/\d+/', $str) && !preg_match('/[a-zA-Z]+/', $str) ){
		$b = true;
	}
	return $b;
	
}

/**
 * 檢查是否為一個合法的時間格式
 *
 * @access  public
 * @param   string  $time
 * @return  void
 */
function is_time($time)
{
    $pattern = '/[\d]{4}-[\d]{1,2}-[\d]{1,2}\s[\d]{1,2}:[\d]{1,2}:[\d]{1,2}/';

    return preg_match($pattern, $time);
}

/**
 * 獲得查詢時間和次數，並賦值給smarty
 *
 * @access  public
 * @return  void
 */
function assign_query_info()
{
    if ($GLOBALS['db']->queryTime == '')
    {
        $query_time = 0;
    }
    else
    {
        if (PHP_VERSION >= '5.0.0')
        {
            $query_time = number_format(microtime(true) - $GLOBALS['db']->queryTime, 6);
        }
        else
        {
            list($now_usec, $now_sec)     = explode(' ', microtime());
            list($start_usec, $start_sec) = explode(' ', $GLOBALS['db']->queryTime);
            $query_time = number_format(($now_sec - $start_sec) + ($now_usec - $start_usec), 6);
        }
    }
    $GLOBALS['smarty']->assign('query_info', sprintf($GLOBALS['_LANG']['query_info'], $GLOBALS['db']->queryCount, $query_time));

    /* 內存佔用情況 */
    if ($GLOBALS['_LANG']['memory_info'] && function_exists('memory_get_usage'))
    {
        $GLOBALS['smarty']->assign('memory_info', sprintf($GLOBALS['_LANG']['memory_info'], memory_get_usage() / 1048576));
    }

    /* 是否啟用了 gzip */
    $gzip_enabled = gzip_enabled() ? $GLOBALS['_LANG']['gzip_enabled'] : $GLOBALS['_LANG']['gzip_disabled'];
    $GLOBALS['smarty']->assign('gzip_enabled', $gzip_enabled);
}

/**
 * 創建地區的返回信息
 *
 * @access  public
 * @param   array   $arr    地區數組 *
 * @return  void
 */
function region_result($parent, $sel_name, $type)
{
    global $cp;

    $arr = get_regions($type, $parent);
    foreach ($arr AS $v)
    {
        $region      =& $cp->add_node('region');
        $region_id   =& $region->add_node('id');
        $region_name =& $region->add_node('name');

        $region_id->set_data($v['region_id']);
        $region_name->set_data($v['region_name']);
    }
    $select_obj =& $cp->add_node('select');
    $select_obj->set_data($sel_name);
}

/**
 * 載入配置信息
 *
 * @access  public
 * @return  array
 */
function load_config()
{
    $arr = array();

    $data = read_static_cache('config');
    if ($data === false)
    {
        $sql = 'SELECT code, value FROM ' . $GLOBALS['chh']->table('config') . ' WHERE cat_id > 0';
        $res = $GLOBALS['db']->getAll($sql);

        foreach ($res AS $row)
        {
            $arr[$row['code']] = $row['value'];
        }

//        /* 對數值型設置處理 */
//        $arr['watermark_alpha']      = intval($arr['watermark_alpha']);
//        $arr['market_price_rate']    = floatval($arr['market_price_rate']);
//        $arr['integral_scale']       = floatval($arr['integral_scale']);
//        //$arr['integral_percent']     = floatval($arr['integral_percent']);
//        $arr['cache_time']           = intval($arr['cache_time']);
//        $arr['thumb_width']          = intval($arr['thumb_width']);
//        $arr['thumb_height']         = intval($arr['thumb_height']);
//        $arr['image_width']          = intval($arr['image_width']);
//        $arr['image_height']         = intval($arr['image_height']);
//        $arr['best_number']          = !empty($arr['best_number']) && intval($arr['best_number']) > 0 ? intval($arr['best_number'])     : 3;
//        $arr['new_number']           = !empty($arr['new_number']) && intval($arr['new_number']) > 0 ? intval($arr['new_number'])      : 3;
//        $arr['hot_number']           = !empty($arr['hot_number']) && intval($arr['hot_number']) > 0 ? intval($arr['hot_number'])      : 3;
//        $arr['promote_number']       = !empty($arr['promote_number']) && intval($arr['promote_number']) > 0 ? intval($arr['promote_number'])  : 3;
//        $arr['top_number']           = intval($arr['top_number'])      > 0 ? intval($arr['top_number'])      : 10;
//        $arr['history_number']       = intval($arr['history_number'])  > 0 ? intval($arr['history_number'])  : 5;
//        $arr['comments_number']      = intval($arr['comments_number']) > 0 ? intval($arr['comments_number']) : 5;
//        $arr['article_number']       = intval($arr['article_number'])  > 0 ? intval($arr['article_number'])  : 5;
//        $arr['page_size']            = intval($arr['page_size'])       > 0 ? intval($arr['page_size'])       : 10;
//        $arr['bought_goods']         = intval($arr['bought_goods']);
//        $arr['goods_name_length']    = intval($arr['goods_name_length']);
//        $arr['top10_time']           = intval($arr['top10_time']);
//        $arr['goods_gallery_number'] = intval($arr['goods_gallery_number']) ? intval($arr['goods_gallery_number']) : 5;
//        $arr['no_picture']           = !empty($arr['no_picture']) ? str_replace('../', './', $arr['no_picture']) : 'images/no_picture.gif'; // 修改默認商品圖片的路徑
//        $arr['qq']                   = !empty($arr['qq']) ? $arr['qq'] : '';
//        $arr['ww']                   = !empty($arr['ww']) ? $arr['ww'] : '';
//        $arr['default_storage']      = isset($arr['default_storage']) ? intval($arr['default_storage']) : 1;
//        $arr['min_goods_amount']     = isset($arr['min_goods_amount']) ? floatval($arr['min_goods_amount']) : 0;
//        $arr['one_step_buy']         = empty($arr['one_step_buy']) ? 0 : 1;
//        $arr['invoice_type']         = empty($arr['invoice_type']) ? array('type' => array(), 'rate' => array()) : unserialize($arr['invoice_type']);
//        $arr['show_order_type']      = isset($arr['show_order_type']) ? $arr['show_order_type'] : 0;    // 顯示方式默認為列表方式
//        $arr['help_open']            = isset($arr['help_open']) ? $arr['help_open'] : 1;    // 顯示方式默認為列表方式
//
//        if (!isset($GLOBALS['_CFG']['chh_version']))
//        {
//            /* 如果沒有版本號則默認為2.0.5 */
//            $GLOBALS['_CFG']['chh_version'] = 'v2.0.5';
//        }

        //限定語言項
        $lang_array = array('zh_cn', 'zh_tw', 'en_us');
        if (empty($arr['lang']) || !in_array($arr['lang'], $lang_array))
        {
            $arr['lang'] = 'zh_tw'; // 默認語言為繁體中文
        }

//        if (empty($arr['integrate_code']))
//        {
//            $arr['integrate_code'] = 'chh'; // 默認的會員整合插件為 chh
//        }
        write_static_cache('config', $arr);
    }
    else
    {
        $arr = $data;
    }

    return $arr;
}

/**
 * 格式化商品價格
 *
 * @access  public
 * @param   float   $price  商品價格
 * @return  string
 */
function price_format($price, $change_price = true)
{
    if ($change_price && defined('CHH_ADMIN') === false)
    {
        switch ($GLOBALS['_CFG']['price_format'])
        {
            case 0:
                $price = number_format($price, 2, '.', '');
                break;
            case 1: // 保留不為 0 的尾數
                $price = preg_replace('/(.*)(\\.)([0-9]*?)0+$/', '\1\2\3', number_format($price, 2, '.', ''));

                if (substr($price, -1) == '.')
                {
                    $price = substr($price, 0, -1);
                }
                break;
            case 2: // 不四捨五入，保留1位
                $price = substr(number_format($price, 2, '.', ''), 0, -1);
                break;
            case 3: // 直接取整
                $price = intval($price);
                break;
            case 4: // 四捨五入，保留 1 位
                $price = number_format($price, 1, '.', '');
                break;
            case 5: // 先四捨五入，不保留小數
                $price = round($price);
                break;
        }
    }
    else
    {
        $price = number_format($price, 2, '.', '');
    }

    return sprintf($GLOBALS['_CFG']['currency_format'], $price);
}


/**
 *  清除指定後綴的模板緩存或編譯文件
 *
 * @access  public
 * @param  bool       $is_cache  是否清除緩存還是清出編譯文件
 * @param  string     $ext       需要刪除的文件名，不包含後綴
 *
 * @return int        返回清除的文件個數
 */
function clear_tpl_files($is_cache = true, $ext = '')
{
    $dirs = array();

    if (isset($GLOBALS['shop_id']) && $GLOBALS['shop_id'] > 0)
    {
        $tmp_dir = DATA_DIR ;
    }
    else
    {
        $tmp_dir = 'temp';
    }
    if ($is_cache)
    {
        $cache_dir = ROOT_PATH . $tmp_dir . '/caches/';
        $dirs[] = ROOT_PATH . $tmp_dir . '/query_caches/';
        $dirs[] = ROOT_PATH . $tmp_dir . '/static_caches/';
        for($i = 0; $i < 16; $i++)
        {
            $hash_dir = $cache_dir . dechex($i);
            $dirs[] = $hash_dir . '/';
        }
    }
    else
    {
        $dirs[] = ROOT_PATH . $tmp_dir . '/compiled/';
        $dirs[] = ROOT_PATH . $tmp_dir . '/compiled/admin/';
    }

    $str_len = strlen($ext);
    $count   = 0;

    foreach ($dirs AS $dir)
    {
        $folder = @opendir($dir);

        if ($folder === false)
        {
            continue;
        }

        while ($file = readdir($folder))
        {
            if ($file == '.' || $file == '..' || $file == 'index.htm' || $file == 'index.html')
            {
                continue;
            }
            if (is_file($dir . $file))
            {
                /* 如果有文件名則判斷是否匹配 */
                $pos = ($is_cache) ? strrpos($file, '_') : strrpos($file, '.');

                if ($str_len > 0 && $pos !== false)
                {
                    $ext_str = substr($file, 0, $pos);

                    if ($ext_str == $ext)
                    {
                        if (@unlink($dir . $file))
                        {
                            $count++;
                        }
                    }
                }
                else
                {
                    if (@unlink($dir . $file))
                    {
                        $count++;
                    }
                }
            }
        }
        closedir($folder);
    }

    return $count;
}

/**
 * 清除模版編譯文件
 *
 * @access  public
 * @param   mix     $ext    模版文件名， 不包含後綴
 * @return  void
 */
function clear_compiled_files($ext = '')
{
    return clear_tpl_files(false, $ext);
}

/**
 * 清除緩存文件
 *
 * @access  public
 * @param   mix     $ext    模版文件名， 不包含後綴
 * @return  void
 */
function clear_cache_files($ext = '')
{
    return clear_tpl_files(true, $ext);
}

/**
 * 清除模版編譯和緩存文件
 *
 * @access  public
 * @param   mix     $ext    模版文件名後綴
 * @return  void
 */
function clear_all_files($ext = '')
{
    return clear_tpl_files(false, $ext) + clear_tpl_files(true,  $ext);
}

/**
 * 頁面上調用的js文件
 *
 * @access  public
 * @param   string      $files
 * @return  void
 */
function smarty_insert_scripts($args)
{
    static $scripts = array();

    $arr = explode(',', str_replace(' ','',$args['files']));

    $str = '';
    foreach ($arr AS $val)
    {
        if (in_array($val, $scripts) == false)
        {
            $scripts[] = $val;
            if ($val{0} == '.')
            {
                $str .= '<script type="text/javascript" src="' . $val . '"></script>';
            }
            else
            {
                $str .= '<script type="text/javascript" src="js/' . $val . '"></script>';
            }
        }
    }

    return $str;
}

/**
 * 創建分頁的列表
 *
 * @access  public
 * @param   integer $count
 * @return  string
 */
function smarty_create_pages($params)
{
    extract($params);

    $str = '';
    $len = 10;

    if (empty($page))
    {
        $page = 1;
    }

    if (!empty($count))
    {
        $step = 1;
        $str .= "<option value='1'>1</option>";

        for ($i = 2; $i < $count; $i += $step)
        {
            $step = ($i >= $page + $len - 1 || $i <= $page - $len + 1) ? $len : 1;
            $str .= "<option value='$i'";
            $str .= $page == $i ? " selected='true'" : '';
            $str .= ">$i</option>";
        }

        if ($count > 1)
        {
            $str .= "<option value='$count'";
            $str .= $page == $count ? " selected='true'" : '';
            $str .= ">$count</option>";
        }
    }

    return $str;
}

/**
 * 重寫 URL 地址
 *
 * @access  public
 * @param   string  $app    執行程序
 * @param   array   $params 參數數組
 * @param   string  $append 附加字串
 * @param   integer $page   頁數
 * @return  void
 */
function build_uri($app, $params, $append = '', $page = 0, $size = 0)
{
    static $rewrite = NULL;

    if ($rewrite === NULL)
    {
        $rewrite = intval($GLOBALS['_CFG']['rewrite']);
    }

    $args = array('cid'   => 0,
                  'gid'   => 0,
                  'bid'   => 0,
                  'acid'  => 0,
                  'aid'   => 0,
                  'sid'   => 0,
                  'gbid'  => 0,
                  'auid'  => 0,
                  'sort'  => '',
                  'order' => '',
                );

    extract(array_merge($args, $params));

    $uri = '';
    switch ($app)
    {
        case 'category':
            if (empty($cid))
            {
                return false;
            }
            else
            {
                if ($rewrite)
                {
                    $uri = 'category-' . $cid;
                    if (isset($bid))
                    {
                        $uri .= '-b' . $bid;
                    }
                    if (isset($price_min))
                    {
                        $uri .= '-min'.$price_min;
                    }
                    if (isset($price_max))
                    {
                        $uri .= '-max'.$price_max;
                    }
                    if (isset($filter_attr))
                    {
                        $uri .= '-attr' . $filter_attr;
                    }
                    if (!empty($page))
                    {
                        $uri .= '-' . $page;
                    }
                    if (!empty($sort))
                    {
                        $uri .= '-' . $sort;
                    }
                    if (!empty($order))
                    {
                        $uri .= '-' . $order;
                    }
                }
                else
                {
                    $uri = 'category.php?id=' . $cid;
                    if (!empty($bid))
                    {
                        $uri .= '&amp;brand=' . $bid;
                    }
                    if (isset($price_min))
                    {
                        $uri .= '&amp;price_min=' . $price_min;
                    }
                    if (isset($price_max))
                    {
                        $uri .= '&amp;price_max=' . $price_max;
                    }
                    if (!empty($filter_attr))
                    {
                        $uri .='&amp;filter_attr=' . $filter_attr;
                    }

                    if (!empty($page))
                    {
                        $uri .= '&amp;page=' . $page;
                    }
                    if (!empty($sort))
                    {
                        $uri .= '&amp;sort=' . $sort;
                    }
                    if (!empty($order))
                    {
                        $uri .= '&amp;order=' . $order;
                    }
                }
            }

            break;
        case 'goods':
            if (empty($gid))
            {
                return false;
            }
            else
            {
                $uri = $rewrite ? 'goods-' . $gid : 'goods.php?id=' . $gid;
            }

            break;
        case 'brand':
            if (empty($bid))
            {
                return false;
            }
            else
            {
                if ($rewrite)
                {
                    $uri = 'brand-' . $bid;
                    if (isset($cid))
                    {
                        $uri .= '-c' . $cid;
                    }
                    if (!empty($page))
                    {
                        $uri .= '-' . $page;
                    }
                    if (!empty($sort))
                    {
                        $uri .= '-' . $sort;
                    }
                    if (!empty($order))
                    {
                        $uri .= '-' . $order;
                    }
                }
                else
                {
                    $uri = 'brand.php?id=' . $bid;
                    if (!empty($cid))
                    {
                        $uri .= '&amp;cat=' . $cid;
                    }
                    if (!empty($page))
                    {
                        $uri .= '&amp;page=' . $page;
                    }
                    if (!empty($sort))
                    {
                        $uri .= '&amp;sort=' . $sort;
                    }
                    if (!empty($order))
                    {
                        $uri .= '&amp;order=' . $order;
                    }
                }
            }

            break;
        case 'article_cat':
            if (empty($acid))
            {
                return false;
            }
            else
            {
                if ($rewrite)
                {
                    $uri = 'article_cat-' . $acid;
                    if (!empty($page))
                    {
                        $uri .= '-' . $page;
                    }
                    if (!empty($sort))
                    {
                        $uri .= '-' . $sort;
                    }
                    if (!empty($order))
                    {
                        $uri .= '-' . $order;
                    }
                }
                else
                {
                    $uri = 'article_cat.php?id=' . $acid;
                    if (!empty($page))
                    {
                        $uri .= '&amp;page=' . $page;
                    }
                    if (!empty($sort))
                    {
                        $uri .= '&amp;sort=' . $sort;
                    }
                    if (!empty($order))
                    {
                        $uri .= '&amp;order=' . $order;
                    }
                }
            }

            break;
        case 'article':
            if (empty($aid))
            {
                return false;
            }
            else
            {
                $uri = $rewrite ? 'article-' . $aid : 'article.php?id=' . $aid;
            }

            break;
        case 'group_buy':
            if (empty($gbid))
            {
                return false;
            }
            else
            {
                $uri = $rewrite ? 'group_buy-' . $gbid : 'group_buy.php?act=view&amp;id=' . $gbid;
            }

            break;
        case 'auction':
            if (empty($auid))
            {
                return false;
            }
            else
            {
                $uri = $rewrite ? 'auction-' . $auid : 'auction.php?act=view&amp;id=' . $auid;
            }

            break;
        case 'snatch':
            if (empty($sid))
            {
                return false;
            }
            else
            {
                $uri = $rewrite ? 'snatch-' . $sid : 'snatch.php?id=' . $sid;
            }

            break;
        case 'search':
            break;
        case 'exchange':
            if ($rewrite)
            {
                $uri = 'exchange-' . $cid;
                if (isset($price_min))
                {
                    $uri .= '-min'.$price_min;
                }
                if (isset($price_max))
                {
                    $uri .= '-max'.$price_max;
                }
                if (!empty($page))
                {
                    $uri .= '-' . $page;
                }
                if (!empty($sort))
                {
                    $uri .= '-' . $sort;
                }
                if (!empty($order))
                {
                    $uri .= '-' . $order;
                }
            }
            else
            {
                $uri = 'exchange.php?cat_id=' . $cid;
                if (isset($price_min))
                {
                    $uri .= '&amp;integral_min=' . $price_min;
                }
                if (isset($price_max))
                {
                    $uri .= '&amp;integral_max=' . $price_max;
                }

                if (!empty($page))
                {
                    $uri .= '&amp;page=' . $page;
                }
                if (!empty($sort))
                {
                    $uri .= '&amp;sort=' . $sort;
                }
                if (!empty($order))
                {
                    $uri .= '&amp;order=' . $order;
                }
            }

            break;
        case 'exchange_goods':
            if (empty($gid))
            {
                return false;
            }
            else
            {
                $uri = $rewrite ? 'exchange-id' . $gid : 'exchange.php?id=' . $gid . '&amp;act=view';
            }

            break;
        default:
            return false;
            break;
    }

    if ($rewrite)
    {
        if ($rewrite == 2 && !empty($append))
        {
            $uri .= '-' . urlencode(preg_replace('/[\.|\/|\?|&|\+|\\\|\'|"|,]+/', '', $append));
        }

        $uri .= '.html';
    }
    if (($rewrite == 2) && (strpos(strtolower(CHH_CHARSET), 'utf') !== 0))
    {
        $uri = urlencode($uri);
    }
    return $uri;
}

/**
 * 格式化重量：小於1千克用克表示，否則用千克表示
 * @param   float   $weight     重量
 * @return  string  格式化後的重量
 */
function formated_weight($weight)
{
    $weight = round(floatval($weight), 3);
    if ($weight > 0)
    {
        if ($weight < 1)
        {
            /* 小於1千克，用克表示 */
            return intval($weight * 1000) . $GLOBALS['_LANG']['gram'];
        }
        else
        {
            /* 大於1千克，用千克表示 */
            return $weight . $GLOBALS['_LANG']['kilogram'];
        }
    }
    else
    {
        return 0;
    }
}


/**
 * 重新獲得商品圖片與商品相冊的地址
 *
 * @param int $goods_id 商品ID
 * @param string $image 原商品相冊圖片地址
 * @param boolean $thumb 是否為縮略圖
 * @param string $call 調用方法(商品圖片還是商品相冊)
 * @param boolean $del 是否刪除圖片
 *
 * @return string   $url
 */
function get_image_path($goods_id, $image='', $thumb=false, $call='goods', $del=false)
{
    $url = empty($image) ? $GLOBALS['_CFG']['no_picture'] : $image;
    return $url;
}

/**
 * 重新獲得上次查詢的條件以陣列回傳
 *
 * @return string   $url
 */
function get_last_filter_arr()
{
	$arr = array();
	if(!empty($_COOKIE['chh_lastfilter'])){
		$filter = unserialize(urldecode($_COOKIE['chh_lastfilter']));
		if(is_array($filter)){
			$arr = $filter;
		}
	}
    return $arr;
}

/**
 * 重新獲得上次查詢的條件並組成url回傳
 *
 * @return string   $url
 */
function get_last_filter_url()
{
	$str = '';
	$arr = get_last_filter_arr();
	$str = http_build_query($arr);
	
    return $str;
}

?>