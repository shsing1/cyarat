<?php

/**
 * CHH 電子報發送隊列資料管理
 * ============================================================================
 *
 *
 * ============================================================================
 * Author: shsing1
 * Id: epaper_queue.php 2009-11-27 12:00:00
*/

define('IN_CHH', true);

require_once(dirname(__FILE__) . '/includes/init.php');

require_once(ROOT_PATH . '/includes/cls_epaper_queue.php');
$data = new cls_epaper_queue($db, $chh->table("epaper_queue") );

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
$ur_here = $sys_menu->get_ur_here(43);
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
		
		/* 設定搜尋關鍵字預設值 */
		$serach_keyword	=	!isset($_REQUEST['keyword'])	?	''	:	trim($_REQUEST['keyword']);
		$smarty->assign('serach_keyword',  $serach_keyword);
	
		/* 模板賦值 */
		$smarty->assign('full_page',    1);

		$smarty->assign('data_list',	$data_list['list']);
		$smarty->assign('filter',		$data_list['filter']);
		
		/* 排序標記 */
		$sort_flag  = sort_flag($data_list['filter']);
		$smarty->assign($sort_flag['tag'], $sort_flag['img']);
	
		/* 列表頁面 */
		assign_query_info();
		$smarty->display('epaper_queue_list.htm');
		
		break;		
/*------------------------------------------------------ */
//-- 排序、分頁、查詢
/*------------------------------------------------------ */
	case 'query':
	
		/* 獲取資料列表 */
		$data_list = $data->get_list();
		
	
		/* 模板賦值 */
		$smarty->assign('action_link',  array('href' => 'epaper_queue.php?act=add', 'text' => $_LANG['data_add']));
	
		$smarty->assign('data_list',	$data_list['list']);
		$smarty->assign('filter',		$data_list['filter']);
		
		/* 排序標記 */
		$sort_flag  = sort_flag($data_list['filter']);
		$smarty->assign($sort_flag['tag'], $sort_flag['img']);
	
		/* 列表頁面 */
		assign_query_info();
		
		make_json_result(	$smarty->fetch('epaper_queue_list.htm'), 
							'',
							array(	'filter' => $data_list['filter'], 'page_count' => $data_list['page_count'] )
						);
		break;		
/*------------------------------------------------------ */
//-- 添加資料
/*------------------------------------------------------ */
	case 'add':	
		/* 模板賦值 */
		$smarty->assign('action_link',  array('href' => 'epaper_queue.php?act=list', 'text' => $_LANG['data_list']));
		
		/* 創建 html editor */
		create_html_editor('desc');
		
		$cat_select = $cat->get_list_option();
		$smarty->assign('cat_select',   $cat_select);
		
		$smarty->assign('form_act',     'insert');
		$smarty->assign('data_info',     array('is_show' => 1));
	
		/* 顯示頁面 */
		assign_query_info();
		$smarty->display('epaper_queue_info.htm');
		
		break;
/*------------------------------------------------------ */
//-- 資料添加時的處理
/*------------------------------------------------------ */
	case 'insert':	
		/* 初始化變量 */
		$field['name']     			= !isset($_POST['name'])     		?	''	: trim($_POST['name']);
		$field['cat_id']   			= !isset($_POST['cat_id'])     		?	1	: intval($_POST['cat_id']);
		$field['meta_keywords']		= !isset($_POST['meta_keywords'])   ?	''	: trim($_POST['meta_keywords']);
		$field['meta_description']	= !isset($_POST['meta_description'])?	''	: trim($_POST['meta_description']);
		$field['sort']   			= !isset($_POST['sort'])     		?	0	: intval($_POST['sort']);
		$field['is_show']     		= !isset($_POST['is_show'])      	?	1	: intval($_POST['is_show']);
		$field['desc']     			= !isset($_POST['desc'])     		?	''	: trim($_POST['desc']);
	
		/* 參數檢查 */
		if($field['name'] == ''){
			make_json_error($_LANG['name_empty']);
		}
		
		/* 資料入庫 */
		if(!$data->add($field)){
			make_json_error($_LANG['data_add_failed']);
		}
		
		make_json_result('', $_LANG['data_add_succed'], array('url'=>'epaper_queue.php?'.get_last_filter_url() ) );
		
		break;
/*------------------------------------------------------ */
//-- 編輯資料
/*------------------------------------------------------ */
	case 'edit':	
		$id	=	!isset($_REQUEST['id'])	?	0	:	intval($_REQUEST['id']);
	
		$data_info = $data->get_info($id);
		
		$smarty->assign('action_link', array('text' => $_LANG['data_list'], 'href' => 'epaper_queue.php?act=list'));
		
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
		$smarty->display('epaper_queue_info.htm');
		
		break;
/*------------------------------------------------------ */
//-- 編輯資料後的處理
/*------------------------------------------------------ */
	case 'update':	
		/* 初始化變量 */
		$field['id']				= !isset($_POST['id'])     			?	0	: intval($_POST['id']);
		$field['name']     			= !isset($_POST['name'])     		?	''	: trim($_POST['name']);
		$field['cat_id']   			= !isset($_POST['cat_id'])     		?	1	: intval($_POST['cat_id']);
		$field['meta_keywords']		= !isset($_POST['meta_keywords'])   ?	''	: trim($_POST['meta_keywords']);
		$field['meta_description']	= !isset($_POST['meta_description'])?	''	: trim($_POST['meta_description']);
		$field['sort']   			= !isset($_POST['sort'])     		?	0	: intval($_POST['sort']);
		$field['is_show']     		= !isset($_POST['is_show'])      	?	1	: intval($_POST['is_show']);
		$field['desc']     			= !isset($_POST['desc'])     		?	''	: trim($_POST['desc']);
	
		if(empty($field['id'])){
			make_json_error($_LANG['id_empty']);
		}
		
		if($field['name'] == ''){
			make_json_error($_LANG['name_empty']);
		}
		
		if(!$data->upd($field)){
			make_json_error($_LANG['data_upd_failed']);
		}
		
		make_json_result('', $_LANG['data_upd_succed'], array('url'=>'epaper_queue.php?'.get_last_filter_url() ) );
		
		break;
/*------------------------------------------------------ */
//-- 複製資料
/*------------------------------------------------------ */
	case 'copy':	
		$id	=	!isset($_REQUEST['id'])	?	0	:	intval($_REQUEST['id']);
	
		$data_info = $data->get_info($id);
		$data_info['sort'] = 0;
		
		$smarty->assign('action_link', array('text' => $_LANG['data_list'], 'href' => 'epaper_queue.php?act=list'));
		
		/* 創建 html editor */
		create_html_editor('desc', $data_info['desc']);
		
		$cat_select = $cat->get_list_option(1, $data_info['cat_id']);
		$smarty->assign('cat_select',   $cat_select);
		
		$smarty->assign('data_info',    $data_info);
		$smarty->assign('form_act',    'insert');
		$smarty->assign('data_select',  $data_select);
	
		/* 顯示頁面 */
		assign_query_info();
		$smarty->display('epaper_queue_info.htm');
		
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
		
		make_json_result('', $_LANG['data_del_succed'], array('url'=>'epaper_queue.php?'.get_last_filter_url() ) );
		
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
		
		make_json_result('', $_LANG['data_batch_succed'], array('url'=>'epaper_queue.php?'.get_last_filter_url() ) );
		
		break;
/*------------------------------------------------------ */
//-- 全部發送
/*------------------------------------------------------ */
	case 'all_send':	
		/* 取得發送隊列 */
		$list = $data->get_list();
		$list = $list['list'];
	
		/* 檢查隊列是否為0 */
		if (count($list) == 0)
		{
			make_json_error($_LANG['mailsend_null']);
		}
		
		require_once(ROOT_PATH . '/includes/cls_epaper.php');
		$epaper = new cls_epaper($db, $chh->table("epaper") );

		foreach($list as $k=>$v){
			//發送列表不為空，郵件地址為空
			if (!empty($v['id']) && empty($v['email']))
			{
				$data->del($v['id']);
				continue;
			}
			
			/* 取得郵件內容 */
			$info = $epaper->get_info($v['epaper_id']);
			$info['desc'] = preg_replace("/(<(img.*?src|link.*?href|script.*?src|frame.*?src)=([\"']))((?!http).*?)(\\3.*?>)/is","$1".$chh->url()."$4$5",$info['desc']);
			
			if (send_mail('', $v['email'], $info['name'], $info['desc'], 1))
            {
                //發送成功

                //從列表中刪除
            	$data->del($v['id']);
            }
            else
            {
                //發送出錯

                if ($v['error'] < 3)
                {					
                    $field['id'] = $v['id'];
					$field['last_send'] = gmtime();
					$field['error'] = $v['error']+1;
					$data->upd($field);
                }
                else
                {
                    //將出錯超次的紀錄刪除
                    $data->del($v['id']);
                }
            }
			
		}
		make_json_result('', $_LANG['mailsend_finished'], array('url'=>'epaper_queue.php?'.get_last_filter_url() ) );
		break;

	default:	
		break;
}
?>