<?php
	// 繼承smarty類構造自己的模版類，便於在整個系統中調用
	require_once('Smarty/libs/Smarty.class.php');
	class cls_template extends Smarty {

		function cls_template(){
			//$this->__construct();
			// 載入用於在運行時更改img link等標籤
			//$this->load_filter('pre','chpath');
			$this->__construct();
			$this->loadFilter('pre','chpath');
		}
	}
?>