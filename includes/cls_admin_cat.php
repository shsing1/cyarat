<?php
	// 繼承cls_cat類構造自己的類，便於在整個系統中調用
	require_once('cls_cat.php');
	class cls_admin_cat extends cls_cat {
	
		var $root	= array('name'=>'管理員分類', 
						'lft'=>1,
						'rgt'=>2, 
						'is_show'=>1);
		
		/* 選得下拉選單選項 */
		function get_list_option($parent = 1, $selected = 0, $self = 0){
			
			$sql =	"SELECT node.id, CONCAT( REPEAT('　　', (COUNT(parent.name) - (sub_tree.depth + 1))), node.name) AS name
					FROM ".$this->table ." AS node,
						".$this->table ." AS parent,
						".$this->table ." AS sub_parent,
						(
							SELECT node.name, (COUNT(parent.name) - 1) AS depth
							FROM ".$this->table ." AS node,
							".$this->table ." AS parent
							WHERE node.lft BETWEEN parent.lft AND parent.rgt
							AND node.id = '".$parent."'
							GROUP BY node.id
							ORDER BY node.lft
						)AS sub_tree
					WHERE node.lft BETWEEN parent.lft AND parent.rgt
						AND node.lft BETWEEN sub_parent.lft AND sub_parent.rgt
						AND sub_parent.name = sub_tree.name
						AND node.id != ".$self."
					GROUP BY node.id
					ORDER BY node.lft;
					";
			
			$options = $this->db->GetAll($sql);		
							
			$select = '';
			foreach ($options AS $var)
			{
				/* 如果不是最高管理員則把最高管理員移除 */
				if($var['id'] <=2 && $_SESSION['admin_cat_id'] != 2){
					continue;
				}
				
				$select .= '<option value="' . $var['id'] . '" ';
				$select .= ($selected == $var['id']) ? "selected" : '';
				$select .= '>';
			   
				$select .= htmlspecialchars($var['name'], ENT_QUOTES) . '</option>';
			}
	
			return $select;
		}

	}
?>