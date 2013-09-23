<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_activity_img extends cls_data {

		var $foreign_name	= 'activity_id';
		var $upload_folder	= 'activity';
		var $img_width		= 550;
		var $img_height		= 445;
		var $thumb_width	= 105;
		var $thumb_height	= 105;
		var $search_field	= array('name');

		/* 取得資料列表 */
		function get_img_list($id){

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
			return array('list' => $arr, 'filter' => $filter);

		}

		/* 取得資料列表 */
		function get_first_img($id){

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
					"ORDER BY ".$filter['sort_by']." ".$filter['sort_order']." ".
					"LIMIT 0, 1;";

			/* 保存過濾條件*/
			$filter['keyword'] = stripslashes($filter['keyword']);

			$arr = $this->db->GetAll($sql);

			$list = array();
			foreach($arr as $v){
				$list = $v;
			}
			return $list;

		}

		/* 新增資料 */
		function img_add($field, $file){

			parent::add($field);

			$id = $this->get_insert_id();

			$this->upload_img($file, $id);

			return true;
		}

		/* 處理上傳圖片 */
		function upload_img($file, $id = 0){
			global $_CFG;

			/* 建立圖片物件 */
			include_once(ROOT_PATH . '/includes/cls_image.php');
			$image = new cls_image($_CFG['bgcolor']);

			/* 檢查圖片：如果有錯誤，檢查尺寸是否超過最大值；否則，檢查文件類型 */
			if (isset($file['activity_img']['error'])) // php 4.2 版本才支持 error
			{
				// 最大上傳文件大小
				$php_maxsize = ini_get('upload_max_filesize');
				$htm_maxsize = '2M';

				// 圖片
				if ($file['activity_img']['error'] == 1)
				{
					make_json_error(sprintf($_LANG['img_too_big'], $php_maxsize));
				}
				elseif ($file['activity_img']['error'] == 2)
				{
					make_json_error(sprintf($_LANG['img_too_big'], $htm_maxsize));
				}
			}

			// 如果上傳圖片，相應處理
			if ($file['activity_img']['tmp_name'] != '' && $file['activity_img']['tmp_name'] != 'none')
			{
				if ($id > 0)
				{
					/* 刪除原來的圖片文件 */
					$info = $this->get_info($id);
					if ($info['img'] != '' && is_file('../' . $info['img']))
					{
						@unlink('../' . $info['img']);
					}

					if ($info['original_img'] != '' && is_file('../' . $info['original_img']))
					{
						@unlink('../' . $info['original_img']);
					}
				}

				$original_img   = $image->upload_image($file['activity_img'], $this->upload_folder); // 原始圖片
				if ($original_img === false)
				{
					make_json_error($image->error_msg());
				}
				$img  = $original_img;   // 商品圖片

				/* 依副檔名設定檔案形態 */
				$suffix = get_file_suffix($file['activity_img']['name']);
				switch($suffix){
					case 'gif':
						$file['activity_img']['type'] = 'image/gif';
						break;
					case 'png':
						$file['activity_img']['type'] = 'image/png';
						break;
					default:
						$file['activity_img']['type'] = 'image/jpeg';
						break;
				}

				// 如果系統支持GD，縮放圖片，且給圖片和相冊圖片加水印
				if ($image->gd_version() > 0 && $image->check_img_function($file['activity_img']['type']))
				{
					// 如果設置大小不為0，縮放圖片
					if ($this->img_width != 0 || $this->img_height != 0)
					{
						$image->set_cut_type(1);
						$thumb = $image->make_thumb('../'. $img , $this->thumb_width,  $this->thumb_height, $this->upload_folder );
						if ($thumb === false)
						{
							make_json_error($image->error_msg());
						}
						$image->set_cut_type(0);
						$img = $image->make_thumb('../'. $img , $this->img_width,  $this->img_height, $this->upload_folder );
						if ($img === false)
						{
							make_json_error($image->error_msg());
						}
					}

					// 加水印
					if (intval($_CFG['watermark_place']) > 0 && !empty($_CFG['watermark']))
					{
						if ($image->add_watermark('../'.$img,'', '../'.$_CFG['watermark'], $_CFG['watermark_place'], $_CFG['watermark_alpha']) === false)
						{
							make_json_error($image->error_msg());
						}
					}

				}
			}

			/* info更新 */
			$feild['id']			= $id;
			$feild['thumb']			= $thumb;
			$feild['img']			= $img;
			$feild['original_img']	= $original_img;

			return $this->upd($feild);
		}


		/* 刪除資料 */
		function del($id=0){

			$info = $this->get_info($id);

			$b = parent::del($id);

			/* 刪除圖片文件 */
			if($b){

				if ($info['thumb'] != '' && is_file('../' . $info['thumb']))
				{
					@unlink('../' . $info['thumb']);
				}

				if ($info['img'] != '' && is_file('../' . $info['img']))
				{
					@unlink('../' . $info['img']);
				}

				if ($info['original_img'] != '' && is_file('../' . $info['original_img']))
				{
					@unlink('../' . $info['original_img']);
				}
			}
			return $b;
		}
	}
?>