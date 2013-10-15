<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_news extends cls_data {
		var $upload_folder	= 'news';
		var $img_width		= 190;
		var $img_height		= 148;
//		var $img2_width		= 314;
//		var $img2_height	= 107;
		var $search_field	= array('name', 'desc');
		var $sp_where       = '';

		/* 取得資料列表 */
		function get_list($show_all=false, $cat_id=0){

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

			if($this->sp_where){
				$where .= $this->sp_where;
			}

			/* 關鍵字 */
			if ($filter['keyword'] != '' )
			{
				$arr = array();
				foreach($this->search_field as $v){
					$arr[] = "`".$v."` LIKE '%" . mysql_like_quote($filter['keyword']) . "%'";
				}
				$where .= " AND (".join('OR', $arr)." ) ";
			}

			/* 在前台is_show必須為1 */
			if(!defined('CHH_ADMIN')){
				$filter['is_show']	= 1;
				$where .= " AND `is_show` = 1 ";
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

				$sql = '';
				if(!$show_all){
					$sql =	"LIMIT " . $filter['start'] . ", ".$filter['page_size']." ;";
				}

				$sql =	"SELECT * ".
						"FROM ".$this->table ." ".
						"WHERE 1 ". $where ." ".
						"ORDER BY date DESC, ".$filter['sort_by']." ".$filter['sort_order']." ".
						"$sql";

				/* 保存過濾條件*/
				$filter['keyword'] = stripslashes($filter['keyword']);
				$this->set_filter($filter, $sql, $param_str);

			}else{
				$sql    = $result['sql'];
				$filter = $result['filter'];
			}

			$arr = $this->db->GetAll($sql);

			foreach($arr as $k=>$v){
				$v['no'] = $filter['start'] + ($k+1);
				$v['url'] = empty($v['url'])?$this->page_name."?".authcode("act=detail&id=".$v['id'], 'ENCODE'):$v['url'];
				$v['year'] = local_date('Y', $v['date']);
				$v['mon'] = local_date('n月', $v['date']);
				$v['day'] = local_date('d', $v['date']);
				$v['ap'] = local_date('a', $v['date']);
				$ap = $v['ap'] === 'am' ? '上午' : '下午';
				$v['sp_date'] = local_date('Y年n月j日 '.$ap.'h:i', $v['date']);
				$v['sp_date2'] = local_date('Y.n.j', $v['date']);
				$v['date'] = local_date($GLOBALS['_CFG']['time_format'], $v['date']);
				$cat_info = $this->cat->get_info($v['cat_id']);
				$v['cat_name'] = $cat_info['name'];

				$brief = strip_tags($v['desc']);
				$brief = preg_replace( "/[\s|&nbsp;]/mis", "" , $brief);
				// $brief = str_replace( array("&nbsp;", " "), array("", "") , $brief);
				$v['brief'] = $brief;

				$arr[$k] = $v;
			}
			return array('list' => $arr, 'filter' => $filter);

		}


		function get_info($id = 0){
			$info = parent::get_info($id);
			$v['year'] = local_date('Y', $v['date']);
			$v['mon'] = local_date('n月', $v['date']);
			$v['day'] = local_date('d', $v['date']);
			$info['date'] = local_date($GLOBALS['_CFG']['time_format'], $info['date']);
			$cat_info = $this->cat->get_info($info['cat_id']);
			$info['cat_name'] = $cat_info['name'];
			return $info;
		}

		/* 刪除資料時也要刪除圖片 */
		function del($id=0){
			global $chh, $db;

			/* 刪除圖片文件 */
			$this->drop_img($id);
			$this->drop_img2($id);

			$b = parent::del($id);

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

//					if ($info['img2'] != '' && is_file('../' . $info['img2']))
//					{
//						@unlink('../' . $info['img2']);
//					}

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
				$img  = $img2 = $original_img;   // 商品圖片

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
//					// 如果設置大小不為0，縮放圖片
//					if ($this->img2_width != 0 || $this->img2_height != 0)
//					{
//						$image->set_cut_type(1);
//						$img2 = $image->make_thumb('../'. $img2 , $this->img2_width,  $this->img2_height, $this->upload_folder );
//						if ($img2 === false)
//						{
//							make_json_error($image->error_msg());
//						}
//					}

					// 如果設置大小不為0，縮放圖片
					if ($this->img_width != 0 || $this->img_height != 0)
					{
						$image->set_cut_type(1);
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
//			$feild['img2'] = $img2;
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

//			/* 刪除圖片文件 */
//			if ($info['img2'] != '' && is_file('../' . $info['img2']))
//			{
//				@unlink('../' . $info['img2']);
//			}

			if ($info['original_img'] != '' && is_file('../' . $info['original_img']))
			{
				@unlink('../' . $info['original_img']);
			}

			$feild['id'] = $id;
			$feild['img'] = '';
//			$feild['img2'] = '';
			$feild['original_img'] = '';

			return $this->upd($feild);
		}

		// 設定單頁顯示數
		function set_page_size($size=15){
			$t = strtotime("+1 day -1 seconds", strtotime(date('Y-m-d')));
			setcookie('news_page_size', intval($size), $t);
		}

		// 取得單頁顯示數
		function get_page_size(){
			$size = 15;
			if(isset($_COOKIE['news_page_size'])){
				$size = $_COOKIE['news_page_size'];
			}

			return $size;
		}

		// 點擊加一
		function add_hit($id=0){
			if(!isset($_COOKIE['news_hit_'.$id])){
				$info =  $this->get_info($id);
				$feild = array();
				$feild['id'] = $info['id'];
				$feild['hit'] = $info['hit']+1;
				$this->upd($feild);
				$t = strtotime("+1 day -1 seconds", strtotime(date('Y-m-d')));
				setcookie('news_hit_'.$id, 1, $t);
			}
		}

		// 取得資料的年份群組
		public function get_year_list(){
			$where = '';

			/* 在前台is_show必須為1 */
			if(!defined('CHH_ADMIN')){
				$filter['is_show']	= 1;
				$where .= " AND `is_show` = 1 ";
			}

			$sql =	"SELECT FROM_UNIXTIME(date, '%Y') AS year ".
					"FROM ".$this->table ." ".
					"WHERE 1 ". $where ." ".
					"GROUP BY FROM_UNIXTIME(date, '%Y') ";

			$arr = $this->db->GetAll($sql);

			return $arr;
		}

		// 重新產生縮圖
		public function thumb_reset(){
			global $_CFG;

			/* 建立圖片物件 */
			include_once(ROOT_PATH . '/includes/cls_image.php');
			$image = new cls_image($_CFG['bgcolor']);

			$list = $this->get_list();
			$list = $list['list'];
			foreach($list as $info){
				/* 刪除原來的圖片文件 */
				if ($info['img'] != '' && is_file('../' . $info['img']))
				{
					@unlink('../' . $info['img']);
				}

//				if ($info['img2'] != '' && is_file('../' . $info['img2']))
//				{
//					@unlink('../' . $info['img2']);
//				}
				$img  = $img2 = '../' . $info['original_img'];   // 商品圖片

				// 如果系統支持GD，縮放圖片，且給圖片和相冊圖片加水印
				if ($image->gd_version() > 0 )
				{
//					// 如果設置大小不為0，縮放圖片
//					if ($this->img2_width != 0 || $this->img2_height != 0)
//					{
//						$image->set_cut_type(1);
//						$img2 = $image->make_thumb($img2 , $this->img2_width,  $this->img2_height, $this->upload_folder );
//						if ($img2 === false)
//						{
//							make_json_error($image->error_msg());
//						}
//					}

					// 如果設置大小不為0，縮放圖片
					if ($this->img_width != 0 || $this->img_height != 0)
					{
						$image->set_cut_type(1);
						$img = $image->make_thumb($img , $this->img_width,  $this->img_height, $this->upload_folder );
						if ($img === false)
						{
							make_json_error($image->error_msg());
						}
					}
				}

				/* info更新 */
				$feild = array();
				$feild['id'] = $info['id'];
				$feild['img'] = $img;
//				$feild['img2'] = $img2;

				$this->upd($feild);
			}
			echo '完成';
		}

		/* 處理上傳圖片 */
		function upload_img2($file, $id = 0){
			global $_CFG;

			/* 建立圖片物件 */
			include_once(ROOT_PATH . '/includes/cls_image.php');
			$image = new cls_image($_CFG['bgcolor']);

			/* 檢查圖片：如果有錯誤，檢查尺寸是否超過最大值；否則，檢查文件類型 */
			if (isset($file['img2']['error'])) // php 4.2 版本才支持 error
			{
				// 最大上傳文件大小
				$php_maxsize = ini_get('upload_max_filesize');
				$htm_maxsize = '2M';

				// 圖片
				if ($file['img2']['error'] == 1)
				{
					make_json_error(sprintf($_LANG['img_too_big'], $php_maxsize));
				}
				elseif ($file['img2']['error'] == 2)
				{
					make_json_error(sprintf($_LANG['img_too_big'], $htm_maxsize));
				}
			}

			// 如果上傳圖片，相應處理
			if ($file['img2']['tmp_name'] != '' && $file['img2']['tmp_name'] != 'none')
			{
				if ($id > 0)
				{
					/* 刪除原來的圖片文件 */
					$info = $this->get_info($id);
					if ($info['img2'] != '' && is_file('../' . $info['img2']))
					{
						@unlink('../' . $info['img2']);
					}
				}

				$img2   = $image->upload_image($file['img2'], $this->upload_folder); // 原始圖片

			}

			/* info更新 */

			$feild['id'] = $id;
			$feild['img2'] = $img2;

			return $this->upd($feild);
		}

		/* 刪除該筆資料的圖片 */
		function drop_img2($id=0){

			$info = $this->get_info($id);

			/* 刪除圖片文件 */
			if ($info['img2'] != '' && is_file('../' . $info['img2']))
			{
				@unlink('../' . $info['img2']);
			}

			$feild['id'] = $id;
			$feild['img2'] = '';

			return $this->upd($feild);
		}
	}
?>