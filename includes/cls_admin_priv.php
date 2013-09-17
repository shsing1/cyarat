<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_admin_priv extends cls_data {

		function is_exist($admin_id=0, $priv_id=0){
			$sql =	"SELECT * ".
					"FROM ".$this->table." ".
					"WHERE `admin_id` = ".$admin_id." AND `priv_id`=".$priv_id." ".
					";";
			return $this->db->getRow($sql);
		}

		/* 新增資料 */
		function add($field){

			// 鎖住資料表
			$this->db->query("LOCK TABLE ".$this->table." WRITE;");

			$this->db->autoExecute($this->table, $field);

			// 解除鎖住資料表
			$this->db->query("UNLOCK TABLES;");

			/* 清除緩存*/
			clear_all_files();

			return true;
		}

		/* 取得資料列表 */
		function get_priv_list($admin_id=0){

			$sql =	"SELECT * ".
					"FROM ".$this->table ." ".
					"WHERE `admin_id` = ".$admin_id." ".
					";";

			$tmp_arr = $this->db->GetAll($sql);

			$arr = array();
			foreach($tmp_arr as $v){
				$arr[] = $v['priv_id'];
			}
			return $arr;

		}

		/* 刪除資料 */
		function del($admin_id=0, $priv_id=0){

			$b =  false;

			// 鎖住資料表
			$this->db->query("LOCK TABLE ".$this->table." WRITE;");

			/* 執行刪除動作*/
			$sql =	"DELETE FROM ".$this->table." WHERE `admin_id` = ".$admin_id." AND `priv_id`=".$priv_id." ; ";
			if ($this->db->query($sql)){
				$b = true;
			}else{
				$b = false;
			}

			// 解除鎖住資料表
			$this->db->query("UNLOCK TABLES;");

			return $b;

		}

		function set_checked($priv_arr, $exist_arr){
			foreach($priv_arr as $k=>$v){
				$v['checked'] = 0;
				if(in_array($v['id'], $exist_arr)){
					$v['checked'] = 1;
				}
				if(count($v['childs']) > 0){
					$v['childs'] = $this->set_checked($v['childs'], $exist_arr);
				}
				$priv_arr[$k] = $v;
			}
			return $priv_arr;
		}
	}
?>