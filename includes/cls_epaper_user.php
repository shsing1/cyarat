<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_epaper_user extends cls_data {
		
		var $search_field	= array('name', 
									'email');
		
		/* 取得此筆資料的資訊從email */
		function get_info_from_email($email=''){
			$sql = "SELECT * FROM " .$this->table. " WHERE `email` = '". $email ."' ;";
			return $this->db->getRow($sql);
		}

	}
?>