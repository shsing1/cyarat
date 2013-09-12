<?php

/**
 * CHH SESSION 公用類庫
 * ============================================================================
 * 
 * ============================================================================
 * Author: shsing1
 * Id: cls_session.php 2009-10-24 11:00:00
*/

if (!defined('IN_CHH'))
{
    die('Hacking attempt');
}

class cls_session
{
    var $db             = NULL;
    var $session_table  = '';

    var $max_life_time  = 1800; // SESSION 過期時間

    var $session_name   = '';
    var $session_id     = '';

    var $session_expiry = '';
    var $session_md5    = '';

    var $session_cookie_path   = '/';
    var $session_cookie_domain = '';
    var $session_cookie_secure = false;

    var $_ip   = '';
    var $_time = 0;

    function __construct(&$db, $session_table, $session_name = 'CHH_ID', $session_id = '')
    {
        $this->cls_session($db, $session_table, $session_name, $session_id);
    }

    function cls_session(&$db, $session_table, $session_name = 'CHH_ID', $session_id = '')
    {
        $GLOBALS['_SESSION'] = array();

        if (!empty($GLOBALS['cookie_path']))
        {
            $this->session_cookie_path = $GLOBALS['cookie_path'];
        }
        else
        {
            $this->session_cookie_path = '/';
        }

        if (!empty($GLOBALS['cookie_domain']))
        {
            $this->session_cookie_domain = $GLOBALS['cookie_domain'];
        }
        else
        {
            $this->session_cookie_domain = '';
        }

        if (!empty($GLOBALS['cookie_secure']))
        {
            $this->session_cookie_secure = $GLOBALS['cookie_secure'];
        }
        else
        {
            $this->session_cookie_secure = false;
        }

        $this->session_name       = $session_name;
        $this->session_table      = $session_table;

        $this->db  = &$db;
        $this->_ip = real_ip();

        if ($session_id == '' && !empty($_COOKIE[$this->session_name]))
        {
            $this->session_id = $_COOKIE[$this->session_name];
        }
        else
        {
            $this->session_id = $session_id;
        }

        if ($this->session_id)
        {
            $tmp_session_id = substr($this->session_id, 0, 32);
            if ($this->gen_session_key($tmp_session_id) == substr($this->session_id, 32))
            {
                $this->session_id = $tmp_session_id;
            }
            else
            {
                $this->session_id = '';
            }
        }

        $this->_time = time();

        if ($this->session_id)
        {
            $this->load_session();
        }
        else
        {
            $this->gen_session_id();

            setcookie($this->session_name, $this->session_id . $this->gen_session_key($this->session_id), 0, $this->session_cookie_path, $this->session_cookie_domain, $this->session_cookie_secure);
        }

        register_shutdown_function(array(&$this, 'close_session'));
    }

    function gen_session_id()
    {
        $this->session_id = md5(uniqid(mt_rand(), true));

        return $this->insert_session();
    }

    function gen_session_key($session_id)
    {
        static $ip = '';

        if ($ip == '')
        {
            $ip = substr($this->_ip, 0, strrpos($this->_ip, '.'));
        }

        return sprintf('%08x', crc32(!empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] . ROOT_PATH . $ip . $session_id : ROOT_PATH . $ip . $session_id));
    }

    function insert_session()
    {
        return $this->db->query('INSERT INTO ' . $this->session_table . " (sesskey, expiry, ip, data) VALUES ('" . $this->session_id . "', '". $this->_time ."', '". $this->_ip ."', 'a:0:{}')");
    }

    function load_session()
    {		
        $session = $this->db->getRow('SELECT userid, adminid, user_name, user_rank, discount, email, data, expiry FROM ' . $this->session_table . " WHERE sesskey = '" . $this->session_id . "'");
        if (empty($session))
        {
            $this->insert_session();

            $this->session_expiry = 0;
            $this->session_md5    = '40cd750bba9870f18aada2478b24840a';
            $GLOBALS['_SESSION']  = array();
        }
        else
        {
            if (!empty($session['data']) && $this->_time - $session['expiry'] <= $this->max_life_time)
            {
                $this->session_expiry = $session['expiry'];
                $this->session_md5    = md5($session['data']);
                @$GLOBALS['_SESSION']  = unserialize($session['data']);
                $GLOBALS['_SESSION']['user_id'] 	= $session['userid'];
                $GLOBALS['_SESSION']['admin_id']	= $session['adminid'];
                $GLOBALS['_SESSION']['user_name']	= $session['user_name'];
                $GLOBALS['_SESSION']['user_rank']	= $session['user_rank'];
                $GLOBALS['_SESSION']['discount']	= $session['discount'];
                $GLOBALS['_SESSION']['email']		= $session['email'];
            }
            else
            {
               
				$this->session_expiry = 0;
				$this->session_md5    = '40cd750bba9870f18aada2478b24840a';
				$GLOBALS['_SESSION']  = array();
            }
        }
    }

    function update_session()
    {
        $adminid 	= !empty($GLOBALS['_SESSION']['admin_id'])	? intval($GLOBALS['_SESSION']['admin_id']) 	: 0;
        $userid  	= !empty($GLOBALS['_SESSION']['user_id'])	? intval($GLOBALS['_SESSION']['user_id'])  	: 0;
        $user_name  = !empty($GLOBALS['_SESSION']['user_name'])	? trim($GLOBALS['_SESSION']['user_name'])  	: 0;
        $user_rank  = !empty($GLOBALS['_SESSION']['user_rank'])	? intval($GLOBALS['_SESSION']['user_rank'])	: 0;
        $discount  	= !empty($GLOBALS['_SESSION']['discount'])  ? round($GLOBALS['_SESSION']['discount'], 2): 0;
        $email  	= !empty($GLOBALS['_SESSION']['email'])  	? trim($GLOBALS['_SESSION']['email'])  		: 0;
        unset($GLOBALS['_SESSION']['admin_id']);
        unset($GLOBALS['_SESSION']['user_id']);
        unset($GLOBALS['_SESSION']['user_name']);
        unset($GLOBALS['_SESSION']['user_rank']);
        unset($GLOBALS['_SESSION']['discount']);
        unset($GLOBALS['_SESSION']['email']);

        $data        = serialize($GLOBALS['_SESSION']);
        $this->_time = time();

        if ($this->session_md5 == md5($data) && $this->_time < $this->session_expiry + 10)
        {
            return true;
        }

        $data = addslashes($data);
       
        return $this->db->query('UPDATE ' . $this->session_table . " SET expiry = '" . $this->_time . "', ip = '" . $this->_ip . "', userid = '" . $userid . "', adminid = '" . $adminid . "', user_name='" . $user_name . "', user_rank='" . $user_rank . "', discount='" . $discount . "', email='" . $email . "', data = '$data' WHERE sesskey = '" . $this->session_id . "' LIMIT 1");
    }

    function close_session()
    {
        $this->update_session();

		// 刪除過期的sessions
        if ((time() % 2) == 0)
        {
			if(HAS_CART){
				$overdue = $this->get_overdue();
				/* 刪除過期購物車資料 */
				foreach($overdue as $v){
					$this->db->query('DELETE FROM ' . $GLOBALS['chh']->table('cart') . " WHERE session_id = '".$v['sesskey']."'");
				}
			}
            return $this->db->query('DELETE FROM ' . $this->session_table . ' WHERE expiry < ' . ($this->_time - $this->max_life_time));
        }

        return true;
    }
	
	/* 取得過期的sessions資料 */
	function get_overdue(){
		$sql = 'SELECT sesskey FROM ' . $this->session_table . ' WHERE expiry < ' . ($this->_time - $this->max_life_time);
		$arr = $this->db->GetAll($sql);
		return $arr;
	}

    function delete_spec_admin_session($adminid)
    {
        if (!empty($GLOBALS['_SESSION']['admin_id']) && $adminid)
        {
            return $this->db->query('DELETE FROM ' . $this->session_table . " WHERE adminid = '$adminid'");
        }
        else
        {
            return false;
        }
    }

    function destroy_session()
    {
        $GLOBALS['_SESSION'] = array();

        setcookie($this->session_name, $this->session_id, 1, $this->session_cookie_path, $this->session_cookie_domain, $this->session_cookie_secure);

        /* CHH 自定義執行部分 */
        if (!empty($GLOBALS['chh']))
        {
            //$this->db->query('DELETE FROM ' . $GLOBALS['chh']->table('cart') . " WHERE session_id = '$this->session_id'");
        }
        /* CHH 自定義執行部分 */
				
        //return $this->db->query('DELETE FROM ' . $this->session_table . " WHERE sesskey = '" . $this->session_id . "' LIMIT 1");
		/* 改成修改user_id或admin_id為0 */
		if(defined('CHH_ADMIN')){
			$this->db->query('UPDATE ' . $this->session_table . " SET adminid = '" . $adminid . "' WHERE sesskey = '" . $this->session_id . "' LIMIT 1");
		}else{
			$this->db->query('UPDATE ' . $this->session_table . " SET userid = '" . $userid . "'WHERE sesskey = '" . $this->session_id . "' LIMIT 1");
		}
    }

    function get_session_id()
    {
        return $this->session_id;
    }

    function get_users_count()
    {
        return $this->db->getOne('SELECT count(*) FROM ' . $this->session_table);
    }
	
	/* 驗證管理員身份 */
	function is_admin(){
		global $chh, $db, $_CFG;
		$result = false;		
		if ( (!isset($_SESSION['admin_id']) || intval($_SESSION['admin_id']) <= 0 || !empty($_SESSION['user_id'])) && $_REQUEST['act'] != 'signin' && $_REQUEST['act'] != 'forget_pwd' && $_REQUEST['act'] != 'reset_pwd' && $_REQUEST['act'] != 'get_pwd' && $_REQUEST['act'] != 'reset_pwd_act' ){
			
			/* session 不存在，檢查cookie */
			if (!empty($_COOKIE['CHH']['admin_id']) && !empty($_COOKIE['CHH']['admin_pass']))
			{
				// 找到了cookie, 驗證cookie信息
				$sql = 'SELECT id, cat_id, name, password, action_list, last_login ' .
						' FROM ' .$chh->table('admin_user') .
						" WHERE id = '" . intval($_COOKIE['CHH']['admin_id']) . "'";
				$row = $db->GetRow($sql);
		
				if (!$row)
				{
					// 沒有找到這個記錄
					setcookie($_COOKIE['CHH']['admin_id'],   '', 1);
					setcookie($_COOKIE['CHH']['admin_pass'], '', 1);
				}
				else
				{
					// 檢查密碼是否正確
					if (md5($row['password'] . $_CFG['hash_code']) == $_COOKIE['CHH']['admin_pass'])
					{
						!isset($row['last_time']) && $row['last_time'] = '';						
						set_admin_session($row['id'], $row['cat_id'], $row['name'], $row['action_list'], $row['last_time']);
		
						// 更新最後登錄時間和IP
						$db->query('UPDATE ' . $chh->table('admin_user') .
									" SET last_login = '" . gmtime() . "', last_ip = '" . real_ip() . "'" .
									" WHERE id = '" . $_SESSION['admin_id'] . "'");
						$result = true;
					}
				}
			}
		}else{
			$result = true;
		}
		
		return $result;
	}
}

?>