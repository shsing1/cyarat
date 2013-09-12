<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_download_file extends cls_data {
		
		var $foreign_name	= 'download_id';
		var $upload_folder	= 'download';
		var $search_field	= array('brief');
		var $download_mothed = 1;	/* 1為透過php讀寫的方法下載；0為直接連結檔案路徑下載*/
		
		/* 取得資料列表 */
		function get_list($id){
			
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
			/* 設定檔案圖示 */
			foreach($arr as $k=>$v){
				$v = $this->get_file_img($v);
				/* 設定下載路徑 */
				if($this->download_mothed){
					$p = "act=dl_file&id=".$v['id'];
					$p = authcode($p, 'ENCODE');
					$v['dl_url'] = '?'.$p;
				}else{
					$v['dl_url'] = '../../'.$v['file'];
				}
				$arr[$k] = $v;
				
			}
			return array('list' => $arr, 'filter' => $filter);
			
		}
		
		/* 取得檔案圖示 */
		function get_file_img($val){
			/* 取得檔案副檔名 */
			$suffix = get_file_suffix($val['file']);
			if(file_exists('../images/icon/'.$suffix.'.gif')){
				$val['img'] = '../../images/icon/'.$suffix.'.gif';
			}else{
				$val['img'] = '../../images/icon/help.gif';
			}
			return $val;
		}

		
		/* 新增資料 */
		function add($field, $file){
			
			parent::add($field);
			
			$id = $this->get_insert_id();
			
			$this->upload_file($file, $id);
			
			return true;
		}
		
		/* 處理上傳圖片 */
		function upload_file($file, $id = 0){
			global $_CFG;
			
			/* 建立圖片物件 */
			include_once(ROOT_PATH . '/includes/cls_file.php');
			$obj_file = new cls_file();
	
			
			// 如果上傳檔案，相應處理
			if ($file['download_file']['tmp_name'] != '' && $file['download_file']['tmp_name'] != 'none')
			{
				if ($id > 0)
				{
					/* 刪除原來的文件 */
					$info = $this->get_info($id);
					if ($info['file'] != '' && is_file('../' . $info['file']))
					{
						@unlink('../' . $info['file']);
					}					
				}
		
				$file   = $obj_file->upload_file($file['download_file'], $this->upload_folder); // 原始圖片
				if ($file === false)
				{
					make_json_error($obj_file->error_msg());
				}
				
			}
			
			/* info更新 */			
			$feild['id']			= $id;
			$feild['file']			= $file;
			
			return $this->upd($feild);
		}
		
		
		/* 刪除資料 */
		function del($id=0){
			
			$info = $this->get_info($id);
			
			$b = parent::del($id);
			
			/* 刪除圖片文件 */
			if($b){				
								
				if ($info['file'] != '' && is_file('../' . $info['file']))
				{
					@unlink('../' . $info['file']);
				}
				
			}
			return $b;			
		}
		
		/* 下載檔案 */
		function dl_file($id = 0){
			global $_LANG;
			
			$info = $this->get_info($id);
			
			$file = ROOT_PATH.$info['file'];			
			
			//First, see if the file exists
			if (!file_exists($file)) { 
				/* 在前後台顯示提示訊息不同 */
				if(!defined('CHH_ADMIN')){
					show_message($_LANG['file_no_exists']);
				}else{
					sys_msg($_LANG['file_no_exists']);
				}
			}
		
			//Gather relevent info about file
			$len = filesize($file);
			$filename = $info['brief'] ? $info['brief'] . '.' . get_file_suffix($info['file']) : basename($info['file']);
			$file_extension = strtolower(substr(strrchr($filename,"."),1));
		
			//This will set the Content-Type to the appropriate setting for the file
			switch( $file_extension ) {
				case "pdf": $ctype="application/pdf"; break;
				case "exe": $ctype="application/octet-stream"; break;
				case "zip": $ctype="application/zip"; break;
				case "doc": $ctype="application/msword"; break;
				case "xls": $ctype="application/vnd.ms-excel"; break;
				case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
				case "gif": $ctype="image/gif"; break;
				case "png": $ctype="image/png"; break;
				case "jpeg":
				case "jpg": $ctype="image/jpg"; break;
				case "mp3": $ctype="audio/mpeg"; break;
				case "wav": $ctype="audio/x-wav"; break;
				case "mpeg":
				case "mpg":
				case "mpe": $ctype="video/mpeg"; break;
				case "mov": $ctype="video/quicktime"; break;
				case "avi": $ctype="video/x-msvideo"; break;
				
				//The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
				case "php":
				case "htm":
				case "html":
				case "txt": die("<b>Cannot be used for ". $file_extension ." files!</b>"); break;
				
				default: $ctype="application/force-download";
			}
		
			//Begin writing headers
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
		   
			//Use the switch-generated Content-Type
			header("Content-Type: $ctype");
		
			//Force the download
			$header="Content-Disposition: attachment; filename=".chh_iconv('UTF8', 'BIG5', $filename).";";
			header($header );
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".$len);
			@readfile($file);
			exit;
		}
	}
?>