<?php

/**
 * CHH 最新消息資料管理
 * ============================================================================
 *
 *
 * ============================================================================
 * Author: shsing1
 * Id: marathon.php 2009-11-27 12:00:00
*/

define('IN_CHH', true);

require_once(dirname(__FILE__) . '/includes/init.php');

require_once(ROOT_PATH . '/includes/cls_marathon_cat.php');
$cat = new cls_marathon_cat($db, $chh->table("marathon_cat") );

require_once(ROOT_PATH . '/includes/cls_marathon.php');
$data = new cls_marathon($db, $chh->table("marathon"), $cat);

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
$ur_here = $sys_menu->get_ur_here(49);
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
		$smarty->assign('action_link',  array('href' => 'marathon.php?act=add', 'text' => $_LANG['data_add']));
		$smarty->assign('full_page',    1);

		$smarty->assign('data_list',	$data_list['list']);
		$smarty->assign('filter',		$data_list['filter']);

		/* 排序標記 */
		$sort_flag  = sort_flag($data_list['filter']);
		$smarty->assign($sort_flag['tag'], $sort_flag['img']);


		/* 列表頁面 */
		assign_query_info();
		$smarty->display('marathon_list.htm');

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
		$smarty->assign('action_link',  array('href' => 'marathon.php?act=add', 'text' => $_LANG['data_add']));

		$smarty->assign('data_list',	$data_list['list']);
		$smarty->assign('filter',		$data_list['filter']);

		/* 排序標記 */
		$sort_flag  = sort_flag($data_list['filter']);
		$smarty->assign($sort_flag['tag'], $sort_flag['img']);

		/* 列表頁面 */
		assign_query_info();

		make_json_result($smarty->fetch('marathon_list.htm'), '',
			array('filter' => $data_list['filter'], 'page_count' => $data_list['page_count']));

		break;
/*------------------------------------------------------ */
//-- 添加資料
/*------------------------------------------------------ */
	case 'add':
		/* 模板賦值 */
		$smarty->assign('action_link',  array('href' => 'marathon.php?act=list', 'text' => $_LANG['data_list']));

		/* 創建 html editor */
		create_html_editor('desc');

		$cat_select = $cat->get_list_option();
		$smarty->assign('cat_select',   $cat_select);

		$smarty->assign('form_act',     'insert');
		$smarty->assign('data_info',     array('is_show' => 1, 'is_hot' => 0));

		/* 顯示頁面 */
		assign_query_info();
		$smarty->display('marathon_info.htm');

		break;
/*------------------------------------------------------ */
//-- 資料添加時的處理
/*------------------------------------------------------ */
	case 'insert':
		/* 初始化變量 */
		$field['name']     			= isset($_POST['name'])     		? trim($_POST['name'])     			: '';
		$field['cat_id']   			= isset($_POST['cat_id'])     		? intval($_POST['cat_id'])   		: 1;
		$field['meta_keywords']		= isset($_POST['meta_keywords'])    ? trim($_POST['meta_keywords'])     : '';
		$field['meta_description']	= isset($_POST['meta_description'])	? trim($_POST['meta_description'])	: '';
		$field['sort']   			= isset($_POST['sort'])     		? intval($_POST['sort'])   			: 0;
		$field['is_show']     		= isset($_POST['is_show'])     		? intval($_POST['is_show'])     	: 1;
		$field['desc']     			= isset($_POST['desc'])     		? trim($_POST['desc'])     			: '';
		$field['date']     			= !empty($_POST['date'])     		? trim($_POST['date'])				: local_date($GLOBALS['_CFG']['date_format']);
		$field['author']     		= isset($_POST['author'])     		? trim($_POST['author'])     			: '';
		$field['is_index']     		= isset($_POST['is_index'])     	? intval($_POST['is_index'])     	: 0;
		$field['brief']     		= isset($_POST['brief'])     		? trim($_POST['brief'])     			: '';
		$field['is_hot']     		= isset($_POST['is_hot'])     		? intval($_POST['is_hot'])     	: 0;

		/* 將日期轉為時間戳 */
		$field['date'] = local_strtotime($field['date']);

		/* 參數檢查 */
		if($field['name'] == ''){
			make_json_error($_LANG['name_empty']);
		}

//		/* 參數檢查 */
//		if($field['cat_id'] == 1){
//			make_json_error($_LANG['cat_empty']);
//		}

		/* 資料入庫 */
		if(!$data->add($field)){
			make_json_error($_LANG['data_add_failed']);
		}

//		make_json_result('', $_LANG['data_add_succed'], array('url'=>'marathon.php?'.get_last_filter_url() ));
		make_json_result('', $_LANG['data_add_succed'], array(	'upload'=>'img',
																'id'=>$data->get_insert_id(),
																'op'=>'add',
																'url'=>'marathon.php?'.get_last_filter_url() ));
		break;
/*------------------------------------------------------ */
//-- 編輯資料
/*------------------------------------------------------ */
	case 'edit':
		$id = intval($_REQUEST['id']);

		$data_info = $data->get_info($id);

		$smarty->assign('action_link', array('text' => $_LANG['data_list'], 'href' => 'marathon.php?act=list'));

		/* 創建 html editor */
		create_html_editor('desc', $data_info['desc']);

		$cat_select = $cat->get_list_option(1, $data_info['cat_id']);
		$smarty->assign('cat_select',   $cat_select);

		$smarty->assign('data_info',    $data_info);
		$smarty->assign('form_act',    'update');
		$smarty->assign('data_select',  $data_select);

		/* 顯示頁面 */
		assign_query_info();
		$smarty->assign('ur_here',     $ur_here . ' - '.$data_info['name'] );
		$smarty->display('marathon_info.htm');

		break;
/*------------------------------------------------------ */
//-- 編輯資料後的處理
/*------------------------------------------------------ */
	case 'update':
		/* 初始化變量 */
		$field['id']				= isset($_POST['id'])     			? intval($_POST['id'])     			: 0;
		$field['name']     			= isset($_POST['name'])     		? trim($_POST['name'])     			: '';
		$field['cat_id']   			= isset($_POST['cat_id'])     		? intval($_POST['cat_id'])   		: 1;
		$field['meta_keywords']		= isset($_POST['meta_keywords'])    ? trim($_POST['meta_keywords'])     : '';
		$field['meta_description']	= isset($_POST['meta_description'])	? trim($_POST['meta_description'])	: '';
		$field['sort']   			= isset($_POST['sort'])     		? intval($_POST['sort'])   			: 0;
		$field['is_show']     		= isset($_POST['is_show'])     		? intval($_POST['is_show'])     	: 1;
		$field['desc']     			= isset($_POST['desc'])     		? trim($_POST['desc'])     			: '';
		$field['date']     			= !empty($_POST['date'])     		? trim($_POST['date'])				: local_date($GLOBALS['_CFG']['date_format']);
		$field['author']     		= isset($_POST['author'])     		? trim($_POST['author'])     			: '';
		$field['is_index']     		= isset($_POST['is_index'])     	? intval($_POST['is_index'])     	: 0;
		$field['brief']     		= isset($_POST['brief'])     		? trim($_POST['brief'])     			: '';
		$field['is_hot']     		= isset($_POST['is_hot'])     		? intval($_POST['is_hot'])     	: 0;

		/* 將日期轉為時間戳 */
		$field['date'] = local_strtotime($field['date']);

		if(empty($field['id'])){
			make_json_error($_LANG['id_empty']);
		}

		if($field['name'] == ''){
			make_json_error($_LANG['name_empty']);
		}

//		/* 參數檢查 */
//		if($field['cat_id'] == 1){
//			make_json_error($_LANG['cat_empty']);
//		}

		if(!$data->upd($field)){
			make_json_error($_LANG['data_upd_failed']);
		}

//		make_json_result('', $_LANG['data_upd_succed'], array('url'=>'marathon.php?'.get_last_filter_url() ));
		$id = $field['id'];
		make_json_result('', $_LANG['data_upd_succed'], array(	'upload'=>'img',
																'id'=>$id,
																'op'=>'upd',
																'url'=>'marathon.php?'.get_last_filter_url() ));
		break;
/*------------------------------------------------------ */
//-- 複製資料
/*------------------------------------------------------ */
	case 'copy':
		$id = intval($_REQUEST['id']);

		$data_info = $data->get_info($id);
		$data_info['sort'] = 0;

		$smarty->assign('action_link', array('text' => $_LANG['data_list'], 'href' => 'marathon.php?act=list'));

		/* 創建 html editor */
		create_html_editor('desc', $data_info['desc']);

		$cat_select = $cat->get_list_option(1, $data_info['cat_id']);
		$smarty->assign('cat_select',   $cat_select);

		$smarty->assign('data_info',    $data_info);
		$smarty->assign('form_act',    'insert');
		$smarty->assign('data_select',  $data_select);

		/* 顯示頁面 */
		assign_query_info();
		$smarty->display('marathon_info.htm');

		break;
/*------------------------------------------------------ */
//-- 刪除資料
/*------------------------------------------------------ */
	case 'remove':
		/* 初始化資料ID並取得資料名稱 */
		$id   = intval($_POST['id']);

		/* 執行刪除動作 */
		if(!$data->del($id)){
			make_json_error($_LANG['data_del_failed']);
		}

		make_json_result('', $_LANG['data_del_succed'], array('url'=>'marathon.php?'.get_last_filter_url() ));

		break;
/*------------------------------------------------------ */
//-- 批量操作
/*------------------------------------------------------ */
	case 'batch':
		/* 取得要操作的商品編號 */
		$arr 		= isset($_POST['checkboxes'])	? $_POST['checkboxes']			: array();
		$type 		= isset($_POST['type'])			? $_POST['type']				: '';
		$target_cat = isset($_POST['target_cat'])	? intval($_POST['target_cat'])	: 1;

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

		make_json_result('', $_LANG['data_batch_succed'], array('url'=>'marathon.php?'.get_last_filter_url() ));

		break;
/*------------------------------------------------------ */
//-- 上傳圖片的處理
/*------------------------------------------------------ */
	case 'upload_img':
		$id = isset($_REQUEST['id']) ? intval($_REQUEST['id'])	: 0;
		$op = isset($_REQUEST['op']) ? trim($_REQUEST['op'])	: 'add';

		if(!$data->upload_img($_FILES, $id)){
			make_json_error($_LANG['upload_img_failed']);
		}

		make_json_result('', $_LANG['data_'.$op.'_succed'], array('url'=>'marathon.php?'.get_last_filter_url() ));

		break;
/*------------------------------------------------------ */
//-- 刪除該筆資料的圖片的處理
/*------------------------------------------------------ */
	case 'drop_img':
		$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

		if(!$data->drop_img($id)){
			make_json_error($_LANG['img_del_failed']);
		}
		make_json_result('', $_LANG['img_del_succed'], array('url'=>'marathon.php?act=edit&id='.$id ) );

		break;
	// 縮圖重新產生
	case 'thumb_reset':
		$data->thumb_reset();
		break;
/*------------------------------------------------------ */
//-- 上傳圖片的處理
/*------------------------------------------------------ */
	case 'upload_img2':
		$id = isset($_REQUEST['id']) ? intval($_REQUEST['id'])	: 0;
		$op = isset($_REQUEST['op']) ? trim($_REQUEST['op'])	: 'add';

		if(!$data->upload_img2($_FILES, $id)){
			make_json_error($_LANG['upload_img_failed']);
		}

		make_json_result('', $_LANG['data_'.$op.'_succed'], array('url'=>'marathon.php?'.get_last_filter_url() ));

		break;
/*------------------------------------------------------ */
//-- 刪除該筆資料的圖片的處理
/*------------------------------------------------------ */
	case 'drop_img2':
		$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

		if(!$data->drop_img2($id)){
			make_json_error($_LANG['img_del_failed']);
		}
		make_json_result('', $_LANG['img_del_succed'], array('url'=>'marathon.php?act=edit&id='.$id ) );

		break;

	default:
		break;
}
?>