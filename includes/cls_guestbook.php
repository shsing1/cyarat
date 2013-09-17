<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_guestbook extends cls_data {
		var $table_reply = '`chh_guestbook_reply`';
		var $search_field	= array('name',
									'email',
									'phone',
									'content');
		/* 取得資料列表 */
		function get_list($show_all=false){
			global $_CFG, $_LANG, $db, $chh;
			
			$filter[$this->foreign_name]	= empty($_REQUEST[$this->foreign_name])	? 1 		: intval($_REQUEST[$this->foreign_name]);
			$filter['keyword']				= !isset($_REQUEST['keyword']) 			? '' 		: trim($_REQUEST['keyword']);
			$filter['sort_by']				= empty($_REQUEST['sort_by']) 			? 'sort'	: trim($_REQUEST['sort_by']);
			$filter['sort_order']			= empty($_REQUEST['sort_order'])		? 'DESC' 	: trim($_REQUEST['sort_order']);
			
			$tmp = $this->cat->get_list($filter[$this->foreign_name], true);
			$$foreign_arr = array();
			foreach($tmp as $v){
				$foreign_arr[] = $v['id'];
			}
			/* 避免產生錯誤 */		
			if(!(count($foreign_arr) > 0)){
				$foreign_arr[] = 0;
			}
			
			$where = " AND ".$this->foreign_name." IN (" . join(',', $foreign_arr) .")";
			
			/* 關鍵字 */
			if ($filter['keyword'] != '' )
			{
				$arr = array();
				foreach($this->search_field as $v){
					$arr[] = "`".$v."` LIKE '%" . mysql_like_quote($filter['keyword']) . "%'";
				}
				$where .= " AND (".join('OR', $arr)." ) ";
			}
			
			$param_str = join('-', $filter);
//			/* 取得上次的過濾條件 */
//			$result = $this->get_filter($param_str);
//			if ($result === false){
					
				/* 記錄總數 */
				$sql = "SELECT COUNT(*) FROM " .$this->table. " WHERE 1 ". $where ." ;";
				$filter['record_count'] = $this->db->getOne($sql);

				/* 分頁大小 */
				$filter = $this->page_and_size($filter);
				
				$sql =	"";
				if(!$show_all){
					$sql =	"LIMIT " . $filter['start'] . ", ".$filter['page_size']." ;";
				}
				$sql =	"SELECT * ".
						"FROM ".$this->table ." ".
						"WHERE 1 ". $where ." ".
						"ORDER BY ".$filter['sort_by']." ".$filter['sort_order']." ".
						"$sql";
				
//				/* 保存過濾條件*/
//				$filter['keyword'] = stripslashes($filter['keyword']);
//				$this->set_filter($filter, $sql, $param_str);
//				
//			}else{
//				$sql    = $result['sql'];
//				$filter = $result['filter'];
//			}
			
			$arr = $this->db->GetAll($sql);	
			
			/* 取得回覆訊息 */
			require_once(ROOT_PATH . '/includes/cls_guestbook_reply.php');
			$data_reply = new cls_guestbook_reply($db, $chh->table("guestbook_reply") );

			foreach($arr as $k=>$v){
				$v['url'] = empty($v['url'])?"?".authcode("act=detail&id=".$v['id'], 'ENCODE'):$v['url'];
				$v['add_date'] = local_date('Y/m/d', $v['add_time']);
				$v['add_time'] = local_date($_CFG['time_format'], $v['add_time']);
				/* 在前台不公開文字設定 */
				if(!defined('CHH_ADMIN') && $v['is_show'] == 0){
					$v['name'] = $v['email'] = $v['phone'] = $v['content'] = $_LANG['no_public'];
				}
				/* 取得回覆訊息 */
				$reply_list = $data_reply->get_list($v['id']);
				if(count($reply_list['list']) > 0){
					$v['reply_list']	= $reply_list['list'];
				}
				
				$arr[$k] = $v;
			}
			
			return array('list' => $arr, 'filter' => $filter);
			
		}
		
		
		/* 取得資料的info */
		function get_info($id=0){
			global $_CFG;
			$arr = parent::get_info($id);
			
			$arr['format_time'] = $this->get_format_time($arr['add_time']);
				
			/* 設定格式化時間 */
			$arr['add_time'] = local_date($_CFG['time_format'], $arr['add_time']);
			return $arr;
		}

		/* 刪除資料時也要刪除回覆資料 */
		function del($id=0){
			global $chh, $db;		
			$info = $this->get_info($id);
			
			$b = parent::del($id);			
			
			/* 刪除回覆記錄 */
			require_once(ROOT_PATH . '/includes/cls_guestbook_reply.php');
			$data_reply = new cls_guestbook_reply($db, $chh->table("guestbook_reply") );
			$list = $data_reply->get_list($id);
			foreach($list['list'] as $v){
				$data_reply->del($v['id']);
			}

			return $b;
		}
		
		// 點擊加一
		function add_hit($id=0){
			if(!isset($_COOKIE['guestbook_hit_'.$id])){
				$info =  $this->get_info($id);
				$feild = array();
				$feild['id'] = $info['id'];
				$feild['hit'] = $info['hit']+1;
				$this->upd($feild);
				$t = strtotime("+1 day -1 seconds", strtotime(date('Y-m-d')));	
				setcookie('guestbook_hit_'.$id, 1, $t);	
			}
		}
		
		/* 取得資料列表 */
		function get_list2($show_all=false){
			global $_CFG, $_LANG, $db, $chh;
			
			$filter[$this->foreign_name]	= empty($_REQUEST[$this->foreign_name])	? 1 		: intval($_REQUEST[$this->foreign_name]);
			$filter['keyword']				= !isset($_REQUEST['keyword']) 			? '' 		: trim($_REQUEST['keyword']);
			$filter['sort_by']				= empty($_REQUEST['sort_by']) 			? 'last_reply_time'	: trim($_REQUEST['sort_by']);
			$filter['sort_order']			= empty($_REQUEST['sort_order'])		? 'DESC' 	: trim($_REQUEST['sort_order']);
			
			$tmp = $this->cat->get_list($filter[$this->foreign_name], true);
			$$foreign_arr = array();
			foreach($tmp as $v){
				$foreign_arr[] = $v['id'];
			}
			/* 避免產生錯誤 */		
			if(!(count($foreign_arr) > 0)){
				$foreign_arr[] = 0;
			}
			
			$where = " AND ".$this->foreign_name." IN (" . join(',', $foreign_arr) .")";
			
			/* 關鍵字 */
			if ($filter['keyword'] != '' )
			{
				$arr = array();
				foreach($this->search_field as $v){
					$arr[] = "`".$v."` LIKE '%" . mysql_like_quote($filter['keyword']) . "%'";
				}
				$where .= " AND (".join('OR', $arr)." ) ";
			}
			
			$param_str = join('-', $filter);
					
			/* 記錄總數 */
			$sql = "SELECT COUNT(*) FROM " .$this->table. " WHERE 1 ". $where ." ;";
			$filter['record_count'] = $this->db->getOne($sql);

			/* 分頁大小 */
			$filter = $this->page_and_size($filter);
			
			$sql =	"";
//			if(!$show_all){
//				$sql =	"LIMIT " . $filter['start'] . ", ".$filter['page_size']." ;";
//			}
			$sql =	"SELECT *, (SELECT COUNT(*) FROM " .$this->table_reply. " WHERE guestbook_id=t.id) AS reply_count, (SELECT add_time FROM " .$this->table_reply. "_reply WHERE guestbook_id=t.id ORDER BY sort DESC LIMIT 1 ) AS last_reply_time ".
					"FROM ".$this->table ." AS t ".
					"WHERE 1 ". $where ." ".
					"ORDER BY ".$filter['sort_by']." ".$filter['sort_order']." ".
					"$sql";
				
			
			$arr = $this->db->GetAll($sql);	
			
			foreach($arr as $k=>$v){
				$v['url'] = empty($v['url'])?"?".authcode("act=detail&id=".$v['id'], 'ENCODE'):$v['url'];
				$v['last_reply_format_time'] = $this->get_format_time($v['last_reply_time']);
				$arr[$k] = $v;
			}
			
//			/* 取得回覆訊息 */
//			require_once(ROOT_PATH . '/includes/cls_guestbook_reply.php');
//			$data_reply = new cls_guestbook_reply($db, $chh->table("guestbook_reply") );
//
//			foreach($arr as $k=>$v){
//				$v['url'] = empty($v['url'])?"?".authcode("act=detail&id=".$v['id'], 'ENCODE'):$v['url'];
//				$v['add_date'] = local_date('Y/m/d', $v['add_time']);
//				$v['add_time'] = local_date($_CFG['time_format'], $v['add_time']);
//				/* 在前台不公開文字設定 */
//				if(!defined('CHH_ADMIN') && $v['is_show'] == 0){
//					$v['name'] = $v['email'] = $v['phone'] = $v['content'] = $_LANG['no_public'];
//				}
//				/* 取得回覆訊息 */
//				$reply_list = $data_reply->get_list($v['id']);
//				if(count($reply_list['list']) > 0){
//					$v['reply_list']	= $reply_list['list'];
//				}
//				
//				$arr[$k] = $v;
//			}
			
			return array('list' => $arr, 'filter' => $filter);
			
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