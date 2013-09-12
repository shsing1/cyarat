<?php

/**
 * CHH 資料基礎類
 * ============================================================================
 *
 * ============================================================================
 * Author: shsing1
 * Id: cls_data.php 2009-11-27 12:00:00
*/

if (!defined('IN_CHH'))
{
    die('Hacking attempt');
}

class cls_data
{
	var $db				= NULL;
	var $table			= '';
	var $insert_id		= 0;						// 最新建立的id
	var $foreign_name	= 'cat_id';
	var $primary_name	= 'id';
	var $search_field	= array('name');
	var $page_size		= 10;						// 單頁筆數
	var $cat			= '';						// 所屬分類物件
	var $page_name		= '';						// url的網頁名稱

    function __construct(&$db, $table, $cat='')
    {
        $this->cls_data($db, $table, $cat);
    }

    function cls_data(&$db, $table, $cat='')
    {
		$this->table      = $table;

        $this->db  = &$db;

		$this->cat  = $cat;

    }

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
					"ORDER BY ".$filter['sort_by']." ".$filter['sort_order']." ".
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
			$v['url'] = empty($v['url'])?$this->page_name."?".authcode("act=detail&id=".$v['id'], 'ENCODE'):$v['url'];
			$arr[$k] = $v;
		}
		return array('list' => $arr, 'filter' => $filter);

	}

	/* 新增資料 */
	function add($field){

		// 鎖住資料表
		$this->db->query("LOCK TABLE ".$this->table." WRITE;");

		$this->db->autoExecute($this->table, $field);

		/* 更新排序 */
		$this->insert_id = $id = $this->db->insert_id();

		// 解除鎖住資料表
		$this->db->query("UNLOCK TABLES;");

		$this->db->query("UPDATE ".$this->table." SET `sort` = ".$id." WHERE `".$this->primary_name."` = ".($id)."; ");

		/* 調整排序位置 */
		$this->adjustment_sort($field['sort'], $id);

		/* 清除緩存*/
		clear_all_files();

		return true;
	}

	/* 取得最新建立的id */
	function get_insert_id(){
		return $this->insert_id;
	}

	/*取得排序最大值 */
	function get_max_sort(){
		$sql =	"SELECT `sort` ".
				"FROM ".$this->table ." ".
				"ORDER BY `sort` DESC ".
				"LIMIT 1; ".
				"";
		$max = $this->db->GetOne($sql);
		return $max;
	}

	/*取得排序最小值 */
	function get_min_sort(){
		$sql =	"SELECT `sort` ".
				"FROM ".$this->table ." ".
				"ORDER BY `sort` ASC ".
				"LIMIT 1; ".
				"";
		$min = $this->db->GetOne($sql);
		return $min;
	}

	/* 取得資料的info */
	function get_info($id = 0){

		/* 在前台is_show必須為1 */
		$where = '';
		if(!defined('CHH_ADMIN')){
			$where = " AND `is_show` = 1 ";
		}

		$sql =	"SELECT * ".
				"FROM ".$this->table." ".
				"WHERE `".$this->primary_name."` = '".$id."' ".$where." ".
				"";
		$arr = $this->db->getRow($sql);
		return $arr;
	}

	/* 調整排序位置 */
	function adjustment_sort($sort, $id){

		/* 取得當前資料info */
		$info = $this->get_info($id);

		if($sort != 0 && $sort !=$info['sort'] ){

			/*取得排序最大值 */
			$max = $this->get_max_sort();
			/*取得排序最小值 */
			$min = $this->get_min_sort();
			/* 調整排序 */
			if($sort > $max){
				$sort = $max;

				/* 調整排序 */
				$this->db->query("UPDATE ".$this->table." SET `sort` = `sort` - 1 WHERE `sort` >= ".$info['sort']." ; ");
				/* 更新當前資料排序 */
				$this->db->query("UPDATE ".$this->table." SET `sort` = ".$sort." WHERE `".$this->primary_name."` = ".($id)."; ");
			}elseif($sort <= $min){
				$sort = $min;
				/* 空出排序位置 */
				$this->db->query("UPDATE ".$this->table." SET `sort` = `sort` + 1 WHERE `sort` >= ".$sort." AND `".$this->primary_name."` != ".$id."; ");
				/* 更新當前資料排序 */
				$this->db->query("UPDATE ".$this->table." SET `sort` = ".$sort." WHERE `".$this->primary_name."` = ".($id)."; ");
				/* 調整排序 */
				$this->db->query("UPDATE ".$this->table." SET `sort` = `sort` - 1 WHERE `sort` > ".$info['sort']." ; ");
			}else{
				/* 空出排序位置 */
				$this->db->query("UPDATE ".$this->table." SET `sort` = `sort` + 1 WHERE `sort` >= ".$sort." AND `".$this->primary_name."` != ".$id."; ");
				/* 更新當前資料排序 */
				$this->db->query("UPDATE ".$this->table." SET `sort` = ".$sort." WHERE `".$this->primary_name."` = ".($id)."; ");
				/* 調整排序 */
				$this->db->query("UPDATE ".$this->table." SET `sort` = `sort` - 1 WHERE `sort` > ".$info['sort']." ; ");
			}
		}

	}

	/**
	 * 取得上次的過濾條件
	 * @param   string  $param_str  參數字符串，由list函數的參數組成
	 * @return  如果有，返回array('filter' => $filter, 'sql' => $sql)；否則返回false
	 */

	function get_filter($param_str = ''){

		$filterfile = basename(PHP_SELF, '.php');
		if ($param_str)
		{
			$filterfile .= $param_str;
		}
		if (isset($_GET['uselastfilter']) && isset($_COOKIE['CHH']['lastfilterfile']) && $_COOKIE['CHH']['lastfilterfile'] == sprintf('%X', crc32($filterfile)))
		{
			return array(
				'filter' => unserialize(urldecode($_COOKIE['chh_lastfilter'])),
				//'filter' => unserialize(urldecode($_COOKIE['CHH']['lastfilter'])),
				'sql'    => urldecode($_COOKIE['CHH']['lastfiltersql'])
			);
		}
		else
		{
			return false;
		}
	}

	/**
	 * 保存過濾條件
	 * @param   array   $filter     過濾條件
	 * @param   string  $sql        查詢語句
	 * @param   string  $param_str  參數字符串，由list函數的參數組成
	 */
	function set_filter($filter, $sql, $param_str = '')
	{
		$filterfile = basename(PHP_SELF, '.php');
		if ($param_str)
		{
			$filterfile .= $param_str;
		}

		setcookie('CHH[lastfilterfile]', sprintf('%X', crc32($filterfile)), time() + 600);
		setcookie('CHH[lastfilter]',     urlencode(serialize($filter)), time() + 600);
		setcookie('chh_lastfilter',     urlencode(serialize($filter)), time() + 600);
		setcookie('CHH[lastfiltersql]',  urlencode($sql), time() + 600);

	}

	/**
	 * 分頁的信息加入條件的數組
	 *
	 * @access  public
	 * @return  array
	 */
	function page_and_size($filter)
	{
		if (isset($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0)
		{
			$filter['page_size'] = intval($_REQUEST['page_size']);
		}
		elseif (isset($_COOKIE['CHH']['page_size']) && intval($_COOKIE['CHH']['page_size']) > 0)
		{
			$filter['page_size'] = intval($_COOKIE['CHH']['page_size']);
		}
		else
		{
			$filter['page_size'] = $this->page_size;
		}

		/* 每頁顯示 */
		$filter['page'] = (empty($_REQUEST['page']) || intval($_REQUEST['page']) <= 0) ? 1 : intval($_REQUEST['page']);

		/* page 總數 */
		$filter['page_count'] = (!empty($filter['record_count']) && $filter['record_count'] > 0) ? ceil($filter['record_count'] / $filter['page_size']) : 1;

		/* 邊界處理 */
		if ($filter['page'] > $filter['page_count'])
		{
			$filter['page'] = $filter['page_count'];
		}

		$filter['start'] = ($filter['page'] - 1) * $filter['page_size'];

		return $filter;
	}

	/* 刪除資料 */
	function del($id=0){

		$b =  false;


		// 鎖住資料表
		$this->db->query("LOCK TABLE ".$this->table." WRITE;");

		/* 執行刪除動作*/
		$sql =	"DELETE FROM ".$this->table." WHERE `".$this->primary_name."` = ".$id." ; ";
		if ($this->db->query($sql)){
			$b = true;
		}else{
			$b = false;
		}

		// 解除鎖住資料表
		$this->db->query("UNLOCK TABLES;");

		return $b;

	}

	/* 更新編輯好的資料 */
	function upd($field){


		// 取得自身資料
		$self = $this->get_info($field['id']);

		/* 不更改排序 */
		if(isset($field['sort'])){
			/* 暫不更新排序 */
			$sort = $field['sort'];
			unset($field['sort']);
		}else{
			$sort = $self['sort'];
		}

		/* 設定資料流水號 */
		$id = $field['id'];
		unset($field['id']);

		$field = array_diff_assoc($field, $self);

		// 鎖住資料表
		$this->db->query("LOCK TABLE ".$this->table." WRITE;");

		$this->db->autoExecute($this->table, $field, "UPDATE", " `".$this->primary_name."` = '".$id."' ");

		// 解除鎖住資料表
		$this->db->query("UNLOCK TABLES;");

		/* 調整排序位置 */
		$this->adjustment_sort($sort, $id);

		/* 清除緩存*/
		clear_all_files();

		return true;
	}

	/* 取得彈出式下拉選單 */
	function get_drop_down_menu(){

		$menus = $this->get_list();
		$menus = $menus['list'];

		$str = '';
		foreach($menus as $v){
			if($v['url'] != ''){
				$v['name'] = '<a href="'.$v['url'].'" >'.$v['name'].'</a>';
			}
			$str .= '<li>'.$v['name'].'</li>';
		}
		$str = '<ul class="sf-menu sf-vertical">'.$str.'</ul>';

		return $str;
	}

	/**
    * 設定類中指定變數名的值，如果改變量不屬於這個類，將throw一個exception
    *
    * @param string $var
    * @param string $value
    */
    function set($var, $value)
    {
        if (in_array($var, get_object_vars($this)))
            $this->$var = $value;
        else
        {
            $this->error(__function__, $var . " does not belong to PB_Page!");
        }
    }

	/* 取得網頁標題 */
	function get_page_title($id){

		$info = $this->get_info($id);

		$ur_here = $this->cat->get_page_title($info[$this->foreign_name]);

		$ur_here = $info['name'] . ' - ' . $ur_here ;
		return $ur_here;
	}

	/* 是否已重複 */
	function is_duplicate($key='', $val='', $id=0){
		$sql =	"SELECT * ".
				"FROM ".$this->table." ".
				"WHERE `".$key."` = '".$val."' AND `".$this->primary_name."` <> ".$id." ".
				"";
		$arr = $this->db->getRow($sql);
		return $arr;
	}

	/* 取得資料路徑 */
	function get_path($id, $last_url=false){
		$info = $this->get_info($id);

		$ur_here = $this->cat->get_path($info[$this->foreign_name], true);

		$ur_here =  $ur_here. ' ＞ ' . $info['name'];
		return $ur_here;
	}
}

?>