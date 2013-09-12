<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_guestbook_reply extends cls_data {
		var $foreign_name	= 'guestbook_id';
		
		/* 取得資料列表 */
		function get_list($id){
			global $_CFG, $_LANG;
			
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
				$v['format_time'] = $this->get_format_time($v['add_time']);
				$v['add_date'] = local_date('Y/m/d', $v['add_time']);
				$v['sp_time'] = local_date('F d, Y h:i a', $v['add_time']);
				$v['add_time'] = local_date($_CFG['time_format'], $v['add_time']);
								
				/* 在前台不公開文字設定 */
				if(!defined('CHH_ADMIN') && $v['is_show'] == 0){
					$v['name'] = $v['email'] = $v['phone'] = $v['content'] = $_LANG['no_public'];
				}
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

		function get_format_time($time=''){
			$str = '';
			if($time){
				$a = local_date('a', $time);
				$a = $a=='am' ? '上午':'下午';
				$str = local_date('Y.n.j '.$a.' h:i:s', $time);
			}
			return $str;
		}
	}
?>