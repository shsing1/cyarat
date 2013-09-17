<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_epaper extends cls_data {
		
		function get_list(){
			$arr = parent::get_list();
			
			foreach($arr['list'] as $k=>$v){
				$v['last_update'] = local_date($GLOBALS['_CFG']['date_format'], $v['last_update']);
				$v['last_send'] = local_date($GLOBALS['_CFG']['date_format'], $v['last_send']);
				$arr['list'][$k] = $v;
			}
			return $arr;
		}
		
	}
?>