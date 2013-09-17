<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_admin extends cls_data {
		var $search_field	= array('name');

		/* 取得資料列表 */
		function get_list($show_all = false, $cat_id = 0){
			$arr = parent::get_list($show_all, $cat_id);

			foreach($arr['list'] as $k=>$v){
				$v['add_time'] = local_date($GLOBALS['_CFG']['time_format'], $v['add_time']);
				$v['last_login'] = local_date($GLOBALS['_CFG']['time_format'], $v['last_login']);
				$arr['list'][$k] = $v;

				/* 如果不是最高管理員則把最高管理員移除 */
				if($v['cat_id'] ==2 && $_SESSION['admin_cat_id'] != 2){
					unset($arr['list'][$k]);
				}
			}
			return $arr;
		}
	}
?>