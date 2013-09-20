<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_art extends cls_data {
		var $upload_folder	= 'art';
		var $img_width		= 226;
		var $img_height		= 337;

		/* 刪除資料時也要刪除圖片 */
		function del($id=0){
			global $chh, $db;

			/* 刪除圖片文件 */
			$this->drop_img($id);

			$b = parent::del($id);

			/* 刪除相簿圖片 */
			require_once(ROOT_PATH . '/includes/cls_art_img.php');
			$data_img = new cls_art_img($db, $chh->table("art_img") );
			$list = $data_img->get_img_list($id);
			foreach($list['list'] as $v){
				$data_img->del($v['id']);
			}

			return $b;
		}

		/* 處理上傳圖片 */
		function upload_img($file, $id = 0){
			global $_CFG;

			/* 建立圖片物件 */
			include_once(ROOT_PATH . '/includes/cls_image.php');
			$image = new cls_image($_CFG['bgcolor']);

			/* 檢查圖片：如果有錯誤，檢查尺寸是否超過最大值；否則，檢查文件類型 */
			if (isset($file['img']['error'])) // php 4.2 版本才支持 error
			{
				// 最大上傳文件大小
				$php_maxsize = ini_get('upload_max_filesize');
				$htm_maxsize = '2M';

				// 圖片
				if ($file['img']['error'] == 1)
				{
					make_json_error(sprintf($_LANG['img_too_big'], $php_maxsize));
				}
				elseif ($file['img']['error'] == 2)
				{
					make_json_error(sprintf($_LANG['img_too_big'], $htm_maxsize));
				}
			}

			// 如果上傳圖片，相應處理
			if ($file['img']['tmp_name'] != '' && $file['img']['tmp_name'] != 'none')
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

				$original_img   = $image->upload_image($file['img'], $this->upload_folder); // 原始圖片
				if ($original_img === false)
				{
					make_json_error($image->error_msg());
				}
				$img  = $original_img;   // 商品圖片

				/* 依副檔名設定檔案形態 */
				$suffix = get_file_suffix($file['img']['name']);
				switch($suffix){
					case 'gif':
						$file['img']['type'] = 'image/gif';
						break;
					case 'png':
						$file['img']['type'] = 'image/png';
						break;
					default:
						$file['img']['type'] = 'image/jpeg';
						break;
				}

				// 如果系統支持GD，縮放圖片，且給圖片和相冊圖片加水印
				if ($image->gd_version() > 0 && $image->check_img_function($file['img']['type']))
				{
					// 如果設置大小不為0，縮放圖片
					if ($this->img_width != 0 || $this->img_height != 0)
					{
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

			$feild['id'] = $id;
			$feild['img'] = $img;
			$feild['original_img'] = $original_img;

			return $this->upd($feild);
		}

		/* 刪除該筆資料的圖片 */
		function drop_img($id=0){

			$info = $this->get_info($id);

			/* 刪除圖片文件 */
			if ($info['img'] != '' && is_file('../' . $info['img']))
			{
				@unlink('../' . $info['img']);
			}

			if ($info['original_img'] != '' && is_file('../' . $info['original_img']))
			{
				@unlink('../' . $info['original_img']);
			}

			$feild['id'] = $id;
			$feild['img'] = '';
			$feild['original_img'] = '';

			return $this->upd($feild);
		}

	}
?>