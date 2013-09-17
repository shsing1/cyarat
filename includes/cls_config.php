<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_config extends cls_data {
		var $upload_folder	= 'config';
		var $img_width		= 100;
		var $img_height		= 100;

		function get_list($show_all = false, $cat_id = 0){
			global $_LANG;

			$arr = parent::get_list($show_all, $cat_id);

			foreach($arr['list'] as $k=>$v){
				$v['fomat_type'] = $_LANG['type_list'][$v['type']];
				$arr['list'][$k] = $v;
			}
			return $arr;
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
					if ($info['value'] != '' && is_file('../' . $info['value']))
					{
						@unlink('../' . $info['value']);
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

			}

			/* info更新 */

			$feild['id'] = $id;
			$feild['value'] = $img;

			return $this->upd($feild);
		}

		/* 刪除所上傳的檔案 */
		function del_file($id){

			if ($id > 0)
			{
				/* 刪除原來的圖片文件 */
				$info = $this->get_info($id);

				if ($info['value'] != '' && is_file('../' . $info['value']))
				{
					@unlink('../' . $info['value']);
				}

				$field['id']	= $id;
    			$field['value'] = '';

				if(!$this->upd($field)){
					make_json_error($_LANG['data_upd_failed']);
				}

			}
			return true;
		}

	}
?>