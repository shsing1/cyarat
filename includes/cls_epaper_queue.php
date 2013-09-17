<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_epaper_queue extends cls_data {
		
		var $foreign_name	= 'epaper_id';
		
		/* 取得資料列表 */
		function get_list(){
			
			$filter['keyword']				= empty($_REQUEST['keyword']) 			? '' 		: trim($_REQUEST['keyword']);
			$filter['sort_by']				= empty($_REQUEST['sort_by']) 			? 'sort'	: trim($_REQUEST['sort_by']);
			$filter['sort_order']			= empty($_REQUEST['sort_order'])		? 'DESC' 	: trim($_REQUEST['sort_order']);
			
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
			/* 取得上次的過濾條件 */
			$result = $this->get_filter($param_str);
			if ($result === false){
				
				/* 記錄總數 */
				$sql = "SELECT COUNT(*) FROM " .$this->table. " WHERE 1 ". $where ." ;";
				$filter['record_count'] = $this->db->getOne($sql);				
				
				/* 分頁大小 */
				$filter = $this->page_and_size($filter);
				
				$sql =	"LIMIT " . $filter['start'] . ", ".$filter['page_size']." ;";

				$sql =	"SELECT e.name AS `email_title`, q.* ".
						"FROM ".$this->table ." AS q ".
						"LEFT JOIN ".$GLOBALS['chh']->table("epaper")." AS e ON q.epaper_id=e.id ".
						"WHERE 1 ". $where ." ".
						"ORDER BY ".$filter['sort_by']." ".$filter['sort_order']." ".
						"$sql";
	
				/* 保存過濾條件*/
				$filter['keyword'] = stripslashes($filter['keyword']);
				$this->set_filter($filter, $sql, $param_str);
				
			}else{
				$sql    = $result['sql'];
				$filter = $result['filter'];
			}
					
			$arr = $this->db->GetAll($sql);	
			/* 設定時間格式 */
			foreach($arr as $k=>$v){
				$v['last_send'] = local_date($GLOBALS['_CFG']['time_format'], $v['last_send']);				
				$arr[$k] = $v;				
			}
			return array('list' => $arr, 'filter' => $filter);
			
		}
		
	}
?>