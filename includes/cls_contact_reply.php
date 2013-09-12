<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_contact_reply extends cls_data {
		var $foreign_name	= 'contact_id';
		
		/* 取得資料列表 */
		function get_list($id){
			global $_CFG;
			
			$filter['keyword']				= empty($_REQUEST['keyword']) 			? '' 		: trim($_REQUEST['keyword']);
			$filter['sort_by']				= empty($_REQUEST['sort_by']) 			? 'sort'	: trim($_REQUEST['sort_by']);
			$filter['sort_order']			= empty($_REQUEST['sort_order'])		? 'DESC' 	: trim($_REQUEST['sort_order']);
			
			
			$where = " AND ".$this->foreign_name." = ".$id." ";
			
			/* 關鍵字 */
			if (!empty($filter['keyword']))
			{
				$arr = array();
				foreach($this->search_field as $v){
					$arr[] = "`".$v."` LIKE '%" . mysql_like_quote($filter['keyword']) . "%'";
				}
				$where .= " AND (".join('OR', $arr).")";
			}
	
			
			$param_str = join('-', $filter);
				
			$sql =	"SELECT * ".
					"FROM ".$this->table ." ".
					"WHERE 1 ". $where ." ".
					"ORDER BY ".$filter['sort_by']." ".$filter['sort_order']." ;";

			/* 保存過濾條件*/
			$filter['keyword'] = stripslashes($filter['keyword']);
					
			$arr = $this->db->GetAll($sql);	
			/* 設定格式化時間 */
			foreach($arr as $k=>$v){
				$v['add_time'] = local_date($_CFG['time_format'], $v['add_time']);
				$arr[$k] = $v;
				
			}
			return array('list' => $arr, 'filter' => $filter);
			
		}
		
		/* 取得資料的info */
		function get_info($id=0){
			global $_CFG;
			$arr = parent::get_info($id);
			/* 設定格式化時間 */
			$arr['add_time'] = local_date($_CFG['time_format'], $arr['add_time']);
			return $arr;
		}

	}
?>