<?php

/**
 * CHH 聯絡我們資料管理
 * ============================================================================
 *
 *
 * ============================================================================
 * Author: shsing1
 * Id: kscontact.php 2009-11-27 12:00:00
*/

define('IN_CHH', true);

require_once(dirname(__FILE__) . '/includes/init.php');

require_once(ROOT_PATH . '/includes/cls_kscontact_cat.php');
$cat = new cls_kscontact_cat($db, $chh->table("kscontact_cat") );

require_once(ROOT_PATH . '/includes/cls_kscontact.php');
$data = new cls_kscontact($db, $chh->table("kscontact"), $cat);

require_once(ROOT_PATH . '/includes/cls_kscontact_reply.php');
$data_reply = new cls_kscontact_reply($db, $chh->table("kscontact_reply") );

require_once(ROOT_PATH . '/includes/cls_admin_cat.php');
$cat_admin = new cls_admin_cat($db, $chh->table("admin_cat") );

require_once(ROOT_PATH . '/includes/cls_admin.php');
$data_admin = new cls_admin($db, $chh->table("admin_user"), $cat_admin);


/* act操作項的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}
/* 設定功能路徑 */
require_once(ROOT_PATH . '/includes/cls_sys_menu.php');
$sys_menu = new cls_sys_menu($db, $chh->table("sys_menu") );
$ur_here = $sys_menu->get_ur_here(122);
$smarty->assign('ur_here',     $ur_here);

/*------------------------------------------------------ */
//-- 依act進行應對動作
/*------------------------------------------------------ */
switch($_REQUEST['act'] ){	
/*------------------------------------------------------ */
//-- 資料列表
/*------------------------------------------------------ */
	case 'list':
		/* 獲取資料列表 */
		$data_list = $data->get_list();
		
		/* 設定分類預設值 */
		$cat_id	=	!isset($_REQUEST['cat_id'])	?	0	:	intval($_REQUEST['cat_id']);
		
		/* 取得分類選項 */
		$cat_select = $cat->get_list_option(1, $cat_id, 1);
		$smarty->assign('cat_list',  $cat_select);
		
		/* 設定搜尋關鍵字預設值 */
		$serach_keyword	=	!isset($_REQUEST['keyword'])	?	''	:	trim($_REQUEST['keyword']);
		$smarty->assign('serach_keyword',  $serach_keyword);
		
		/* 取得分類選項for轉移分類用 */
		$cat_select = $cat->get_list_option();
		$smarty->assign('cat_list_all',  $cat_select);
	
	
		/* 模板賦值 */
		if($_SESSION['admin_cat_id']==2){
		$smarty->assign('action_link',  array('href' => 'kscontact.php?act=add', 'text' => $_LANG['data_add']));
		}
		$smarty->assign('full_page',    1);
	
		$smarty->assign('data_list',	$data_list['list']);
		$smarty->assign('filter',		$data_list['filter']);
		
		/* 排序標記 */
		$sort_flag  = sort_flag($data_list['filter']);
		$smarty->assign($sort_flag['tag'], $sort_flag['img']);
	
		/* 列表頁面 */
		assign_query_info();
		$smarty->display('kscontact_list.htm');
		
		break;		
/*------------------------------------------------------ */
//-- 排序、分頁、查詢
/*------------------------------------------------------ */
	case 'query':
	
		/* 獲取資料列表 */
		$data_list = $data->get_list();
		
		/* 取得分類選項 */
		$cat_select = $cat->get_list_option(1, 0, 1);
		$smarty->assign('cat_list',  $cat_select);
	
		/* 模板賦值 */
		$smarty->assign('action_link',  array('href' => 'kscontact.php?act=add', 'text' => $_LANG['data_add']));
	
		$smarty->assign('data_list',	$data_list['list']);
		$smarty->assign('filter',		$data_list['filter']);
		
		/* 排序標記 */
		$sort_flag  = sort_flag($data_list['filter']);
		$smarty->assign($sort_flag['tag'], $sort_flag['img']);
	
		/* 列表頁面 */
		assign_query_info();
		
		make_json_result(	$smarty->fetch('kscontact_list.htm'), 
							'',
							array(	'filter' => $data_list['filter'], 'page_count' => $data_list['page_count'] )
						);
		break;		
/*------------------------------------------------------ */
//-- 添加資料
/*------------------------------------------------------ */
	case 'add':	
		/* 模板賦值 */
		$smarty->assign('action_link',  array('href' => 'kscontact.php?act=list', 'text' => $_LANG['data_list']));
		
		$cat_select = $cat->get_list_option();
		$smarty->assign('cat_select',   $cat_select);
		
		$smarty->assign('form_act',     'insert');
		$smarty->assign('data_info',     array('is_show' => 1));
	
		/* 顯示頁面 */
		assign_query_info();
		$smarty->display('kscontact_info.htm');
		
		break;
/*------------------------------------------------------ */
//-- 資料添加時的處理
/*------------------------------------------------------ */
	case 'insert':	
		/* 初始化變量 */
		$field['name']     			= !isset($_POST['name'])     		?	''	: trim($_POST['name']);
		$field['cat_id']   			= !isset($_POST['cat_id'])     		?	1	: intval($_POST['cat_id']);
		$field['email']				= !isset($_POST['email'])   		?	''	: trim($_POST['email']);
		$field['phone']				= !isset($_POST['phone'])			?	''	: trim($_POST['phone']);
		$field['sort']   			= !isset($_POST['sort'])     		?	0	: intval($_POST['sort']);
		$field['content']     		= !isset($_POST['content'])    		?	''	: trim($_POST['content']);
		$field['add_time']			= gmtime();
		
		/* 參數檢查 */
		if($field['name'] == ''){
			make_json_error($_LANG['name_empty']);
		}
		
		/* email檢查 */
		if(!is_email($field['email'])){
			make_json_error($_LANG['email_invalid']);
		}

		/* phone檢查 */
		if(!is_phone($field['phone'])){
			make_json_error($_LANG['phone_invalid']);
		}

		/* 參數檢查 */
		if($field['content'] == ''){
			make_json_error($_LANG['content_empty']);
		}

		/* 資料入庫 */
		if(!$data->add($field)){
			make_json_error($_LANG['data_add_failed']);
		}
		
		/* 發送新增email */
		$smarty->assign('data_info',	$field);
		$content = $smarty->fetch('kscontact_add_mail_tpl.htm');
		if (!send_mail($_CFG['site_name'], $_CFG['service_email'], $_LANG['add_mail_title'], $content, 1))
		{
			make_json_error(join("\n", $err->_message));
		}

		if (!send_mail($field['name'], $field['email'], $_LANG['add_mail_title'], $content, 1))
		{
			make_json_error(join("\n", $err->_message));
		}

		make_json_result('', $_LANG['data_add_succed'], array('url'=>'kscontact.php?'.get_last_filter_url() ) );
		
		break;
/*------------------------------------------------------ */
//-- 編輯資料
/*------------------------------------------------------ */
	case 'edit':	
		$id	=	!isset($_REQUEST['id'])	?	0	:	intval($_REQUEST['id']);
	
		$data_info = $data->get_info($id);
		
		$data_info['sex_name'] = $data_info['sex']==1?'男':'女';
		
		$smarty->assign('action_link', array('text' => $_LANG['data_list'], 'href' => 'kscontact.php?act=list'));
		
		$cat_select = $cat->get_list_option(1, $data_info['cat_id']);
		$smarty->assign('cat_select',   $cat_select);
	
		$smarty->assign('data_info',    $data_info);
		$smarty->assign('form_act',    'update');
		$smarty->assign('data_select',  $data_select);
	
		/* 顯示頁面 */
		assign_query_info();
		$smarty->assign('ur_here',     $ur_here . ' - '.$data_info['name'] );
		$smarty->display('kscontact_info.htm');
		
		break;
/*------------------------------------------------------ */
//-- 編輯資料後的處理
/*------------------------------------------------------ */
	case 'update':	
		/* 初始化變量 */
		$field['id']				= !isset($_POST['id'])     			?	0	: intval($_POST['id']);
		$field['name']     			= !isset($_POST['name'])     		?	''	: trim($_POST['name']);
		$field['cat_id']   			= !isset($_POST['cat_id'])     		?	1	: intval($_POST['cat_id']);
		$field['email']				= !isset($_POST['email'])   		?	''	: trim($_POST['email']);
		$field['phone']				= !isset($_POST['phone'])			?	''	: trim($_POST['phone']);
		$field['sort']   			= !isset($_POST['sort'])     		?	0	: intval($_POST['sort']);
		$field['content']     		= !isset($_POST['content'])    		?	''	: trim($_POST['content']);
	
		/* 參數檢查 */
		if($field['name'] == ''){
			make_json_error($_LANG['name_empty']);
		}
		
		/* email檢查 */
		if(!is_email($field['email'])){
			make_json_error($_LANG['email_invalid']);
		}

		/* phone檢查 */
		if(!is_phone($field['phone'])){
			make_json_error($_LANG['phone_invalid']);
		}

		/* 參數檢查 */
		if($field['content'] == ''){
			make_json_error($_LANG['content_empty']);
		}
		
		if(!$data->upd($field)){
			make_json_error($_LANG['data_upd_failed']);
		}
		
		make_json_result('', $_LANG['data_upd_succed'], array('url'=>'kscontact.php?'.get_last_filter_url() ) );
		
		break;
/*------------------------------------------------------ */
//-- 複製資料
/*------------------------------------------------------ */
	case 'copy':	
		$id	=	!isset($_REQUEST['id'])	?	0	:	intval($_REQUEST['id']);
	
		$data_info = $data->get_info($id);
		$data_info['sort'] = 0;
		
		$smarty->assign('action_link', array('text' => $_LANG['data_list'], 'href' => 'kscontact.php?act=list'));
		
		/* 創建 html editor */
		create_html_editor('desc', $data_info['desc']);
		
		$cat_select = $cat->get_list_option(1, $data_info['cat_id']);
		$smarty->assign('cat_select',   $cat_select);
		
		$smarty->assign('data_info',    $data_info);
		$smarty->assign('form_act',    'insert');
		$smarty->assign('data_select',  $data_select);
	
		/* 顯示頁面 */
		assign_query_info();
		$smarty->display('kscontact_info.htm');
		
		break;		
/*------------------------------------------------------ */
//-- 刪除資料
/*------------------------------------------------------ */
	case 'remove':	
		/* 初始化資料ID */
		$id	=	!isset($_REQUEST['id'])	?	0	:	intval($_REQUEST['id']);
		
		/* 執行刪除動作 */
		if(!$data->del($id)){
			make_json_error($_LANG['data_del_failed']);
		}
		
		make_json_result('', $_LANG['data_del_succed'], array('url'=>'kscontact.php?'.get_last_filter_url() ) );
		
		break;
/*------------------------------------------------------ */
//-- 批量操作
/*------------------------------------------------------ */
	case 'batch':	
		/* 取得要操作的商品編號 */
		$arr 		= 	!isset($_POST['checkboxes'])	?	array()	:	$_POST['checkboxes'];
		$type 		=	!isset($_POST['type'])			?	''		:	trim($_POST['type']);
		$target_cat	=	!isset($_POST['target_cat'])	? 	1		:	intval($_POST['target_cat']);
	
		/* 動作處理 */
		switch($type){
			case 'drop':
				foreach($arr as $id){
					/* 執行刪除動作 */
					if(!$data->del($id)){
						make_json_error($_LANG['data_del_failed']);
					}
				}
				break;
			case 'enabled':
				foreach($arr as $id){
					/* 執行啟用動作 */
					$field['id']		= $id;
					$field['is_show']	= 1; 
					if(!$data->upd($field)){
						make_json_error($_LANG['data_enabled_failed']);
					}
				}
				break;
			case 'disabled':
				foreach($arr as $id){
					/* 執行禁用動作 */
					$field['id']		= $id;
					$field['is_show']  	= 0; 
					if(!$data->upd($field)){
						make_json_error($_LANG['data_disabled_failed']);
					}
				}
				break;
			case 'move_to':
				foreach($arr as $id){
					/* 執行轉移動作 */
					$field['id']		= $id;
					$field['cat_id']  	= $target_cat; 
					if(!$data->upd($field)){
						make_json_error($_LANG['data_move_to_failed']);
					}
				}
				break;
			default:
				break;
		}
		
		make_json_result('', $_LANG['data_batch_succed'], array('url'=>'kscontact.php?'.get_last_filter_url() ) );
		
		break;
/*------------------------------------------------------ */
//-- 回覆
/*------------------------------------------------------ */
	case 'reply':	
		$id	=	!isset($_REQUEST['id'])	?	0	:	intval($_REQUEST['id']);
	
		$data_info = $data->get_info($id);
		
		$data_info['sex_name'] = $data_info['sex']==1?'男':'女';
		
		$smarty->assign('action_link', array('text' => $_LANG['data_list'], 'href' => 'kscontact.php?act=list'));
		
		$cat_select = $cat->get_list_option(1, $data_info['cat_id']);
		$smarty->assign('cat_select',   $cat_select);
	
		$smarty->assign('data_info',    $data_info);

		/* 設定回覆人資訊 */
		$reply_info = $data_admin->get_info($_SESSION['admin_id']);
		$smarty->assign('reply_info',    $reply_info);
		
		/* 設定已回覆資訊 */
		$reply_list = $data_reply->get_list($id);
		$smarty->assign('reply_list',    $reply_list['list']);
		
		$smarty->assign('form_act',    'reply_insert');
		$smarty->assign('data_select',  $data_select);
	
		/* 顯示頁面 */
		assign_query_info();
		$smarty->assign('ur_here',     $ur_here . ' - '.$data_info['name'] . ' - ' . $_LANG['reply'] );
		$smarty->display('kscontact_reply_info.htm');
		
		break;
/*------------------------------------------------------ */
//-- 回覆後的處理
/*------------------------------------------------------ */
	case 'reply_insert':	
		$field['kscontact_id']		= !isset($_REQUEST['id'])			?	0	: intval($_REQUEST['id']);
		$field['name']     			= !isset($_POST['name'])     		?	''	: trim($_POST['name']);
		$field['email']				= !isset($_POST['email'])   		?	''	: trim($_POST['email']);
		$field['phone']				= !isset($_POST['phone'])			?	''	: trim($_POST['phone']);
		$field['sort']   			= !isset($_POST['sort'])     		?	0	: intval($_POST['sort']);
		$field['content']     		= !isset($_POST['content'])    		?	''	: trim($_POST['content']);
		$field['add_time']			= gmtime();
		
		/* 參數檢查 */
		if($field['name'] == ''){
			make_json_error($_LANG['name_empty']);
		}
		
		/* email檢查 */
		if(!is_email($field['email'])){
			make_json_error($_LANG['email_invalid']);
		}

		/* phone檢查 */
		if(!is_phone($field['phone'])){
			make_json_error($_LANG['phone_invalid']);
		}

		/* 參數檢查 */
		if($field['content'] == ''){
			make_json_error($_LANG['content_empty']);
		}

		/* 資料入庫 */
		if(!$data_reply->add($field)){
			make_json_error($_LANG['data_add_failed']);
		}
		$reply_id = $data_reply->get_insert_id();
		
		unset($field);
		/* 將該筆資料設為已回覆 */
		$field['id'] = $id	= !isset($_REQUEST['id']) ?	0 : intval($_REQUEST['id']);
		$field['is_reply'] 	= 1;
		if(!$data->upd($field)){
			make_json_error($_LANG['replay_add_failed']);
		}
		
		/* 發送回覆email */
		$data_info = $data->get_info($id);
		$smarty->assign('data_info',	$data_info);
		$reply_info = $data_reply->get_info($reply_id);
		$smarty->assign('reply_info',	$reply_info);
		$content = $smarty->fetch('kscontact_reply_mail_tpl.htm');
		if (!send_mail($data_info['name'], $data_info['email'], $_LANG['reply_mail_title'], $content, 1))
		{
			make_json_error(join("\n", $err->_message));
		}
		
		make_json_result('', $_LANG['replay_add_succe'], array('url'=>'kscontact.php?'.get_last_filter_url() ) );
		
		break;

	default:	
		break;
}
?>