<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_cart extends cls_data {
		
		var $foreign_name	= 'session_id';
		
		var $goods_cat_obj = '';
		var $goods_obj = '';
		
		function __construct(&$db, $table, $cat='')
		{
			global $chh;
			
			require_once(ROOT_PATH . '/includes/cls_goods_cat.php');
			$this->goods_cat_obj = new cls_goods_cat($db, $chh->table("goods_cat") );
			
			require_once(ROOT_PATH . '/includes/cls_goods.php');
			$this->goods_obj = new cls_goods($db, $chh->table("goods"), $goods_cat_obj);

			parent::__construct($db, $table, $cat='');
		}
		
		/* 取得資料列表 */
		function get_list($id){
			global $_CFG;
			
			$filter['keyword']				= empty($_REQUEST['keyword']) 			? '' 		: trim($_REQUEST['keyword']);
			$filter['sort_by']				= empty($_REQUEST['sort_by']) 			? 'sort'	: trim($_REQUEST['sort_by']);
			$filter['sort_order']			= empty($_REQUEST['sort_order'])		? 'DESC' 	: trim($_REQUEST['sort_order']);
			
			
			$where = " AND ".$this->foreign_name." = '".$id."' ";
			
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
			/* 取得上次的過濾條件 */
			$result = $this->get_filter($param_str);
			if ($result === false){
				
				
				$sql =	"SELECT * ".
						"FROM ".$this->table ." ".
						"WHERE 1 ". $where ." ".
						"ORDER BY ".$filter['sort_by']." ".$filter['sort_order']." ;";
	
				/* 保存過濾條件*/
				$filter['keyword'] = stripslashes($filter['keyword']);
				$this->set_filter($filter, $sql, $param_str);
				
			}else{
				$sql    = $result['sql'];
				$filter = $result['filter'];
			}
					
			$arr = $this->db->GetAll($sql);	
			/* 取得商品資訊 */
			foreach($arr as $k=>$v){
				
				$goods_info = $this->goods_obj->get_info($v['goods_id']);
				
				$goods_info['thumb_url']	= empty($goods_info['img'])?'../../images/no_picture.gif':'../../'.$goods_info['img'];
				$goods_info['url'] = empty($goods_info['url'])?"goods.php?".authcode("act=detail&id=".$goods_info['id'], 'ENCODE'):$v['url'];
				/* 格式化價格 */				
				$goods_info['format_subtotal'] = price_format($goods_info['price'] * $v['goods_number']);
        		$goods_info['format_price']  = price_format($goods_info['price']);
        		$goods_info['format_market'] = price_format($goods_info['market']);
				
				$v['goods_info'] = $goods_info;
				$arr[$k] = $v;
				
			}
			return array('list' => $arr, 'filter' => $filter);
			
		}
		
		/* 取得資料的info */
		function get_info($id=0){
			
			$sql =	"SELECT * ".
					"FROM ".$this->table." ".
					"WHERE `".$this->primary_name."` = ".$id." ".$where." ".
					"";
			$arr = $this->db->getRow($sql);
			return $arr;
		}
		
		/* 是否已重複 */
		function is_duplicate($fields='', $id=0){
			
			$sets = array();
			foreach($fields as $k=>$v){
				$sets[] = '`' . $k . '`' . " = '" . $v . "'";
			}
			
			$sql =	" SELECT * ".
					" FROM ".$this->table.
					" WHERE 1 AND ".implode(' AND ', $sets);
					
			$arr = $this->db->getRow($sql);
			return $arr;
		}
		
		/* 取得網頁標題 */
		function get_page_title(){	
			
			$arr[] = $GLOBALS['_LANG']['cart'];
			$arr[] = $GLOBALS['_CFG']['site_title'] ;
		
			$ur_here = join(' - ', $arr);
			return $ur_here;
		}
	}
?>