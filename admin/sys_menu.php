<?php

/**
 * CHH 後台選單管理
 * ============================================================================
 *
 *
 * ============================================================================
 * Author: shsing1
 * Id: sys_menu.php 2009-11-06 14:00:00
*/

define('IN_CHH', true);

require_once(dirname(__FILE__) . '/includes/init.php');

require_once(ROOT_PATH . '/includes/cls_sys_menu.php');
$cat = new cls_sys_menu($db, $chh->table("sys_menu") );

/* act操作項的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

$ur_here = $cat->get_ur_here(3);
$smarty->assign('ur_here',     $ur_here);

/*------------------------------------------------------ */
//-- 依act進行應對動作
/*------------------------------------------------------ */
switch($_REQUEST['act'] ){	
/*------------------------------------------------------ */
//-- 分類列表
/*------------------------------------------------------ */
	case 'list':
		/* 獲取分類列表 */
		$cat_list = $cat->get_list();
	
		/* 模板賦值 */
		$smarty->assign('action_link',  array('href' => 'sys_menu.php?act=add', 'text' => $_LANG['cat_add']));
		$smarty->assign('full_page',    1);
	
		$smarty->assign('cat_info',     $cat_list);
	
		/* 列表頁面 */
		assign_query_info();
		$smarty->display('sys_menu_list.htm');

		break;
/*------------------------------------------------------ */
//-- 添加分類
/*------------------------------------------------------ */
	case 'add':
		/* 模板賦值 */
		$smarty->assign('action_link',  array('href' => 'sys_menu.php?act=list', 'text' => $_LANG['cat_list']));
	
		$cat_select = $cat->get_list_option();
		$smarty->assign('cat_select',   $cat_select);
		$smarty->assign('form_act',     'insert');
		$smarty->assign('cat_info',     array('is_show' => 1));
	
		/* 顯示頁面 */
		assign_query_info();
		$smarty->display('sys_menu_info.htm');

		break;
/*------------------------------------------------------ */
//-- 分類添加時的處理
/*------------------------------------------------------ */
	case 'insert':
		/* 初始化變量 */
		$field['name']     	= isset($_POST['name'])     		? trim($_POST['name'])     			: '';
		$field['url']     	= isset($_POST['url'])     			? trim($_POST['url'])     			: '';
		$location_from     	= isset($_POST['location_from'])   	? intval($_POST['location_from'])   : 1;
		$location_type     	= isset($_POST['location_type'])   	? intval($_POST['location_type'])   : 0;
		$field['is_chh']    = isset($_POST['is_chh'])     		? intval($_POST['is_chh'])     		: 0;
	
		if($field['name'] == ''){
			make_json_error($_LANG['name_empty']);
		}
		
		if(!$cat->add($field, $location_from, $location_type)){
			make_json_error($_LANG['cat_add_failed']);
		}
		
		make_json_result('', $_LANG['cat_add_succed'], array('url'=>'sys_menu.php'));

		break;
/*------------------------------------------------------ */
//-- 編輯分類
/*------------------------------------------------------ */
	case 'edit':
		$cat_id = intval($_REQUEST['cat_id']);
	
		$cat_info = $cat->get_info($cat_id);
		
		$smarty->assign('action_link', array('text' => $_LANG['cat_list'], 'href' => 'sys_menu.php?act=list'));
		
		// 取得父節點
		$parent = $cat->get_parent($cat_id);
		
		$smarty->assign('cat_info',    $cat_info);
		$smarty->assign('form_act',    'update');
		$cat_select = $cat->get_list_option(1, $parent['id'], $cat_id);
		$smarty->assign('cat_select',  $cat_select);
	
		/* 顯示頁面 */
		assign_query_info();
		$smarty->display('sys_menu_info.htm');

		break;
/*------------------------------------------------------ */
//-- 編輯分類後的處理
/*------------------------------------------------------ */
	case 'update':
		/* 初始化變量 */
		$field['name']		= isset($_POST['name'])     		? trim($_POST['name'])     			: '';
		$field['url']     	= isset($_POST['url'])     			? trim($_POST['url'])     			: '';
		$location_from		= isset($_POST['location_from'])   	? intval($_POST['location_from'])   : 1;
		$location_type		= isset($_POST['location_type'])   	? intval($_POST['location_type'])   : 0;
		$field['is_chh']	= isset($_POST['is_chh'])     		? intval($_POST['is_chh'])     		: 0;
		$field['id']		= isset($_POST['id'])     			? intval($_POST['id'])     			: 0;
	
		if(empty($field['id'])){
			make_json_error($_LANG['id_empty']);
		}
		
		if($field['name'] == ''){
			make_json_error($_LANG['name_empty']);
		}
		
		if(!$cat->upd($field, $location_from, $location_type)){
			make_json_error($_LANG['cat_upd_failed']);
		}
		
		make_json_result('', $_LANG['cat_upd_succed'], array('url'=>'sys_menu.php'));

		break;
/*------------------------------------------------------ */
//-- 刪除分類
/*------------------------------------------------------ */
	case 'remove':
		/* 初始化分類ID並取得分類名稱 */
		$cat_id   = intval($_POST['id']);	
		$cat_info = $cat->get_info($cat_id);
		$cat_name = $cat_info['name'];
	
		/* 當前分類下是否有子分類 */
		$cat_count = $cat->get_list($cat_id);
		$cat_count = count($cat_count);
		if($cat_count > 0){
			make_json_error($cat_name .' '. $_LANG['cat_isleaf']);
		}
		
		/* 執行刪除動作 */
		if(!$cat->del($cat_id)){
			make_json_error($_LANG['cat_del_failed']);
		}
		
		make_json_result('', $_LANG['cat_del_succed'], array('url'=>'sys_menu.php'));

		break;
	default:
		break;
}
?>