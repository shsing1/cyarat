<?php

/**
 * CHH 分類基礎類
 * ============================================================================
 *
 * ============================================================================
 * Author: shsing1
 * Id: cls_cat.php 2009-10-24 11:00:00
*/

if (!defined('IN_CHH'))
{
    die('Hacking attempt');
}

class cls_cat
{
	var $db     		= NULL;
	var $table			= '';
	var $insert_id		= 0;						// 最新建立的id
	var $root			= array('name'=>'',
							'lft'=>1,
							'rgt'=>2);
	var $page_name		= '';						// url的網頁名稱

    function __construct(&$db, $table)
    {
        $this->cls_cat($db, $table);
    }

    function cls_cat(&$db, $table)
    {
		$this->table      = $table;

        $this->db  = &$db;

        /* 檢查是否有root */
		if(!$this->has_root()){
			$this->create_root();
		}
    }

	/*
	 * 檢查是否有root
	 *
	 * @return  bloon
	 */
	function has_root()
	{
		$result = false;
		$sql =	"SELECT `id` " .
				"FROM ".$this->table ." ".
				"WHERE id = '1'";
		$row = $this->db->GetRow($sql);

		if ($row)
		{
			$result = true;
		}
		return $result;
	}

	/*
	 * 新增root
	 *
	 * @return  bloon
	 */
	function create_root()
	{
		$this->db->autoExecute($this->table, $this->root);
	}

	function get_list($parent = 1, $has_root = false){

		/* 在前台is_show必須為1 */
		if(!defined('CHH_ADMIN')){
			$where .= " AND node.`is_show` = 1 ";
		}

		$sql =	"SELECT node.*, (COUNT(parent.id) - (sub_tree.depth + 1)) AS depth, if(node.rgt=node.lft+1, 1, 0) AS is_leaf
				FROM ".$this->table ." AS node,
					".$this->table ." AS parent,
					".$this->table ." AS sub_parent,
					(
						SELECT node.id, (COUNT(parent.id) - 1) AS depth
						FROM ".$this->table ." AS node,
						".$this->table ." AS parent
						WHERE node.lft BETWEEN parent.lft AND parent.rgt
						AND node.id = '".$parent."'
						GROUP BY node.id
						ORDER BY node.lft
					)AS sub_tree
				WHERE node.lft BETWEEN parent.lft AND parent.rgt
					AND node.lft BETWEEN sub_parent.lft AND sub_parent.rgt
					AND sub_parent.id = sub_tree.id
					".$where."
				GROUP BY node.id
				ORDER BY node.lft;
				";
		$arr = $this->db->GetAll($sql);
		/* 設定url */
		foreach($arr as $k=>$v){
			$v['url'] = empty($v['url'])?$this->page_name."?".authcode("cat_id=".$v['id'], 'ENCODE'):$v['url'];
			$arr[$k] = $v;
		}

		if(!$has_root){
			array_shift($arr);
		}
		return $arr;

	}

	/* 選得下拉選單選項 */
	function get_list_option($parent = 1, $selected = 0, $self = 0){

		$info = $this->get_info($self);
		$where = '';
		if( $info ){
			$where = " AND !(node.lft BETWEEN ".$info['lft']." AND ".$info['rgt'].") ";
		}

		if($parent == $self){
			$where = " AND node.id != " .  $self;
		}

		$sql =	"SELECT node.id, node.name AS name, (COUNT(parent.id) - (sub_tree.depth + 1)) AS depth
				FROM ".$this->table ." AS node,
					".$this->table ." AS parent,
					".$this->table ." AS sub_parent,
					(
						SELECT node.name, (COUNT(parent.name) - 1) AS depth
						FROM ".$this->table ." AS node,
						".$this->table ." AS parent
						WHERE node.lft BETWEEN parent.lft AND parent.rgt
						AND node.id = '".$parent."'
						GROUP BY node.id
						ORDER BY node.lft
					)AS sub_tree
				WHERE node.lft BETWEEN parent.lft AND parent.rgt
					AND node.lft BETWEEN sub_parent.lft AND sub_parent.rgt
					AND sub_parent.name = sub_tree.name
					".$where."
				GROUP BY node.id
				ORDER BY node.lft;
				";

		$options = $this->db->GetAll($sql);

		$select = '';
        foreach ($options AS $var)
        {
            $select .= '<option value="' . $var['id'] . '" ';
            $select .= ($selected == $var['id']) ? "selected" : '';
            $select .= '>';

            $select .= str_repeat("&nbsp;&nbsp;", $var['depth']) . htmlspecialchars($var['name']) . '</option>';
        }

        return $select;
	}

	/* 新增分類 */
	function add($field, $location_from=1, $location_type=0){
		/* 取得基準點的info */
		$from = $this->get_info($location_from);

		switch($location_type){
			case 1:
				$point = $from['lft'];
				break;
			case 2:
				$point = $from['rgt']+1;
				break;
			default:
				$point = $from['rgt'];
				break;
		}

		// 鎖住資料表
		$this->db->query("LOCK TABLE ".$this->table." WRITE;");

		/* 空出新節點的位置 */
		$this->db->query("UPDATE ".$this->table." SET rgt = rgt + 2 WHERE rgt >= ".($point)."; ");
		$this->db->query("UPDATE ".$this->table." SET lft = lft + 2 WHERE lft >= ".($point)."; ");

		/* 資料入庫 */
		$field['lft'] = $point;
		$field['rgt'] = $point+1;

		$this->db->autoExecute($this->table, $field);

		$this->insert_id = $this->db->insert_id();

		// 解除鎖住資料表
		$this->db->query("UNLOCK TABLES;");

		/* 清除緩存*/
		clear_all_files();

		return true;
	}

	/* 取得最新建立的id */
	function get_insert_id(){
		return $this->insert_id;
	}

	/* 取得資料的info */
	function get_info($id=0){
		$sql =	"SELECT *
				FROM ".$this->table."
				WHERE `id` = '".$id."'
				";
		$arr = $this->db->getAll($sql);
		return $arr[0];
	}

	/* 取得父節點 */
	function get_parent($id=0, $all=false){
		$sql =	"SELECT parent.*
				FROM ".$this->table." AS node,
				".$this->table." AS parent
				WHERE node.lft BETWEEN parent.lft AND parent.rgt
				AND node.id = '".$id."'
				ORDER BY parent.lft;
				";
		$arr = $this->db->getAll($sql);

		if($all){
			return $arr;
		}else{
			return $arr[count($arr)-2];
		}

	}

	/* 編輯資料 */
	function upd($field, $location_from=1, $location_type=0){

		// 取得自身節點
		$self = $this->get_info($field['id']);

		// 取得父節點
		$parent = $this->get_parent($field['id']);

		// 父節點不同則更新
		if($parent['id'] != $location_from || $location_type != 0){
			/* 取得基準點的info */
			$datum = $this->get_info($location_from);

			/* 取得節點長度*/
			$self['width'] = $self['rgt'] - $self['lft'] + 1 ;

			switch($location_type){
				case 1:
					/* 空出節點的位置 */
					$this->db->query("UPDATE ".$this->table." SET `rgt` = `rgt` + ".$self['width']." WHERE `rgt` > ".($datum['lft']-1)."; ");
					$this->db->query("UPDATE ".$this->table." SET `lft` = `lft` + ".$self['width']." WHERE `lft` > ".($datum['lft']-1)."; ");

					/* 取得原節點新位置*/
					$new = $this->get_info($self['id']);

					/* 移動節點 */
					$width = $datum['lft'] - $new['lft'] ;
					$this->db->query("UPDATE ".$this->table." SET `lft` = `lft` + (".$width."), `rgt` = `rgt` + (".$width.") WHERE `lft` BETWEEN ".$new['lft']." AND ".$new['rgt']." ;");

					/* 修正節點資訊 */
					$this->db->query("UPDATE ".$this->table." SET `rgt` = `rgt` - ".$self['width']." WHERE rgt > ".($self['rgt'])."; ");
					$this->db->query("UPDATE ".$this->table." SET `lft` = `lft` - ".$self['width']." WHERE lft > ".($self['rgt'])."; ");

					break;

				case 2:
					/* 空出節點的位置 */
					$this->db->query("UPDATE ".$this->table." SET `rgt` = `rgt` + ".$self['width']." WHERE `rgt` > ".($datum['rgt'])."; ");
					$this->db->query("UPDATE ".$this->table." SET `lft` = `lft` + ".$self['width']." WHERE `lft` > ".($datum['rgt'])."; ");

					/* 取得原節點新位置*/
					$new = $this->get_info($self['id']);

					/* 移動節點 */
					$width = $datum['rgt'] - $new['lft'] + 1 ;
					$this->db->query("UPDATE ".$this->table." SET `lft` = `lft` + (".$width."), `rgt` = `rgt` + (".$width.") WHERE `lft` BETWEEN ".$new['lft']." AND ".$new['rgt']." ;");

					/* 修正節點資訊 */
					$this->db->query("UPDATE ".$this->table." SET `rgt` = `rgt` - ".$self['width']." WHERE rgt > ".($self['rgt'])."; ");
					$this->db->query("UPDATE ".$this->table." SET `lft` = `lft` - ".$self['width']." WHERE lft > ".($self['rgt'])."; ");

					break;

				default:
					/* 空出節點的位置 */
					$this->db->query("UPDATE ".$this->table." SET `rgt` = `rgt` + ".$self['width']." WHERE `rgt` > ".($datum['rgt']-1)."; ");
					$this->db->query("UPDATE ".$this->table." SET `lft` = `lft` + ".$self['width']." WHERE `lft` > ".($datum['rgt']-1)."; ");

					/* 取得原節點新位置*/
					$new = $this->get_info($self['id']);

					/* 移動節點 */
					$width = $datum['rgt'] + $self['width'] - $new['rgt'] -1 ;
					$this->db->query("UPDATE ".$this->table." SET `lft` = `lft` + (".$width."), `rgt` = `rgt` + (".$width.")  WHERE `lft` BETWEEN ".$new['lft']." AND ".$new['rgt']." ;");

					/* 修正節點資訊 */
					$this->db->query("UPDATE ".$this->table." SET `rgt` = `rgt` - ".$self['width']." WHERE rgt > ".($self['rgt'])."; ");
					$this->db->query("UPDATE ".$this->table." SET `lft` = `lft` - ".$self['width']." WHERE lft > ".($self['rgt'])."; ");

					break;
			}
		}

		/* 設定資料流水號 */
		$id = $field['id'];
		unset($field['id']);

		$field = array_diff_assoc($field, $self);

		// 鎖住資料表
		$this->db->query("LOCK TABLE ".$this->table." WRITE;");

		$this->db->autoExecute($this->table, $field, "UPDATE", "id=".$id."");

		// 解除鎖住資料表
		$this->db->query("UNLOCK TABLES;");

		/* 清除緩存*/
		clear_all_files();

		return true;
	}

	/* 取得資料列表 回傳陣列 */
	function get_list_arr(){
		$list = $this->get_list();

		$arr = array();
		foreach($list as $v){
			if($v['depth'] == 1){
				$v['childs'] = $this->get_childs($v, $list);
				$v['url'] = empty($v['url'])?$this->page_name."?".authcode("cat_id=".$v['id'], 'ENCODE'):$v['url'];
				$arr[] = $v;
			}
		}
		return $arr;
	}
	function get_childs($info, $list){
		$arr = array();
		foreach($list as $v){
			if($v['depth'] == ($info['depth']+1) && $v['lft'] > $info['lft']  && $v['rgt'] < $info['rgt']){
				$v['childs'] = $this->get_childs($v, $list);
				$v['url'] = empty($v['url'])?$this->page_name."?".authcode("cat_id=".$v['id'], 'ENCODE'):$v['url'];
				$arr[] = $v;
			}
		}
		return $arr;
	}

	/* 刪除資料 */
	function del($id=0){

		$b =  false;

		// 取得自身節點
		$self = $this->get_info($id);

		/* 取得節點長度*/
		$self['width'] = $self['rgt'] - $self['lft'] + 1 ;

		// 鎖住資料表
		$this->db->query("LOCK TABLE ".$this->table." WRITE;");

		/* 執行刪除動作*/
		$sql =	"DELETE FROM ".$this->table." WHERE lft BETWEEN ".$self['lft']." AND ".$self['rgt']." ; ";
		if ($this->db->query($sql)){
			$b = true;
		}else{
			$b = false;
		}

		/* 調整節點位置*/
		$this->db->query("UPDATE ".$this->table." SET rgt = rgt - ".$self['width']." WHERE rgt > ".($self['rgt'])."; ");
		$this->db->query("UPDATE ".$this->table." SET lft = lft - ".$self['width']." WHERE lft > ".($self['rgt'])."; ");

		// 解除鎖住資料表
		$this->db->query("UNLOCK TABLES;");

		return $b;

	}

	/* 取得分類路徑 */
	function get_ur_here($id){
		$ur_here = $this->get_parent($id, true);
		array_shift($ur_here);
		$arr = array();
		foreach($ur_here as $v){
			$arr[] = $v['name'];
		}
		$ur_here = join(' - ', $arr);
		return $ur_here;
	}

	/* 取得網頁標題 */
	function get_page_title($id){
		global $_CFG;

		$ur_here = $this->get_parent($id, true);
		arsort($ur_here);
		$arr = array();
		foreach($ur_here as $v){
			$arr[] = $v['name'];
		}

		$arr[] = $_CFG['site_title'] ;

		$ur_here = join(' - ', $arr);
		return $ur_here;
	}

	/* 取得彈出式下拉選單 */
	function get_drop_down_menu(){
		$menus = $this->get_list_arr();

		$str = '';
		foreach($menus as $v){
			if(count($v['childs']) > 0){
				$t = $this->create_sub_tree_html($v['childs']);
				if($v['url'] != ''){
					$v['name'] = '<a href="'.$v['url'].'" >'.$v['name'].'</a>';
				}
				$str .= '<li class="current">'.$v['name'].''.$t.'</li>';
			}else{
				if($v['url'] != ''){
					$v['name'] = '<a href="'.$v['url'].'" >'.$v['name'].'</a>';
				}
				$str .= '<li>'.$v['name'].'</li>';
			}
		}
		$str = '<ul class="sf-menu sf-vertical">'.$str.'</ul>';

		return $str;
	}

	function create_sub_tree_html($menus){
		$str = '';
		foreach($menus as $v){
			if(count($v['childs']) > 0){
				$t = $this->create_sub_tree_html($v['childs']);
				if($v['url'] != ''){
					$v['name'] = '<a href="'.$v['url'].'" >'.$v['name'].'</a>';
				}
				$str .= '<li class="current">'.$v['name'].''.$t.'</li>';
			}else{
				if($v['url'] != ''){
					$v['name'] = '<a href="'.$v['url'].'">'.$v['name'].'</a>';
				}
				$str .= '<li>'.$v['name'].'</li>';
			}
		}
		$str ='<ul>'.$str.'</ul>';
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

	/* 取得分類路徑 */
	function get_path($id, $last_url=false){
		global $_CFG, $_LANG;

		$ur_here = $this->get_parent($id, true);

		$arr = array();
		foreach($ur_here as $v){
			$v['url'] = empty($v['url'])?$this->page_name."?".authcode("cat_id=".$v['id'], 'ENCODE'):$v['url'];
			//$name = '<a href="'.$v['url'].'">'.$v['name'].'</a>';
			$name = $v['name'];
			if($id == $v['id'] && !$last_url){
				$name = $v['name'];
			}
			$arr[] = $name;
		}

		$ur_here = join(' / ', $arr);

		$ur_here = $_LANG['home'] . ' / ' . $ur_here;

		return $ur_here;
	}
}

?>