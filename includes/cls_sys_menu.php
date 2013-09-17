<?php
	// 繼承cls_cat類構造自己的類，便於在整個系統中調用
	require_once('cls_cat.php');
	class cls_sys_menu extends cls_cat {

		var $root	= array('name'=>'系統選單',
						'lft'=>1,
						'rgt'=>2);

		function get_list($parent = 1, $has_root = false){
			global $db, $chh;


			$sql =	"SELECT node.*, (COUNT(parent.id) - (sub_tree.depth + 1)) AS depth, if(node.rgt=node.lft+1, 1, 0) AS is_leaf
					FROM ".$this->table ." AS node,
						".$this->table ." AS parent,
						".$this->table ." AS sub_parent,
						(
							SELECT node.id, (COUNT(parent.id) - 1) AS depth
							FROM ".$this->table ." AS node,
							".$this->table ." AS parent
							WHERE node.lft BETWEEN parent.lft AND parent.rgt
							AND node.id = '".$parent."'
							GROUP BY node.id
							ORDER BY node.lft
						)AS sub_tree
					WHERE node.lft BETWEEN parent.lft AND parent.rgt
						AND node.lft BETWEEN sub_parent.lft AND sub_parent.rgt
						AND sub_parent.id = sub_tree.id
					GROUP BY node.id
					ORDER BY node.lft;
					";
			$arr = $this->db->GetAll($sql);

			if(!$has_root){
				array_shift($arr);
			}

			/* 如果是最高管理者選單全部顯示 */
			if($_SESSION['admin_cat_id']!=2){
				/* 取得管理者的權限選單 */
				require_once(ROOT_PATH . '/includes/cls_admin_priv.php');
				$priv = new cls_admin_priv($db, $chh->table("admin_priv") );
				$priv_arr = $priv->get_priv_list($_SESSION['admin_id']);

				foreach($arr as $k=>$v){
					if(!in_array($v['id'], $priv_arr) || $v['is_chh']==1){
						unset($arr[$k]);
					}
				}
			}

			return $arr;

		}
	}
?>