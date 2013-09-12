<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_contact extends cls_data {
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
			require_once(ROOT_PATH . '/includes/cls_contact_reply.php');
			$data_reply = new cls_contact_reply($db, $chh->table("contact_reply") );
			$list = $data_reply->get_list($id);
			foreach($list['list'] as $v){
				$data_reply->del($v['id']);
			}

			return $b;
		}
		
	}
?>