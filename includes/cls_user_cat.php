<?php
	// 繼承cls_cat類構造自己的類，便於在整個系統中調用
	require_once('cls_cat.php');
	class cls_user_cat extends cls_cat {
	
		var $root	= array('name'=>'會員管理', 
						'lft'=>1,
						'rgt'=>2, 
						'is_show'=>1);
		
		var $base_cat	= array(
								array(	'name'=>'一般會員', 										
										'is_show'=>1)
								);
		
		function create_root()
		{
			parent::create_root();
			
			/* 新增基本的分類 */
			foreach($this->base_cat as $v){
				$this->add($v);
			}
		}
	

	}
?>