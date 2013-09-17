<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_download extends cls_data {	
	
		/* 刪除資料時也要刪除檔案管理裡面的檔案 */
		function del($id=0){
			global $chh, $db;
			
			$b = parent::del($id);	
			
			/* 刪除檔案 */
			require_once(ROOT_PATH . '/includes/cls_download_file.php');
			$data_file = new cls_download_file($db, $chh->table("download_file") );
			$list = $data_file->get_list($id);
			foreach($list['list'] as $v){
				$data_file->del($v['id']);
			}

			return $b;
		}
		
	}
?>