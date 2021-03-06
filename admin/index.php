<?php
/**
 * 星爺系統 控制台首頁
 * ============================================================================
 * 
 * ============================================================================
 * Author: shsing1
 * Id: index.php 2009-10-24 11:00:00
*/

define('IN_CHH', true);

require_once(dirname(__FILE__) . '/includes/init.php');
//require_once(ROOT_PATH . '/includes/lib_order.php');

/*------------------------------------------------------ */
//-- 框架
/*------------------------------------------------------ */
if ($_REQUEST['act'] == '')
{
    $smarty->display('index.htm');
}

/*------------------------------------------------------ */
//-- 頂部框架的內容
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'top')
{
    // 獲得管理員設置的菜單
    $lst = array();
    $nav = $db->GetOne('SELECT nav_list FROM ' . $chh->table('admin_user') . " WHERE id = '" . $_SESSION['admin_id'] . "'");

    if (!empty($nav))
    {
        $arr = explode(',', $nav);

        foreach ($arr AS $val)
        {
            $tmp = explode('|', $val);
            $lst[$tmp[1]] = $tmp[0];
        }
    }

    // 獲得管理員設置的菜單

    // 獲得管理員ID
    $smarty->assign('send_mail_on',$_CFG['send_mail_on']);
    $smarty->assign('nav_list', $lst);
    $smarty->assign('admin_id', $_SESSION['admin_id']);
    $smarty->assign('certi', $_CFG['certi']);

    $smarty->display('top.htm');
}

///*------------------------------------------------------ */
////-- 計算器
///*------------------------------------------------------ */
//
//elseif ($_REQUEST['act'] == 'calculator')
//{
//    $smarty->display('calculator.htm');
//}

/*------------------------------------------------------ */
//-- 左邊的框架
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'menu')
{
//    include_once('includes/inc_menu.php');
//
//	// 權限對照表
//    include_once('includes/inc_priv.php');
//
//    foreach ($modules AS $key => $value)
//    {
//        ksort($modules[$key]);
//    }
//    ksort($modules);
//
//    foreach ($modules AS $key => $val)
//    {
//        $menus[$key]['label'] = $_LANG[$key];
//        if (is_array($val))
//        {
//            foreach ($val AS $k => $v)
//            {
//                if ( isset($purview[$k]))
//                {
//                    if (is_array($purview[$k]))
//                    {
//                        $boole = false;
//                        foreach ($purview[$k] as $action)
//                        {
//                             $boole = $boole || admin_priv($action, '', false);
//                        }
//                        if (!$boole)
//                        {
//                            continue;
//                        }
//
//                    }
//                    else
//                    {
//                        if (! admin_priv($purview[$k], '', false))
//                        {
//                            continue;
//                        }
//                    }
//                }
//                if ($k == 'ucenter_setup' && $_CFG['integrate_code'] != 'ucenter')
//                {
//                    continue;
//                }
//                $menus[$key]['children'][$k]['label']  = $_LANG[$k];
//                $menus[$key]['children'][$k]['action'] = $v;
//            }
//        }
//        else
//        {
//            $menus[$key]['action'] = $val;
//        }
//
//        // 如果children的子元素長度為0則刪除該組
//        if(empty($menus[$key]['children']))
//        {
//            unset($menus[$key]);
//        }
//
//    }

	require_once(ROOT_PATH . '/includes/cls_sys_menu.php');
	$sys_menu = new cls_sys_menu($db, $chh->table("sys_menu") );

	$menus = $sys_menu->get_list_arr();

	$str = '';
	foreach($menus as $v){
		if(count($v['childs']) > 0){
			$t = create_sub_tree_html($v['childs']);
			$str .= '<li><span class="folder">'.$v['name'].'</span>'.$t.'</li>';
		}else{
			if($v['url'] != ''){
				$v['name'] = '<a href="'.$v['url'].'" target="main-frame">'.$v['name'].'</a>';
			}
			$str .= '<li><span class="file">'.$v['name'].'</span></li>';
		}
	}
	$str = '<ul id="browser" class="filetree treeview-famfamfam">'.$str.'</ul>';
	
    $smarty->assign('menus',     $str);
    $smarty->assign('no_help',   $_LANG['no_help']);
    $smarty->assign('help_lang', $_CFG['lang']);
    $smarty->assign('charset', CHH_CHARSET);
    $smarty->assign('admin_id', $_SESSION['admin_id']);
    $smarty->display('menu.htm');
}
/*------------------------------------------------------ */
//-- 清除緩存
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'clear_cache')
{
    clear_all_files();

    sys_msg($_LANG['caches_cleared']);
}


/*------------------------------------------------------ */
//-- 主窗口，起始頁
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'main')
{	
    $gd = gd_version();

    /* 檢查文件目錄屬性 */
    $warning = array();

    if ($_CFG['site_closed'])
    {
        $warning[] = $_LANG['site_closed_tips'];
    }

//    if (file_exists('../install'))
//    {
//        $warning[] = $_LANG['remove_install'];
//    }
//
//    if (file_exists('../upgrade'))
//    {
//        $warning[] = $_LANG['remove_upgrade'];
//    }
//
//    $open_basedir = ini_get('open_basedir');
//    if (!empty($open_basedir))
//    {
//        /* 如果 open_basedir 不為空，則檢查是否包含了 upload_tmp_dir  */
//        $open_basedir = str_replace(array("\\", "\\\\"), array("/", "/"), $open_basedir);
//        $upload_tmp_dir = ini_get('upload_tmp_dir');
//
//        if (empty($upload_tmp_dir))
//        {
//            if (stristr(PHP_OS, 'win'))
//            {
//                $upload_tmp_dir = getenv('TEMP') ? getenv('TEMP') : getenv('TMP');
//                $upload_tmp_dir = str_replace(array("\\", "\\\\"), array("/", "/"), $upload_tmp_dir);
//            }
//            else
//            {
//                $upload_tmp_dir = getenv('TMPDIR') === false ? '/tmp' : getenv('TMPDIR');
//            }
//        }
//
//        if (!stristr($open_basedir, $upload_tmp_dir))
//        {
//            $warning[] = sprintf($_LANG['temp_dir_cannt_read'], $upload_tmp_dir);
//        }
//    }
//
//    $result = file_mode_info('../cert');
//    if ($result < 2)
//    {
//        $warning[] = sprintf($_LANG['not_writable'], 'cert', $_LANG['cert_cannt_write']);
//    }
//
//    $result = file_mode_info('../' . DATA_DIR);
//    if ($result < 2)
//    {
//        $warning[] = sprintf($_LANG['not_writable'], 'data', $_LANG['data_cannt_write']);
//    }
//    else
//    {
//        $result = file_mode_info('../' . DATA_DIR . '/afficheimg');
//        if ($result < 2)
//        {
//            $warning[] = sprintf($_LANG['not_writable'], DATA_DIR . '/afficheimg', $_LANG['afficheimg_cannt_write']);
//        }
//
//        $result = file_mode_info('../' . DATA_DIR . '/brandlogo');
//        if ($result < 2)
//        {
//            $warning[] = sprintf($_LANG['not_writable'], DATA_DIR . '/brandlogo', $_LANG['brandlogo_cannt_write']);
//        }
//
//        $result = file_mode_info('../' . DATA_DIR . '/cardimg');
//        if ($result < 2)
//        {
//            $warning[] = sprintf($_LANG['not_writable'], DATA_DIR . '/cardimg', $_LANG['cardimg_cannt_write']);
//        }
//
//        $result = file_mode_info('../' . DATA_DIR . '/feedbackimg');
//        if ($result < 2)
//        {
//            $warning[] = sprintf($_LANG['not_writable'], DATA_DIR . '/feedbackimg', $_LANG['feedbackimg_cannt_write']);
//        }
//
//        $result = file_mode_info('../' . DATA_DIR . '/packimg');
//        if ($result < 2)
//        {
//            $warning[] = sprintf($_LANG['not_writable'], DATA_DIR . '/packimg', $_LANG['packimg_cannt_write']);
//        }
//    }
//
    $result = file_mode_info('../images');
    if ($result < 2)
    {
        $warning[] = sprintf($_LANG['not_writable'], 'images', $_LANG['images_cannt_write']);
    }
    else
    {
        $result = file_mode_info('../' . IMAGE_DIR . '/editor_upload');
        if ($result < 2)
        {
            $warning[] = sprintf($_LANG['not_writable'], IMAGE_DIR . '/editor_upload', $_LANG['fck_upload_cannt_write']);
        }
    }

    $result = file_mode_info('../temp');
    if ($result < 2)
    {
        $warning[] = sprintf($_LANG['not_writable'], 'images', $_LANG['tpl_cannt_write']);
    }

//    $result = file_mode_info('../temp/backup');
//    if ($result < 2)
//    {
//        $warning[] = sprintf($_LANG['not_writable'], 'images', $_LANG['tpl_backup_cannt_write']);
//    }
//
//    if (!is_writeable('../' . DATA_DIR . '/order_print.html'))
//    {
//        $warning[] = $_LANG['order_print_canntwrite'];
//    }
    clearstatcache();

    $smarty->assign('warning_arr', $warning);

//    /* 管理員留言信息 */
//    $sql = 'SELECT message_id, sender_id, receiver_id, sent_time, readed, deleted, title, message, name ' .
//    'FROM ' . $chh->table('admin_message') . ' AS a, ' . $chh->table('admin_user') . ' AS b ' .
//    "WHERE a.sender_id = b.id AND a.receiver_id = '$_SESSION[admin_id]' AND ".
//    "a.readed = 0 AND deleted = 0 ORDER BY a.sent_time DESC";
//    $admin_msg = $db->GetAll($sql);
//
//    $smarty->assign('admin_msg', $admin_msg);
//
//    /* 取得支持貨到付款和不支持貨到付款的支付方式 */
//    $ids = get_pay_ids();
//
//    /* 已完成的訂單 */
//    $order['finished']     = $db->GetOne('SELECT COUNT(*) FROM ' . $chh->table('order_info').
//    " WHERE 1 " . order_query_sql('finished'));
//    $status['finished']    = CS_FINISHED;
//
//    /* 待發貨的訂單： */
//    $order['await_ship']   = $db->GetOne('SELECT COUNT(*)'.
//    ' FROM ' .$chh->table('order_info') .
//    " WHERE 1 " . order_query_sql('await_ship'));
//    $status['await_ship']  = CS_AWAIT_SHIP;
//
//    /* 待付款的訂單： */
//    $order['await_pay']    = $db->GetOne('SELECT COUNT(*)'.
//    ' FROM ' .$chh->table('order_info') .
//    " WHERE 1 " . order_query_sql('await_pay'));
//    $status['await_pay']   = CS_AWAIT_PAY;
//
//    /* 「未確認」的訂單 */
//    $order['unconfirmed']  = $db->GetOne('SELECT COUNT(*) FROM ' .$chh->table('order_info').
//    " WHERE 1 " . order_query_sql('unconfirmed'));
//    $status['unconfirmed'] = OS_UNCONFIRMED;
//
////    $today_start = mktime(0,0,0,date('m'),date('d'),date('Y'));
//    $order['stats']        = $db->getRow('SELECT COUNT(*) AS oCount, IFNULL(SUM(order_amount), 0) AS oAmount' .
//    ' FROM ' .$chh->table('order_info'));
//
//    $smarty->assign('order', $order);
//    $smarty->assign('status', $status);
//
//    /* 商品信息 */
//    $goods['total']   = $db->GetOne('SELECT COUNT(*) FROM ' .$chh->table('goods').
//    ' WHERE is_delete = 0 AND is_alone_sale = 1 AND is_real = 1');
//    $virtual_card['total'] = $db->GetOne('SELECT COUNT(*) FROM ' .$chh->table('goods').
//    ' WHERE is_delete = 0 AND is_alone_sale = 1 AND is_real=0 AND extension_code=\'virtual_card\'');
//
//    $goods['new']     = $db->GetOne('SELECT COUNT(*) FROM ' .$chh->table('goods').
//    ' WHERE is_delete = 0 AND is_new = 1 AND is_real = 1');
//    $virtual_card['new']     = $db->GetOne('SELECT COUNT(*) FROM ' .$chh->table('goods').
//    ' WHERE is_delete = 0 AND is_new = 1 AND is_real=0 AND extension_code=\'virtual_card\'');
//
//    $goods['best']    = $db->GetOne('SELECT COUNT(*) FROM ' .$chh->table('goods').
//    ' WHERE is_delete = 0 AND is_best = 1 AND is_real = 1');
//    $virtual_card['best']    = $db->GetOne('SELECT COUNT(*) FROM ' .$chh->table('goods').
//    ' WHERE is_delete = 0 AND is_best = 1 AND is_real=0 AND extension_code=\'virtual_card\'');
//
//    $goods['hot']     = $db->GetOne('SELECT COUNT(*) FROM ' .$chh->table('goods').
//    ' WHERE is_delete = 0 AND is_hot = 1 AND is_real = 1');
//    $virtual_card['hot']     = $db->GetOne('SELECT COUNT(*) FROM ' .$chh->table('goods').
//    ' WHERE is_delete = 0 AND is_hot = 1 AND is_real=0 AND extension_code=\'virtual_card\'');
//
//    $time             = gmtime();
//    $goods['promote'] = $db->GetOne('SELECT COUNT(*) FROM ' .$chh->table('goods').
//    ' WHERE is_delete = 0 AND promote_price>0' .
//    " AND promote_start_date <= '$time' AND promote_end_date >= '$time' AND is_real = 1");
//    $virtual_card['promote'] = $db->GetOne('SELECT COUNT(*) FROM ' .$chh->table('goods').
//    ' WHERE is_delete = 0 AND promote_price>0' .
//    " AND promote_start_date <= '$time' AND promote_end_date >= '$time' AND is_real=0 AND extension_code='virtual_card'");
//
//    /* 缺貨商品 */
//    if ($_CFG['use_storage'])
//    {
//        $sql = 'SELECT COUNT(*) FROM ' .$chh->table('goods'). ' WHERE is_delete = 0 AND goods_number <= warn_number AND is_real = 1';
//        $goods['warn'] = $db->GetOne($sql);
//        $sql = 'SELECT COUNT(*) FROM ' .$chh->table('goods'). ' WHERE is_delete = 0 AND goods_number <= warn_number AND is_real=0 AND extension_code=\'virtual_card\'';
//        $virtual_card['warn'] = $db->GetOne($sql);
//    }
//    else
//    {
//        $goods['warn'] = 0;
//        $virtual_card['warn'] = 0;
//    }
//    $smarty->assign('goods', $goods);
//    $smarty->assign('virtual_card', $virtual_card);
//
//    /* 訪問統計信息 */
//    $today  = local_getdate();
//    $sql    = 'SELECT COUNT(*) FROM ' .$chh->table('stats').
//    ' WHERE access_time > ' . (mktime(0, 0, 0, $today['mon'], $today['mday'], $today['year']) - date('Z'));
//
//    $today_visit = $db->GetOne($sql);
//    $smarty->assign('today_visit', $today_visit);
//
//    $online_users = $sess->get_users_count();
//    $smarty->assign('online_users', $online_users);
//
//    /* 最近反饋 */
//    $sql = "SELECT COUNT(f.msg_id) ".
//    "FROM " . $chh->table('feedback') . " AS f ".
//    "LEFT JOIN " . $chh->table('feedback') . " AS r ON r.parent_id=f.msg_id " .
//    'WHERE f.parent_id=0 AND ISNULL(r.msg_id) ' ;
//    $smarty->assign('feedback_number', $db->GetOne($sql));
//
//    /* 未審核評論 */
//    $smarty->assign('comment_number', $db->getOne('SELECT COUNT(*) FROM ' . $chh->table('comment') .
//    ' WHERE status = 0 AND parent_id = 0'));

    $mysql_ver = $db->version();   // 獲得 MySQL 版本

    /* 系統信息 */
    $sys_info['os']            = PHP_OS;
    $sys_info['ip']            = $_SERVER['SERVER_ADDR'];
    $sys_info['web_server']    = $_SERVER['SERVER_SOFTWARE'];
    $sys_info['php_ver']       = PHP_VERSION;
    $sys_info['mysql_ver']     = $mysql_ver;
    $sys_info['zlib']          = function_exists('gzclose') ? $_LANG['yes']:$_LANG['no'];
    $sys_info['safe_mode']     = (boolean) ini_get('safe_mode') ?  $_LANG['yes']:$_LANG['no'];
    $sys_info['safe_mode_gid'] = (boolean) ini_get('safe_mode_gid') ? $_LANG['yes'] : $_LANG['no'];
    $sys_info['timezone']      = function_exists("date_default_timezone_get") ? date_default_timezone_get() : $_LANG['no_timezone'];
    $sys_info['socket']        = function_exists('fsockopen') ? $_LANG['yes'] : $_LANG['no'];

    if ($gd == 0)
    {
        $sys_info['gd'] = 'N/A';
    }
    else
    {
        if ($gd == 1)
        {
            $sys_info['gd'] = 'GD1';
        }
        else
        {
            $sys_info['gd'] = 'GD2';
        }

        $sys_info['gd'] .= ' (';

        /* 檢查系統支持的圖片類型 */
        if ($gd && (imagetypes() & IMG_JPG) > 0)
        {
            $sys_info['gd'] .= ' JPEG';
        }

        if ($gd && (imagetypes() & IMG_GIF) > 0)
        {
            $sys_info['gd'] .= ' GIF';
        }

        if ($gd && (imagetypes() & IMG_PNG) > 0)
        {
            $sys_info['gd'] .= ' PNG';
        }

        $sys_info['gd'] .= ')';
    }

//    /* IP庫版本 */
//    $sys_info['ip_version'] = chh_geoip('255.255.255.0');

    /* 允許上傳的最大文件大小 */
    $sys_info['max_filesize'] = ini_get('upload_max_filesize');

    $smarty->assign('sys_info', $sys_info);

//    /* 缺貨登記 */
//    $smarty->assign('booking_goods', $db->getOne('SELECT COUNT(*) FROM ' . $chh->table('booking_goods') . ' WHERE is_dispose = 0'));
//
//    /* 退款申請 */
//    $smarty->assign('new_repay', $db->getOne('SELECT COUNT(*) FROM ' . $chh->table('user_account') . ' WHERE process_type = ' . SURPLUS_RETURN . ' AND is_paid = 0 '));



    assign_query_info();
//    $smarty->assign('chh_version',  VERSION);
//    $smarty->assign('chh_release',  RELEASE);
//    $smarty->assign('chh_lang',     $_CFG['lang']);
    $smarty->assign('chh_charset',  strtoupper(CHH_CHARSET));
//    $smarty->assign('install_date', local_date($_CFG['date_format'], $_CFG['install_date']));

    $smarty->display('start.htm');
}
//elseif ($_REQUEST['act'] == 'main_api')
//{
//        /* 如果管理員的最後登陸時間大於24小時則檢查最新版本 */
//    if (gmtime() - $_SESSION['last_check'] > (3600 * 12))
//    {
//
//        include_once(ROOT_PATH . 'includes/cls_transport.php');
//        $chh_version = VERSION;
//        $chh_lang = $_CFG['lang'];
//        $chh_release = RELEASE;
//        $php_ver = PHP_VERSION;
//        $mysql_ver = $db->version();
//        $order['stats'] = $db->getRow('SELECT COUNT(*) AS oCount, IFNULL(SUM(order_amount), 0) AS oAmount' .
//    ' FROM ' .$chh->table('order_info'));
//        $ocount = $order['stats']['oCount'];
//        $oamount = $order['stats']['oAmount'];
//        $goods['total']   = $db->GetOne('SELECT COUNT(*) FROM ' .$chh->table('goods').
//    ' WHERE is_delete = 0 AND is_alone_sale = 1 AND is_real = 1');
//        $gcount = $goods['total'];
//        $chh_charset = strtoupper(CHH_CHARSET);
//        $chh_user = $db->getOne('SELECT COUNT(*) FROM ' . $chh->table('users'));
//        $chh_template = $db->getOne('SELECT value FROM ' . $chh->table('config') . ' WHERE code = \'template\'');
//        $style = $db->getOne('SELECT value FROM ' . $chh->table('config') . ' WHERE code = \'stylename\'');
//        if($style == '')
//        {
//            $style = '0';
//        }
//        $chh_style = $style;
//        $shop_url = urlencode($chh->url());
//
//        $apiget = "ver= $chh_version &lang= $chh_lang &release= $chh_release &php_ver= $php_ver &mysql_ver= $mysql_ver &ocount= $ocount &oamount= $oamount &gcount= $gcount &charset= $chh_charset &usecount= $chh_user &template= $chh_template &style= $chh_style &url= $shop_url ";
//
//        $t = new transport;
//        $api_comment = $t->request('http://api.chhhop.com/checkver.php', $apiget);
//        $api_str = $api_comment["body"];
//        echo $api_str;
//    }
//}
///*------------------------------------------------------ */
////-- 開店嚮導第一步
///*------------------------------------------------------ */
//
//elseif ($_REQUEST['act'] == 'first')
//{
//    $smarty->assign('countries',    get_regions());
//    $smarty->assign('provinces',    get_regions(1, 1));
//    $smarty->assign('cities',    get_regions(2, 2));
//
//    $sql = 'SELECT value from ' . $chh->table('config') . " WHERE code='shop_name'";
//    $shop_name = $db->getOne($sql);
//
//    $smarty->assign('shop_name', $shop_name);
//
//    $sql = 'SELECT value from ' . $chh->table('config') . " WHERE code='shop_title'";
//    $shop_title = $db->getOne($sql);
//
//    $smarty->assign('shop_title', $shop_title);
//
//    //獲取配送方式
////    $modules = read_modules('../includes/modules/shipping');
//    $directory = ROOT_PATH . 'includes/modules/shipping';
//    $dir         = @opendir($directory);
//    $set_modules = true;
//    $modules     = array();
//
//    while (false !== ($file = @readdir($dir)))
//    {
//        if (preg_match("/^.*?\.php$/", $file))
//        {
//            if ($file != 'express.php')
//            {
//                include_once($directory. '/' .$file);
//            }
//        }
//    }
//    @closedir($dir);
//    unset($set_modules);
//
//    foreach ($modules AS $key => $value)
//    {
//        ksort($modules[$key]);
//    }
//    ksort($modules);
//
//    for ($i = 0; $i < count($modules); $i++)
//    {
//        $lang_file = ROOT_PATH.'languages/' .$_CFG['lang']. '/shipping/' .$modules[$i]['code']. '.php';
//
//        if (file_exists($lang_file))
//        {
//            include_once($lang_file);
//        }
//
//        $modules[$i]['name']    = $_LANG[$modules[$i]['code']];
//        $modules[$i]['desc']    = $_LANG[$modules[$i]['desc']];
//        $modules[$i]['insure_fee']  = empty($modules[$i]['insure'])? 0 : $modules[$i]['insure'];
//        $modules[$i]['cod']     = $modules[$i]['cod'];
//        $modules[$i]['install'] = 0;
//    }
//    $smarty->assign('modules', $modules);
//
//    unset($modules);
//
//    //獲取支付方式
//    $modules = read_modules('../includes/modules/payment');
//
//    for ($i = 0; $i < count($modules); $i++)
//    {
//        $code = $modules[$i]['code'];
//        $modules[$i]['name'] = $_LANG[$modules[$i]['code']];
//        if (!isset($modules[$i]['pay_fee']))
//        {
//            $modules[$i]['pay_fee'] = 0;
//        }
//        $modules[$i]['desc'] = $_LANG[$modules[$i]['desc']];
//    }
//    //        $modules[$i]['install'] = '0';
//    $smarty->assign('modules_payment', $modules);
//
//    assign_query_info();
//
//    $smarty->assign('ur_here', $_LANG['ur_config']);
//    $smarty->display('setting_first.htm');
//}
//
///*------------------------------------------------------ */
////-- 開店嚮導第二步
///*------------------------------------------------------ */
//
//elseif ($_REQUEST['act'] == 'second')
//{
//    admin_priv('config');
//
//    $shop_name = empty($_POST['shop_name']) ? '' : $_POST['shop_name'] ;
//    $shop_title = empty($_POST['shop_title']) ? '' : $_POST['shop_title'] ;
//    $shop_country = empty($_POST['shop_country']) ? '' : intval($_POST['shop_country']);
//    $shop_province = empty($_POST['shop_province']) ? '' : intval($_POST['shop_province']);
//    $shop_city = empty($_POST['shop_city']) ? '' : intval($_POST['shop_city']);
//    $shop_address = empty($_POST['shop_address']) ? '' : $_POST['shop_address'] ;
//    $shipping = empty($_POST['shipping']) ? '' : $_POST['shipping'];
//    $payment = empty($_POST['payment']) ? '' : $_POST['payment'];
//
//    if(!empty($shop_name))
//    {
//        $sql = 'UPDATE ' . $chh->table('config') . " SET value = '$shop_name' WHERE code = 'shop_name'";
//        $db->query($sql);
//    }
//
//    if(!empty($shop_title))
//    {
//        $sql = 'UPDATE ' . $chh->table('config') . " SET value = '$shop_title' WHERE code = 'shop_title'";
//        $db->query($sql);
//    }
//
//    if(!empty($shop_address))
//    {
//        $sql = 'UPDATE ' . $chh->table('config') . " SET value = '$shop_address' WHERE code = 'shop_address'";
//        $db->query($sql);
//    }
//
//    if(!empty($shop_country))
//    {
//        $sql = 'UPDATE ' . $chh->table('config') . "SET value = '$shop_country' WHERE code='shop_country'";
//        $db->query($sql);
//    }
//
//    if(!empty($shop_province))
//    {
//        $sql = 'UPDATE ' . $chh->table('config') . "SET value = '$shop_province' WHERE code='shop_province'";
//        $db->query($sql);
//    }
//
//    if(!empty($shop_city))
//    {
//        $sql = 'UPDATE ' . $chh->table('config') . "SET value = '$shop_city' WHERE code='shop_city'";
//        $db->query($sql);
//    }
//
//    //設置配送方式
//    if(!empty($shipping))
//    {
//        $set_modules = true;
//        include_once(ROOT_PATH . 'includes/modules/shipping/' . $shipping . '.php');
//        $sql = "SELECT shipping_id FROM " .$chh->table('shipping'). " WHERE shipping_code = '$shipping'";
//        $shipping_id = $db->GetOne($sql);
//
//        if($shipping_id <= 0)
//        {
//            $insure = empty($modules[0]['insure']) ? 0 : $modules[0]['insure'];
//            $sql = "INSERT INTO " . $chh->table('shipping') . " (" .
//            "shipping_code, shipping_name, shipping_desc, insure, support_cod, enabled" .
//            ") VALUES (" .
//            "'" . addslashes($modules[0]['code']). "', '" . addslashes($_LANG[$modules[0]['code']]) . "', '" .
//            addslashes($_LANG[$modules[0]['desc']]) . "', '$insure', '" . intval($modules[0]['cod']) . "', 1)";
//            $db->query($sql);
//            $shipping_id = $db->insert_Id();
//        }
//
//        //設置配送區域
//        $area_name = empty($_POST['area_name']) ? '' : $_POST['area_name'];
//        if(!empty($area_name))
//        {
//            $sql = "SELECT shipping_area_id FROM " .$chh->table("shipping_area").
//            " WHERE shipping_id='$shipping_id' AND shipping_area_name='$area_name'";
//            $area_id = $db->getOne($sql);
//
//            if($area_id <= 0)
//            {
//                $config = array();
//                foreach ($modules[0]['configure'] AS $key => $val)
//                {
//                    $config[$key]['name']   = $val['name'];
//                    $config[$key]['value']  = $val['value'];
//                }
//
//                $count = count($config);
//                $config[$count]['name']     = 'free_money';
//                $config[$count]['value']    = 0;
//
//                /* 如果支持貨到付款，則允許設置貨到付款支付費用 */
//                if ($modules[0]['cod'])
//                {
//                    $count++;
//                    $config[$count]['name']     = 'pay_fee';
//                    $config[$count]['value']    = make_semiangle(0);
//                }
//
//                $sql = "INSERT INTO " .$chh->table('shipping_area').
//                " (shipping_area_name, shipping_id, configure) ".
//                "VALUES" . " ('$area_name', '$shipping_id', '" .serialize($config). "')";
//                $db->query($sql);
//                $area_id = $db->insert_Id();
//            }
//
//            $region_id = empty($_POST['shipping_country']) ? 1 : intval($_POST['shipping_country']);
//            $region_id = empty($_POST['shipping_province']) ? $region_id : intval($_POST['shipping_province']);
//            $region_id = empty($_POST['shipping_city']) ? $region_id : intval($_POST['shipping_city']);
//            $region_id = empty($_POST['shipping_district']) ? $region_id : intval($_POST['shipping_district']);
//
//            /* 添加選定的城市和地區 */
//            $sql = "REPLACE INTO ".$chh->table('area_region')." (shipping_area_id, region_id) VALUES ('$area_id', '$region_id')";
//            $db->query($sql);
//        }
//    }
//
//    unset($modules);
//
//    if(!empty($payment))
//    {
//        /* 取相應插件信息 */
//        $set_modules = true;
//        include_once(ROOT_PATH.'includes/modules/payment/' . $payment . '.php');
//
//        $pay_config = array();
//        if (isset($_REQUEST['cfg_value']) && is_array($_REQUEST['cfg_value']))
//        {
//            for ($i = 0; $i < count($_POST['cfg_value']); $i++)
//            {
//                $pay_config[] = array('name'  => trim($_POST['cfg_name'][$i]),
//                                  'type'  => trim($_POST['cfg_type'][$i]),
//                                  'value' => trim($_POST['cfg_value'][$i])
//                );
//            }
//        }
//
//        $pay_config = serialize($pay_config);
//        /* 安裝，檢查該支付方式是否曾經安裝過 */
//        $sql = "SELECT COUNT(*) FROM " . $chh->table('payment') . " WHERE pay_code = '$payment'";
//        if ($db->GetOne($sql) > 0)
//        {
//            $sql = "UPDATE " . $chh->table('payment') .
//                   " SET pay_config = '$pay_config'," .
//                   " enabled = '1' " .
//                   "WHERE pay_code = '$payment' LIMIT 1";
//            $db->query($sql);
//        }
//        else
//        {
////            $modules = read_modules('../includes/modules/payment');
//
//            $payment_info = array();
//            $payment_info['name'] = $_LANG[$modules[0]['code']];
//            $payment_info['pay_fee'] = empty($modules[0]['pay_fee']) ? 0 : $modules[0]['pay_fee'];
//            $payment_info['desc'] = $_LANG[$modules[0]['desc']];
//
//            $sql = "INSERT INTO " . $chh->table('payment') . " (pay_code, pay_name, pay_desc, pay_config, is_cod, pay_fee, enabled, is_online)" .
//            "VALUES ('$payment', '$payment_info[name]', '$payment_info[desc]', '$pay_config', '0', '$payment_info[pay_fee]', '1', '1')";
//            $db->query($sql);
//        }
//    }
//
//    clear_all_files();
//
//    assign_query_info();
//
//    $smarty->assign('ur_here', $_LANG['ur_add']);
//    $smarty->display('setting_second.htm');
//}
//
///*------------------------------------------------------ */
////-- 開店嚮導第三步
///*------------------------------------------------------ */
//
//elseif ($_REQUEST['act'] == 'third')
//{
//    admin_priv('goods_manage');
//
//    $good_name = empty($_POST['good_name']) ? '' : $_POST['good_name'];
//    $good_number = empty($_POST['good_number']) ? '' : $_POST['good_number'];
//    $good_category = empty($_POST['good_category']) ? '' : $_POST['good_category'];
//    $good_brand = empty($_POST['good_brand']) ? '' : $_POST['good_brand'];
//    $good_price = empty($_POST['good_price']) ? 0 : $_POST['good_price'];
//    $good_name = empty($_POST['good_name']) ? '' : $_POST['good_name'];
//    $is_best = empty($_POST['is_best']) ? 0 : 1;
//    $is_new = empty($_POST['is_new']) ? 0 : 1;
//    $is_hot = empty($_POST['is_hot']) ? 0 :1;
//    $good_brief = empty($_POST['good_brief']) ? '' : $_POST['good_brief'];
//    $market_price = $good_price * 1.2;
//
//    if(!empty($good_category))
//    {
//        if (cat_exists($good_category, 0))
//        {
//            /* 同級別下不能有重複的分類名稱 */
//            $link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
//            sys_msg($_LANG['catname_exist'], 0, $link);
//        }
//    }
//
//    if(!empty($good_brand))
//    {
//        if (brand_exists($good_brand))
//        {
//            /* 同級別下不能有重複的品牌名稱 */
//            $link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
//            sys_msg($_LANG['brand_name_exist'], 0, $link);
//        }
//    }
//
//    $brand_id = 0;
//    if(!empty($good_brand))
//    {
//        $sql = 'INSERT INTO ' . $chh->table('brand') . " (brand_name, is_show)" .
//        " values('" . $good_brand . "', '1')";
//        $db->query($sql);
//
//        $brand_id = $db->insert_Id();
//    }
//
//    if(!empty($good_category))
//    {
//        $sql = 'INSERT INTO ' . $chh->table('category') . " (cat_name, parent_id, is_show)" .
//        " values('" . $good_category . "', '0', '1')";
//        $db->query($sql);
//
//        $cat_id = $db->insert_Id();
//
//        //貨號
//        require_once(ROOT_PATH . 'admin/includes/lib_goods.php');
//        $max_id     = $db->getOne("SELECT MAX(goods_id) + 1 FROM ".$chh->table('goods'));
//        $goods_sn   = generate_goods_sn($max_id);
//
//        include_once(ROOT_PATH . 'includes/cls_image.php');
//        $image = new cls_image($_CFG['bgcolor']);
//
//        if(!empty($good_name))
//        {
//            /* 檢查圖片：如果有錯誤，檢查尺寸是否超過最大值；否則，檢查文件類型 */
//            if (isset($_FILES['goods_img']['error'])) // php 4.2 版本才支持 error
//            {
//                // 最大上傳文件大小
//                $php_maxsize = ini_get('upload_max_filesize');
//                $htm_maxsize = '2M';
//
//                // 商品圖片
//                if ($_FILES['goods_img']['error'] == 0)
//                {
//                    if (!$image->check_img_type($_FILES['goods_img']['type']))
//                    {
//                        sys_msg($_LANG['invalid_goods_img'], 1, array(), false);
//                    }
//                }
//                elseif ($_FILES['goods_img']['error'] == 1)
//                {
//                    sys_msg(sprintf($_LANG['goods_img_too_big'], $php_maxsize), 1, array(), false);
//                }
//                elseif ($_FILES['goods_img']['error'] == 2)
//                {
//                    sys_msg(sprintf($_LANG['goods_img_too_big'], $htm_maxsize), 1, array(), false);
//                }
//            }
//            /* 4。1版本 */
//            else
//            {
//                // 商品圖片
//                if ($_FILES['goods_img']['tmp_name'] != 'none')
//                {
//                    if (!$image->check_img_type($_FILES['goods_img']['type']))
//                    {
//                        sys_msg($_LANG['invalid_goods_img'], 1, array(), false);
//                    }
//                }
//
//
//            }
//            $goods_img        = '';  // 初始化商品圖片
//            $goods_thumb      = '';  // 初始化商品縮略圖
//            $original_img     = '';  // 初始化原始圖片
//            $old_original_img = '';  // 初始化原始圖片舊圖
//            // 如果上傳了商品圖片，相應處理
//            if ($_FILES['goods_img']['tmp_name'] != '' && $_FILES['goods_img']['tmp_name'] != 'none')
//            {
//
//                $original_img   = $image->upload_image($_FILES['goods_img']); // 原始圖片
//                if ($original_img === false)
//                {
//                    sys_msg($image->error_msg(), 1, array(), false);
//                }
//                $goods_img      = $original_img;   // 商品圖片
//
//                /* 複製一份相冊圖片 */
//                $img        = $original_img;   // 相冊圖片
//                $pos        = strpos(basename($img), '.');
//                $newname    = dirname($img) . '/' . $image->random_filename() . substr(basename($img), $pos);
//                if (!copy('../' . $img, '../' . $newname))
//                {
//                    sys_msg('fail to copy file: ' . realpath('../' . $img), 1, array(), false);
//                }
//                $img        = $newname;
//
//                $gallery_img    = $img;
//                $gallery_thumb  = $img;
//
//                // 如果系統支持GD，縮放商品圖片，且給商品圖片和相冊圖片加水印
//                if ($image->gd_version() > 0 && $image->check_img_function($_FILES['goods_img']['type']))
//                {
//                    // 如果設置大小不為0，縮放圖片
//                    if ($_CFG['image_width'] != 0 || $_CFG['image_height'] != 0)
//                    {
//                        $goods_img = $image->make_thumb('../'. $goods_img , $GLOBALS['_CFG']['image_width'],  $GLOBALS['_CFG']['image_height']);
//                        if ($goods_img === false)
//                        {
//                            sys_msg($image->error_msg(), 1, array(), false);
//                        }
//                    }
//
//                    $newname    = dirname($img) . '/' . $image->random_filename() . substr(basename($img), $pos);
//                    if (!copy('../' . $img, '../' . $newname))
//                    {
//                        sys_msg('fail to copy file: ' . realpath('../' . $img), 1, array(), false);
//                    }
//                    $gallery_img        = $newname;
//
//                    // 加水印
//                    if (intval($_CFG['watermark_place']) > 0 && !empty($GLOBALS['_CFG']['watermark']))
//                    {
//                        if ($image->add_watermark('../'.$goods_img,'',$GLOBALS['_CFG']['watermark'], $GLOBALS['_CFG']['watermark_place'], $GLOBALS['_CFG']['watermark_alpha']) === false)
//                        {
//                            sys_msg($image->error_msg(), 1, array(), false);
//                        }
//
//                        if ($image->add_watermark('../'. $gallery_img,'',$GLOBALS['_CFG']['watermark'], $GLOBALS['_CFG']['watermark_place'], $GLOBALS['_CFG']['watermark_alpha']) === false)
//                        {
//                            sys_msg($image->error_msg(), 1, array(), false);
//                        }
//                    }
//
//                    // 相冊縮略圖
//                    if ($_CFG['thumb_width'] != 0 || $_CFG['thumb_height'] != 0)
//                    {
//                        $gallery_thumb = $image->make_thumb('../' . $img, $GLOBALS['_CFG']['thumb_width'],  $GLOBALS['_CFG']['thumb_height']);
//                        if ($gallery_thumb === false)
//                        {
//                            sys_msg($image->error_msg(), 1, array(), false);
//                        }
//                    }
//                }
//                else
//                {
//                    /* 複製一份原圖 */
//                    $pos        = strpos(basename($img), '.');
//                    $gallery_img = dirname($img) . '/' . $image->random_filename() . substr(basename($img), $pos);
//                    if (!copy('../' . $img, '../' . $gallery_img))
//                    {
//                        sys_msg('fail to copy file: ' . realpath('../' . $img), 1, array(), false);
//                    }
//                    $gallery_thumb = '';
//                }
//            }
//            // 未上傳，如果自動選擇生成，且上傳了商品圖片，生成所略圖
//            if (!empty($original_img))
//            {
//                // 如果設置縮略圖大小不為0，生成縮略圖
//                if ($_CFG['thumb_width'] != 0 || $_CFG['thumb_height'] != 0)
//                {
//                    $goods_thumb = $image->make_thumb('../' . $original_img, $GLOBALS['_CFG']['thumb_width'],  $GLOBALS['_CFG']['thumb_height']);
//                    if ($goods_thumb === false)
//                    {
//                        sys_msg($image->error_msg(), 1, array(), false);
//                    }
//                }
//                else
//                {
//                    $goods_thumb = $original_img;
//                }
//            }
//
//
//            $sql = 'INSERT INTO ' . $chh->table('goods') . "(goods_name, goods_sn, goods_number, cat_id, brand_id, goods_brief, shop_price, market_price, goods_img, goods_thumb, original_img,add_time, last_update,
//                   is_best, is_new, is_hot)" .
//                   "VALUES('$good_name', '$goods_sn', '$good_number', '$cat_id', '$brand_id', '$good_brief', '$good_price'," .
//                   " '$market_price', '$goods_img', '$goods_thumb', '$original_img','" . gmtime() . "', '". gmtime() . "', '$is_best', '$is_new', '$is_hot')";
//
//                   $db->query($sql);
//                   $good_id = $db->insert_id();
//                   /* 如果有圖片，把商品圖片加入圖片相冊 */
//                   if (isset($img))
//                   {
//                       $sql = "INSERT INTO " . $chh->table('goods_gallery') . " (goods_id, img_url, img_desc, thumb_url, img_original) " .
//                       "VALUES ('$good_id', '$gallery_img', '', '$gallery_thumb', '$img')";
//                       $db->query($sql);
//                   }
//
//        }
//    }
//
//    assign_query_info();
//    //    $smarty->assign('ur_here', '開店嚮導－添加商品');
//    $smarty->display('setting_third.htm');
//}
//
///*------------------------------------------------------ */
////-- 關於 CHH
///*------------------------------------------------------ */
//
//elseif ($_REQUEST['act'] == 'config_us')
//{
//    assign_query_info();
//    $smarty->display('config_us.htm');
//}
//
/*------------------------------------------------------ */
//-- 拖動的幀
/*------------------------------------------------------ */

elseif ($_REQUEST['act'] == 'drag')
{
    $smarty->display('drag.htm');;
}

///*------------------------------------------------------ */
////-- 檢查訂單
///*------------------------------------------------------ */
//elseif ($_REQUEST['act'] == 'check_order')
//{
//    if (empty($_SESSION['last_check']))
//    {
//        $_SESSION['last_check'] = gmtime();
//
//        make_json_result('', '', array('new_orders' => 0, 'new_paid' => 0));
//    }
//
//    /* 新訂單 */
//    $sql = 'SELECT COUNT(*) FROM ' . $chh->table('order_info').
//    " WHERE add_time >= '$_SESSION[last_check]'";
//    $arr['new_orders'] = $db->getOne($sql);
//
//    /* 新付款的訂單 */
//    $sql = 'SELECT COUNT(*) FROM '.$chh->table('order_info').
//    ' WHERE pay_time >= ' . $_SESSION['last_check'];
//    $arr['new_paid'] = $db->getOne($sql);
//
//    $_SESSION['last_check'] = gmtime();
//
//    if (!(is_numeric($arr['new_orders']) && is_numeric($arr['new_paid'])))
//    {
//        make_json_error($db->error());
//    }
//    else
//    {
//        make_json_result('', '', $arr);
//    }
//}
//
///*------------------------------------------------------ */
////-- Totolist操作
///*------------------------------------------------------ */
//elseif ($_REQUEST['act'] == 'save_todolist')
//{
//    $content = json_str_iconv($_POST["content"]);
//    $sql = "UPDATE" .$GLOBALS['chh']->table('admin_user'). " SET todolist='" . $content . "' WHERE id = " . $_SESSION['admin_id'];
//    $GLOBALS['db']->query($sql);
//}
//
//elseif ($_REQUEST['act'] == 'get_todolist')
//{
//    $sql     = "SELECT todolist FROM " .$GLOBALS['chh']->table('admin_user'). " WHERE id = " . $_SESSION['admin_id'];
//    $content = $GLOBALS['db']->getOne($sql);
//    echo $content;
//}
//// 郵件群發處理
//elseif ($_REQUEST['act'] == 'send_mail')
//{
//    if ($_CFG['send_mail_on'] == 'off')
//    {
//        make_json_result('', $_LANG['send_mail_off'], 0);
//        exit();
//    }
//    $sql = "SELECT * FROM " . $chh->table('email_sendlist') . " ORDER BY pri DESC, last_send ASC LIMIT 1";
//    $row = $db->getRow($sql);
//
//    //發送列表為空
//    if (empty($row['id']))
//    {
//        make_json_result('', $_LANG['mailsend_null'], 0);
//    }
//
//    //發送列表不為空，郵件地址為空
//    if (!empty($row['id']) && empty($row['email']))
//    {
//        $sql = "DELETE FROM " . $chh->table('email_sendlist') . " WHERE id = '$row[id]'";
//        $db->query($sql);
//        $count = $db->getOne("SELECT COUNT(*) FROM " . $chh->table('email_sendlist'));
//        make_json_result('', $_LANG['mailsend_skip'], array('count' => $count, 'goon' => 1));
//    }
//
//    //查詢相關模板
//    $sql = "SELECT * FROM " . $chh->table('mail_templates') . " WHERE template_id = '$row[template_id]'";
//    $rt = $db->getRow($sql);
//
//    //如果是模板，則將已存入email_sendlist的內容作為郵件內容
//    //否則即是雜質，將mail_templates調出的內容作為郵件內容
//    if ($rt['type'] == 'template')
//    {
//        $rt['template_content'] = $row['email_content'];
//    }
//
//    if ($rt['template_id'] && $rt['template_content'])
//    {
//        if (send_mail('', $row['email'], $rt['template_subject'], $rt['template_content'], $rt['is_html']))
//        {
//            //發送成功
//
//            //從列表中刪除
//            $sql = "DELETE FROM " . $chh->table('email_sendlist') . " WHERE id = '$row[id]'";
//            $db->query($sql);
//
//            //剩餘列表數
//            $count = $db->getOne("SELECT COUNT(*) FROM " . $chh->table('email_sendlist'));
//
//            if($count > 0)
//            {
//                $msg = sprintf($_LANG['mailsend_ok'],$row['email'],$count);
//            }
//            else
//            {
//                $msg = sprintf($_LANG['mailsend_finished'],$row['email']);
//            }
//            make_json_result('', $msg, array('count' => $count));
//        }
//        else
//        {
//            //發送出錯
//
//            if ($row['error'] < 3)
//            {
//                $time = time();
//                $sql = "UPDATE " . $chh->table('email_sendlist') . " SET error = error + 1, pri = 0, last_send = '$time' WHERE id = '$row[id]'";
//            }
//            else
//            {
//                //將出錯超次的紀錄刪除
//                $sql = "DELETE FROM " . $chh->table('email_sendlist') . " WHERE id = '$row[id]'";
//            }
//            $db->query($sql);
//
//            $count = $db->getOne("SELECT COUNT(*) FROM " . $chh->table('email_sendlist'));
//            make_json_result('', sprintf($_LANG['mailsend_fail'],$row['email']), array('count' => $count));
//        }
//    }
//    else
//    {
//        //無效的郵件隊列
//        $sql = "DELETE FROM " . $chh->table('email_sendlist') . " WHERE id = '$row[id]'";
//        $db->query($sql);
//        $count = $db->getOne("SELECT COUNT(*) FROM " . $chh->table('email_sendlist'));
//        make_json_result('', sprintf($_LANG['mailsend_fail'],$row['email']), array('count' => $count));
//    }
//}
//
///*------------------------------------------------------ */
////-- license操作
///*------------------------------------------------------ */
//elseif ($_REQUEST['act'] == 'license')
//{
//    $is_ajax = $_GET['is_ajax'];
//
//    if (isset($is_ajax) && $is_ajax)
//    {
//        // license 檢查
//        include_once(ROOT_PATH . 'includes/cls_transport.php');
//        include_once(ROOT_PATH . 'includes/cls_json.php');
//        include_once(ROOT_PATH . 'includes/lib_main.php');
//        include_once(ROOT_PATH . 'includes/lib_license.php');
//
//        $license = license_check();
//        switch ($license['flag'])
//        {
//            case 'login_succ':
//                if (isset($license['request']['info']['service']['chh_b2c']['cert_auth']['auth_str']) && $license['request']['info']['service']['chh_b2c']['cert_auth']['auth_str'] != '')
//                {
//                    make_json_result(process_login_license($license['request']['info']['service']['chh_b2c']['cert_auth']));
//                }
//                else
//                {
//                    make_json_error(0);
//                }
//            break;
//
//            case 'login_fail':
//            case 'login_ping_fail':
//                make_json_error(0);
//            break;
//
//            case 'reg_succ':
//                $_license = license_check();
//                switch ($_license['flag'])
//                {
//                    case 'login_succ':
//                        if (isset($_license['request']['info']['service']['chh_b2c']['cert_auth']['auth_str']) && $_license['request']['info']['service']['chh_b2c']['cert_auth']['auth_str'] != '')
//                        {
//                            make_json_result(process_login_license($license['request']['info']['service']['chh_b2c']['cert_auth']));
//                        }
//                        else
//                        {
//                            make_json_error(0);
//                        }
//                    break;
//
//                    case 'login_fail':
//                    case 'login_ping_fail':
//                        make_json_error(0);
//                    break;
//                }
//            break;
//
//            case 'reg_fail':
//            case 'reg_ping_fail':
//                make_json_error(0);
//            break;
//        }
//    }
//    else
//    {
//        make_json_error(0);
//    }
//}
//
///**
// * license check
// * @return  bool
// */
//function license_check()
//{
//    // return 返回數組
//    $return_array = array();
//
//    // 取出網店 license
//    $license = get_shop_license();
//
//    // 檢測網店 license
//    if (!empty($license['certificate_id']) && !empty($license['token']) && !empty($license['certi']))
//    {
//        // license（登錄）
//        $return_array = license_login();
//    }
//    else
//    {
//        // license（註冊）
//        $return_array = license_reg();
//    }
//
//    return $return_array;
//}

function create_sub_tree_html($menus){
	$str = '';
	foreach($menus as $v){
		if(count($v['childs']) > 0){
			$t = create_sub_tree_html($v);
			$str .= '<li><span class="folder">'.$v['name'].'</span>'.$t.'</li>';
		}else{
			if($v['url'] != ''){
				$v['name'] = '<a href="'.$v['url'].'" target="main-frame">'.$v['name'].'</a>';
			}
			$str .= '<li><span class="file">'.$v['name'].'</span></li>';
		}
	}
	$str ='<ul>'.$str.'</ul>'; 
	return $str;
}
?>