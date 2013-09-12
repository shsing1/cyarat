<?php

/**
 * CHH 專訪集錦分類管理
 * ============================================================================
 *
 *
 * ============================================================================
 * Author: shsing1
 * Id: mlmovie_cat.php 2009-11-26 21:00:00
*/

define('IN_CHH', true);

require_once(dirname(__FILE__) . '/includes/init.php');

require_once(ROOT_PATH . '/includes/cls_mlmovie_cat.php');
$cat = new cls_mlmovie_cat($db, $chh->table("mlmovie_cat") );

require_once(ROOT_PATH . '/includes/cls_mlmovie.php');
$data = new cls_mlmovie($db, $chh->table("mlmovie"), $cat );

/* act操作項的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

require_once(ROOT_PATH . '/includes/cls_sys_menu.php');
$sys_menu = new cls_sys_menu($db, $chh->table("sys_menu") );
$ur_here = $sys_menu->get_ur_here(73);
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
		$smarty->assign('action_link',  array('href' => 'mlmovie_cat.php?act=add', 'text' => $_LANG['cat_add']));
		$smarty->assign('full_page',    1);
	
		$smarty->assign('cat_info',     $cat_list);
	
		/* 列表頁面 */
		assign_query_info();
		$smarty->display('mlmovie_cat_list.htm');
		
		break;
/*------------------------------------------------------ */
//-- 添加分類
/*------------------------------------------------------ */
	case 'add':
		/* 模板賦值 */
		$smarty->assign('action_link',  array('href' => 'mlmovie_cat.php?act=list', 'text' => $_LANG['cat_list']));
	
		$cat_select = $cat->get_list_option();
		$smarty->assign('cat_select',   $cat_select);
		$smarty->assign('form_act',     'insert');
		$smarty->assign('cat_info',     array('is_show' => 1));
	
		/* 顯示頁面 */
		assign_query_info();
		$smarty->display('mlmovie_cat_info.htm');

		break;		
/*------------------------------------------------------ */
//-- 分類添加時的處理
/*------------------------------------------------------ */
	case 'insert':	
		/* 初始化變量 */
		$field['name']     			=	!isset($_POST['name'])     			?	''	:	trim($_POST['name']);
		$field['meta_keywords']		=	!isset($_POST['meta_keywords'])     ?	''	:	trim($_POST['meta_keywords']);
		$field['meta_description']	=	!isset($_POST['meta_description'])	?	''	:	trim($_POST['meta_description']);
		$location_from     			=	!isset($_POST['location_from'])		?	1	:	intval($_POST['location_from']);
		$location_type     			=	!isset($_POST['location_type'])     ?	0	:	intval($_POST['location_type']);
		$field['is_show']     		=	!isset($_POST['is_show'])      		?	1	:	intval($_POST['is_show']);
	
		if($field['name'] == ''){
			make_json_error($_LANG['name_empty']);
		}
		
		if(!$cat->add($field, $location_from, $location_type)){
			make_json_error($_LANG['cat_add_failed']);
		}
		
		make_json_result('', $_LANG['cat_add_succed'], array('url'=>'mlmovie_cat.php'));
	
		break;		
/*------------------------------------------------------ */
//-- 編輯分類
/*------------------------------------------------------ */
	case 'edit':
		$cat_id	=	!isset($_REQUEST['cat_id'])	?	0	:	intval($_REQUEST['cat_id']);
	
		$cat_info = $cat->get_info($cat_id);
		
		$smarty->assign('action_link', array('text' => $_LANG['cat_list'], 'href' => 'mlmovie_cat.php?act=list'));
		
		// 取得父節點
		$parent = $cat->get_parent($cat_id);
		
		$smarty->assign('cat_info',    $cat_info);
		$smarty->assign('form_act',    'update');
		$cat_select = $cat->get_list_option(1, $parent['id'], $cat_id);
		$smarty->assign('cat_select',  $cat_select);
	
		/* 顯示頁面 */
		assign_query_info();
		$smarty->assign('ur_here',     $ur_here . ' - '.$cat_info['name'] );
		$smarty->display('mlmovie_cat_info.htm');

		break;
/*------------------------------------------------------ */
//-- 編輯分類後的處理
/*------------------------------------------------------ */
	case 'update':
		/* 初始化變量 */
		$field['id']				= !isset($_POST['id'])     			?	0	:	intval($_POST['id']);
		$field['name']				= !isset($_POST['name'])     		?	''	:	trim($_POST['name']);
		$field['meta_keywords']		= !isset($_POST['meta_keywords'])	?	''	:	trim($_POST['meta_keywords']);
		$field['meta_description']	= !isset($_POST['meta_description'])?	''	:	trim($_POST['meta_description']);
		$location_from				= !isset($_POST['location_from'])   ?	1	:	intval($_POST['location_from']);
		$location_type				= !isset($_POST['location_type'])   ?	0	:	intval($_POST['location_type']);
		$field['is_show']			= !isset($_POST['is_show'])      	?	1	:	intval($_POST['is_show']);
	
		if(empty($field['id'])){
			make_json_error($_LANG['id_empty']);
		}
		
		if($field['name'] == ''){
			make_json_error($_LANG['name_empty']);
		}
		
		if(!$cat->upd($field, $location_from, $location_type)){
			make_json_error($_LANG['cat_upd_failed']);
		}
		
		make_json_result('', $_LANG['cat_upd_succed'], array('url'=>'mlmovie_cat.php'));

		break;
/*------------------------------------------------------ */
//-- 刪除分類
/*------------------------------------------------------ */
	case 'remove':
		/* 初始化分類ID並取得分類名稱 */
		$cat_id		=	!isset($_POST['id'])	?	0	:	intval($_POST['id']);	
		$cat_info	= $cat->get_info($cat_id);
		$cat_name	= $cat_info['name'];
	
		/* 當前分類下是否有子分類 */
		$cat_count = $cat->get_list($cat_id);
		$cat_count = count($cat_count);
		if($cat_count > 0){
			make_json_error($cat_name .' '. $_LANG['cat_isleaf']);
		}
		
		/* 當前分類下是否有資料 */
		$_REQUEST['cat_id'] = $cat_id;
		$data_list = $data->get_list();
		$data_count = count($data_list['list']);
		if($data_count > 0){
			make_json_error($cat_name .' '. $_LANG['cat_has_goods']);
		}
	
		
		/* 執行刪除動作 */
		if(!$cat->del($cat_id)){
			make_json_error($_LANG['cat_del_failed']);
		}
		
		make_json_result('', $_LANG['cat_del_succed'], array('url'=>'mlmovie_cat.php'));

		break;
	default:
		break;
}
?>