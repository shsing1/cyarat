<?php
	// 繼承cls_data類構造自己的類，便於在整個系統中調用
	require_once('cls_data.php');
	class cls_user extends cls_data {
		
		/* 會員名稱的字段名 */
		var $field_name     = 'name';
	
		/* 會員密碼的字段名 */
		var $field_pass     = 'password';
	
		/* cookie的domain */
		var $cookie_domain  = '';
	
		/* cookie的path */
		var $cookie_path    = '/';

		
		/* 取得資料列表 */
		function get_list($show_all=false){
			$arr = parent::get_list($show_all);
			foreach($arr['list'] as $k=>$v){
				$v['birthday'] = local_date($GLOBALS['_CFG']['date_format'], $v['birthday']);
				$arr['list'][$k] = $v;
			}
			return $arr;
		}
		function get_info($id=0){
			$info = parent::get_info($id);
			if($info){
				$info['birthday'] = local_date($GLOBALS['_CFG']['date_format'], $info['birthday']);
			}
			return $info;
		}
		
		/* 取得彈出式下拉選單 */
		function get_drop_down_menu(){
			global $_LANG;
			//$menus = $this->get_list();
			$menus = array();
			if($_SESSION['user_id'] != 0){
				$menus = array(
							   array('name'=>$_LANG['label_profile'], 'url'=>'?'.authcode('act=profile', 'ENCODE') ),
							   array('name'=>$_LANG['label_logout'], 'url'=>'?'.authcode('act=logout', 'ENCODE') )
							   );
			}
			
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
		 *  會員登入函數
		 *
		 * @access  public
		 * @param   string  $username
		 * @param   string  $password
		 *
		 * @return void
		 */
		function login($name='', $password='', $remember=0){
			/* 檢查會員登入資訊 */
			if ($this->check_user($name, $password) > 0)
			{
				$this->set_session($_SESSION['user_id']);				
				
				/* 記住我 */
				if($remember){
					$this->set_cookie($_SESSION['user_id']);
				}			
	
				return true;
			}
			else
			{
				return false;
			}
		}
		
		/**
		 *  檢查指定用戶是否存在及密碼是否正確
		 *
		 * @access  public
		 * @param   string  $username   用戶名
		 *
		 * @return  int
		 */
		function check_user($name, $password = null)
		{
	
			/* 如果沒有定義密碼則只檢查用戶名 */
			$_SESSION['user_id'] = 0;
			if ($password === null)
			{
				$sql = "SELECT " . $this->primary_name .
					   " FROM " . $this->table .
					   " WHERE " . $this->field_name . "='" . $name . "' ";
	
				$_SESSION['user_id'] = $this->db->getOne($sql);
			}
			else
			{
				$sql = "SELECT " . $this->primary_name .
					   " FROM " . $this->table.
					   " WHERE " . $this->field_name . "='" . $name . "' AND " . $this->field_pass . " ='" . md5($password) . "'";
	
				$_SESSION['user_id'] = $this->db->getOne($sql);
			}
			
			/* 更新會員資訊 */
			if(!empty($_SESSION['user_id'])){
				
				$this->update_user_info();
			}
			
			return $_SESSION['user_id'];
		}
		
		/**
		 *  設置指定用戶SESSION
		 *
		 * @access  public
		 * @param
		 *
		 * @return void
		 */
		function set_session ($id=0)
		{
			if (empty($id))
			{
				$GLOBALS['sess']->destroy_session();
			}
			else
			{				
				$row = $this->get_info($id);
	
				if ($row)
				{
					$_SESSION['user_id']   = $row['id'];
					$_SESSION['user_name'] = $row['name'];
					$_SESSION['email']     = $row['email'];
					$_SESSION['last_time']   = $row['last_login'];
					$_SESSION['last_ip']     = $row['last_ip'];
					$_SESSION['login_fail']  = 0;
					/* 取得會員分類和折扣 */
					$_SESSION['discount']  = 1;
				}
			}
		}
		
		/**
		 *  設置cookie
		 *
		 * @access  public
		 * @param
		 *
		 * @return void
		 */
		function set_cookie($id=0)
		{
			if (empty($id))
			{
				/* 摧毀cookie */
				$time = time() - 3600;
				setcookie('CHH[user_id]',  '', $time);
				setcookie('CHH[password]', '', $time);
			}
			else
			{
				/* 設置cookie */
				$time = time() + 3600 * 24 * 30;
				
				$row = $this->get_info($id);
				
				setcookie("CHH[username]", $row['name'], $time, $this->cookie_path, $this->cookie_domain);
				
				if ($row)
				{
					setcookie("CHH[user_id]", $row['id'], $time, $this->cookie_path, $this->cookie_domain);
					setcookie("CHH[password]", $row['password'], $time, $this->cookie_path, $this->cookie_domain);
				}
			}			
		}
	
		/**
		 *  根據登錄狀態設置cookie
		 *
		 * @access  public
		 * @param
		 *
		 * @return void
		 */
		function get_cookie()
		{
			$id = $this->check_cookie();
			
			if ($id)
			{
				$this->set_session($id);
				$this->set_cookie($id);
				return true;
			}
			else
			{
				return false;
			}
		}
	
		
		/**
		 *  檢查cookie是正確，返回用戶ID
		 *
		 * @access  public
		 * @param
		 *
		 * @return void
		 */
		function check_cookie()
		{
			$id = 0;
			
			if(!empty($_COOKIE['CHH']['user_id'])){
				$id = $_COOKIE['CHH']['user_id'];
			}
			
			return $id;
		}
		
		/**
		 * 更新用戶SESSION,COOKIE及登錄時間、登錄次數。
		 *
		 * @access  public
		 * @return  void
		 */
		function update_user_info()
		{
			if (!$_SESSION['user_id'])
			{
				return false;
			}
			
			$row = $this->get_info($_SESSION['user_id']);
			$field['visit_count'] = $row['visit_count']+1;
			$field['last_ip'] = real_ip();
			$field['last_login'] = gmtime();
			$field['id'] = $_SESSION['user_id'];
			
			$this->upd($field);
		}
		
		/**
		 * 會員登出
		 *
		 * @access  public
		 * @param
		 *
		 * @return void
		 */
		function logout ()
		{
			$this->set_cookie(); //清除cookie
			$this->set_session(); //清除session
		}
		
		/**
		 * 會員登出
		 *
		 * @access  public
		 * @param
		 *
		 * @return void
		 */
		function get_profile_by_name($name=''){
			
			$sql = " SELECT *".
				   " FROM " . $this->table .
				   " WHERE " .$this->field_name . "='$name'";
			$row = $this->db->getRow($sql);
	
			return $row;
		}
		
		/**
		 *  獲取指定用戶的信息
		 *
		 * @access  public
		 * @param
		 *
		 * @return void
		 */
		function get_profile_by_id($id)
		{
			$sql = " SELECT * ".
				   " FROM " . $this->table .
				   " WHERE " .$this->primary_name . "='$id'";
			$row = $this->db->getRow($sql);
	
			return $row;
		}
	}
?>