<?php

/**
 * CHH 系統設置網站設置
 * ============================================================================
 *
 *
 * ============================================================================
 * Author: shsing1
 * Id: config.php 2009-11-27 12:00:00
*/

define('IN_CHH', true);

require_once(dirname(__FILE__) . '/includes/init.php');

require_once(ROOT_PATH . '/includes/cls_config_cat.php');
$cat = new cls_config_cat($db, $chh->table("config_cat") );

require_once(ROOT_PATH . '/includes/cls_config.php');
$data = new cls_config($db, $chh->table("config"), $cat);

/* act操作項的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'edit';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}
/* 設定功能路徑 */
require_once(ROOT_PATH . '/includes/cls_sys_menu.php');
$sys_menu = new cls_sys_menu($db, $chh->table("sys_menu") );
$ur_here = $sys_menu->get_ur_here(19);
$smarty->assign('ur_here',     $ur_here);

/*------------------------------------------------------ */
//-- 依act進行應對動作
/*------------------------------------------------------ */
switch($_REQUEST['act'] ){
/*------------------------------------------------------ */
//-- 編輯資料
/*------------------------------------------------------ */
	case 'edit':
		/* 可選語言 */
		$dir = opendir('../languages');
		$lang_list = array();
		while (@$file = readdir($dir))
		{
			if ($file != '.' && $file != '..' &&  $file != '.svn' && $file != '_svn' && is_dir('../languages/' .$file))
			{
				$lang_list[] = $file;
			}
		}
		@closedir($dir);
	
		$smarty->assign('lang_list',    $lang_list);
		
		/* 獲取分類列表 */
		$cat_list = $cat->get_list();
	
		foreach($cat_list as $k=>$v){
			/* 如果不是最高管理員刪除未啟用的項目 */
			if($_SESSION['admin_cat_id'] != 2 && $v['is_show'] == 0){
				
				unset($cat_list[$k]);
				continue;
			}
			$_REQUEST['cat_id'] = $v['id'];
			$tmg = $data->get_list(true);
			foreach($tmg['list'] as $k2=>$v2){
				/* 如果不是最高管理員刪除未啟用的項目 */
				if($_SESSION['admin_cat_id'] != 2 && $v2['is_show'] == 0){
					
					unset($tmg['list'][$k2]);
					continue;
				}
				
			}
			$cat_list[$k]['data'] = $tmg['list'];
		}
		
		$smarty->assign('cat_list',    	$cat_list);
	
		$smarty->assign('form_act',    'update');
	
		/* 顯示頁面 */
		assign_query_info();
		$smarty->assign('ur_here',     $ur_here );
		$smarty->display('config_set_info.htm');

		break;
/*------------------------------------------------------ */
//-- 編輯資料
/*------------------------------------------------------ */
	case 'update':
		$data_list = isset($_POST['data'])	?	$_POST['data']	: array();
		foreach($data_list as $k=>$v){
			$field['id']				= !empty($k)     				? intval($k)     			: 0;
			$field['value']    			= isset($v)     				? trim($v)     				: '';
			
			if(empty($field['id'])){
				make_json_error($_LANG['id_empty']);
			}
			
			if(!$data->upd($field)){
				make_json_error($_LANG['data_upd_failed']);
			}
	
		}
	
		make_json_result('', $_LANG['data_upd_succed'], array(	'upload'=>'config_img',
																'url'=>'config_set.php' ));

		break;
/*------------------------------------------------------ */
//-- 上傳檔案的處理
/*------------------------------------------------------ */
	case 'upload_file':
		$id = !isset($_REQUEST['id'])	?	0		:	intval($_REQUEST['id']);
		$op = !isset($_REQUEST['op'])	?	'add'	:	trim($_REQUEST['op']);
	
		if(!$data->upload_img($_FILES, $id)){
			make_json_error($_LANG['upload_img_failed']);
		}
		
		make_json_result('', $_LANG['data_upd_succed'], array('url'=>'config_set.php'));

		break;
/*------------------------------------------------------ */
//-- 發送測試郵件
/*------------------------------------------------------ */
	case 'send_test_email':
		/* 取得參數 */
		$email	=	!isset($_POST['test_email'])	?	''	:	trim($_POST['test_email']);
	
		/* 更新配置 */
		$_CFG['mail_service'] = intval($_POST['mail_service']);
		$_CFG['smtp_host']    = trim($_POST['smtp_host']);
		$_CFG['smtp_port']    = trim($_POST['smtp_port']);
		$_CFG['smtp_user']    = json_str_iconv(trim($_POST['smtp_user']));
		$_CFG['smtp_pass']    = trim($_POST['smtp_pass']);
		$_CFG['smtp_mail']    = trim($_POST['reply_email']);
		$_CFG['mail_charset'] = trim($_POST['mail_charset']);
	
		if (send_mail('', $email, $_LANG['test_mail_title'], $_LANG['email_content'], 0))
		{
			make_json_result('', $_LANG['sendemail_success'] . $email);
		}
		else
		{
			make_json_error(join("\n", $err->_message));
		}

		break;
/*------------------------------------------------------ */
//-- 刪除所上傳的檔案
/*------------------------------------------------------ */
	case 'del_file':
		$id	=	!isset($_REQUEST['id'])	?	0	:	intval($_REQUEST['id']);
	
		if(!$data->del_file($id)){
			make_json_error($_LANG['file_del_failed']);
		}
		
		make_json_result('', $_LANG['file_del_succed'], array('url'=>'config_set.php'));

		break;
	default:
		break;
}
?>