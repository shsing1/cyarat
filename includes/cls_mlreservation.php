<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_mlreservation extends cls_data {
		var $search_field	= array('name',
									'email',
									'phone',
									'content');
		/* 取得資料列表 */
		function get_list(){
			global $_CFG;
			
			$arr = parent::get_list();
			
			/* 設定格式化時間 */
			foreach($arr['list'] as $k=>$v){
				$v['add_time'] = local_date($_CFG['time_format'], $v['add_time']);
				$arr['list'][$k] = $v;				
			}
			return $arr;
		}
		
		/* 取得資料的info */
		function get_info($id=0){
			global $_CFG;
			$arr = parent::get_info($id);
			/* 設定格式化時間 */
			$arr['add_time'] = local_date($_CFG['time_format'], $arr['add_time']);
			return $arr;
		}

		/* 刪除資料時也要刪除回覆資料 */
		function del($id=0){
			global $chh, $db;		
			$info = $this->get_info($id);
			
			$b = parent::del($id);			
			
			/* 刪除相簿圖片 */
			require_once(ROOT_PATH . '/includes/cls_mlreservation_reply.php');
			$data_reply = new cls_mlreservation_reply($db, $chh->table("mlreservation_reply") );
			$list = $data_reply->get_list($id);
			foreach($list['list'] as $v){
				$data_reply->del($v['id']);
			}

			return $b;
		}
		
		// 取得預約的資料
		public function get_reservation_list($date=''){
			$filter[$this->foreign_name]	= empty($cat_id)?empty($_REQUEST[$this->foreign_name])	? 1	: intval($_REQUEST[$this->foreign_name]):$cat_id;
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
			
			$where .= " AND date = '".$date."' ";
			
			
			/* 在前台is_show必須為1 */
			if(!defined('CHH_ADMIN')){
				$filter['is_show']	= 1;
				$where .= " AND `is_show` = 1 ";
			}
								
			$sql =	"SELECT * ".
						"FROM ".$this->table ." ".
						"WHERE 1 ". $where ." ".
						"ORDER BY sort DESC ";
					
			$arr = $this->db->GetAll($sql);	
			
			return $arr;
		}
		
		// 取得星期名稱
		public function get_week_name($n=0){
			$s = '星期';
			switch($n){
				case 1:
					$s .= '一';
				case 2:
					$s .= '二';
				case 3:
					$s .= '三';
				case 4:
					$s .= '四';
				case 5:
					$s .= '五';
				case 6:
					$s .= '六';
				default:
					$s .= '日';
					break;
			}
			
			return $s;
		}
		
	}
?>