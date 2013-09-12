<?php
	// 繼承cls_cat類構造自己的類，便於在整個系統中調用
	require_once('cls_cat.php');
	class cls_custom_cat extends cls_cat {
	
		var $root	= array('name'=>'自定義畫面', 
						'lft'=>1,
						'rgt'=>2, 
						'is_show'=>1);
	}
?>