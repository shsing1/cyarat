<?php

/**
 * CHH 管理員信息以及權限管理程序
 * ============================================================================
 * 
 * ============================================================================
 * Author: shsing1
 * Id: index.php 2009-11-04 17:00:00
*/
define('IN_CHH', true);

require(dirname(__FILE__) . '/includes/init.php');

/* act操作項的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'login';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}

/* 初始化 $exc 對像 */
//$exc = new exchange($chh->table("admin_user"), $db, 'id', 'name');

/*------------------------------------------------------ */
//-- 退出登錄
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'logout')
{
    /* 清除cookie */
    setcookie('CHH[admin_id]',   '', 1);
    setcookie('CHH[admin_pass]', '', 1);

    $sess->destroy_session();

    $_REQUEST['act'] = 'login';
}

/*------------------------------------------------------ */
//-- 登陸界面
/*------------------------------------------------------ */
if ($_REQUEST['act'] == 'login')
{
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");

    if ((intval($_CFG['captcha']) ) && gd_version() > 0)
    {
        $smarty->assign('gd_version', gd_version());
        $smarty->assign('random',     mt_rand());
    }

    $smarty->display('login.htm');
	
}

/*------------------------------------------------------ */
//-- 驗證登陸信息
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'signin')
{
	$_POST['username'] = isset($_POST['username']) ? trim($_POST['username']) : '';
    $_POST['password'] = isset($_POST['password']) ? trim($_POST['password']) : '';

	if(empty($_POST['username'])){
		make_json_error($_LANG['name_empty']);
	}
	if(empty($_POST['password'])){
		make_json_error($_LANG['password_empty']);
	}
    if (isset($_SESSION['captcha_word']) )
    {
        include_once(ROOT_PATH . 'includes/cls_captcha.php');

        /* 檢查驗證碼是否正確 */
        $validator = new captcha();
		if(empty($_POST['captcha'])){
			make_json_error($_LANG['captcha_empty']);
		}
        if (isset($_POST['captcha']) && !$validator->check_word($_POST['captcha']))
        {
			make_json_error($_LANG['captcha_error']);
        }
    }

    /* 檢查密碼是否正確 */
    $sql = "SELECT id, cat_id, name, password, last_login, action_list, last_login, is_show ".
            " FROM " . $chh->table('admin_user') .
            " WHERE name = '" . $_POST['username']. "' AND password = '" . md5($_POST['password']) . "'";
    $row = $db->getRow($sql);

    if ($row)
    {
		/*帳號是否啟用*/
		if($row['is_show'] == 0){
			make_json_error($_LANG['admin_disable']);		
		}
		
        // 登錄成功
        set_admin_session($row['id'], $row['cat_id'], $row['name'], $row['action_list'], $row['last_login']);

//        if($row['action_list'] == 'all' && empty($row['last_login']))
//        {
//            $_SESSION['shop_guide'] = true;
//        }

        // 更新最後登錄時間和IP
        $db->query("UPDATE " .$chh->table('admin_user').
                 " SET last_login='" . gmtime() . "', last_ip='" . real_ip() . "'".
                 " WHERE id='$_SESSION[admin_id]'");

        if (isset($_POST['remember']))
        {
            $time = gmtime() + 3600 * 24 * 365;
            setcookie('CHH[admin_id]'	, $row['id']								, $time);
            setcookie('CHH[admin_pass]'	, md5($row['password'] . $_CFG['hash_code']), $time);
        }

        // 清除購物車中過期的數據
		if(HAS_CART){
        	clear_cart();
		}
		make_json_result('','', array('url'=>'index.php'));

//        chh_header("Location: ./index.php\n");
//
//        exit;
    }
    else
    {
		make_json_error($_LANG['login_faild']);
    }
}

/*------------------------------------------------------ */
//-- 管理員列表頁面
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'list')
{
    /* 模板賦值 */
    $smarty->assign('ur_here',     $_LANG['admin_list']);
    $smarty->assign('action_link', array('href'=>'privilege.php?act=add', 'text' => $_LANG['admin_add']));
    $smarty->assign('full_page',   1);
    $smarty->assign('admin_list',  get_admin_userlist());

    /* 顯示頁面 */
    assign_query_info();
    $smarty->display('privilege_list.htm');
}

/*------------------------------------------------------ */
//-- 查詢
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'query')
{
    $smarty->assign('admin_list',  get_admin_userlist());

    make_json_result($smarty->fetch('privilege_list.htm'));
}

/*------------------------------------------------------ */
//-- 添加管理員頁面
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'add')
{
    /* 檢查權限 */
    admin_priv('admin_manage');

     /* 模板賦值 */
    $smarty->assign('ur_here',     $_LANG['admin_add']);
    $smarty->assign('action_link', array('href'=>'privilege.php?act=list', 'text' => $_LANG['admin_list']));
    $smarty->assign('form_act',    'insert');
    $smarty->assign('action',      'add');

    /* 顯示頁面 */
    assign_query_info();
    $smarty->display('privilege_info.htm');
}

/*------------------------------------------------------ */
//-- 添加管理員的處理
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'insert')
{
    admin_priv('admin_manage');

    /* 判斷管理員是否已經存在 */
    if (isset($_POST['name']))
    {
        $is_only = $exc->is_only('name', stripslashes($_POST['name']));

        if (!$is_only)
        {
            sys_msg(sprintf($_LANG['name_exist'], stripslashes($_POST['name'])), 1);
        }
    }

    /* Email地址是否有重複 */
    if (isset($_POST['email']))
    {
        $is_only = $exc->is_only('email', stripslashes($_POST['email']));

        if (!$is_only)
        {
            sys_msg(sprintf($_LANG['email_exist'], stripslashes($_POST['email'])), 1);
        }
    }

    /* 獲取添加日期及密碼 */
    $add_time = gmtime();
    $password  = md5($_POST['password']);

    $sql = "SELECT nav_list FROM " . $chh->table('admin_user') . " WHERE action_list = 'all'";
    $row = $db->getRow($sql);

    $sql = "INSERT INTO ".$chh->table('admin_user')." (name, email, password, add_time, nav_list) ".
           "VALUES ('".trim($_POST['name'])."', '".trim($_POST['email'])."', '$password', '$add_time', '$row[nav_list]')";

    $db->query($sql);
    /* 轉入權限分配列表 */
    $new_id = $db->Insert_ID();

    /*添加鏈接*/
    $link[0]['text'] = $_LANG['go_allot_priv'];
    $link[0]['href'] = 'privilege.php?act=allot&id='.$new_id.'&user='.$_POST['name'].'';

    $link[1]['text'] = $_LANG['continue_add'];
    $link[1]['href'] = 'privilege.php?act=add';

    sys_msg($_LANG['add'] . "&nbsp;" .$_POST['name'] . "&nbsp;" . $_LANG['action_succeed'],0, $link);

    /* 記錄管理員操作 */
    admin_log($_POST['name'], 'add', 'privilege');
 }

/*------------------------------------------------------ */
//-- 編輯管理員信息
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'edit')
{
    /* 不能編輯demo這個管理員 */
    if ($_SESSION['admin_name'] == 'demo')
    {
       $link[] = array('text' => $_LANG['back_list'], 'href'=>'privilege.php?act=list');
       sys_msg($_LANG['edit_admininfo_cannot'], 0, $link);
    }

    $_REQUEST['id'] = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

    /* 查看是否有權限編輯其他管理員的信息 */
    if ($_SESSION['admin_id'] != $_REQUEST['id'])
    {
        admin_priv('admin_manage');
    }

    /* 獲取管理員信息 */
    $sql = "SELECT id, name, email, password, agency_id FROM " .$chh->table('admin_user').
           " WHERE id = '".$_REQUEST['id']."'";
    $user_info = $db->getRow($sql);

    /* 取得該管理員負責的辦事處名稱 */
    if ($user_info['agency_id'] > 0)
    {
        $sql = "SELECT agency_name FROM " . $chh->table('agency') . " WHERE agency_id = '$user_info[agency_id]'";
        $user_info['agency_name'] = $db->getOne($sql);
    }

    /* 模板賦值 */
    $smarty->assign('ur_here',     $_LANG['admin_edit']);
    $smarty->assign('action_link', array('text' => $_LANG['admin_list'], 'href'=>'privilege.php?act=list'));
    $smarty->assign('user',        $user_info);

    $smarty->assign('form_act',    'update');
    $smarty->assign('action',      'edit');

    assign_query_info();
    $smarty->display('privilege_info.htm');
}

/*------------------------------------------------------ */
//-- 更新管理員信息
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'update' || $_REQUEST['act'] == 'update_self')
{

    /* 變量初始化 */
    $admin_id    = isset($_REQUEST['id'])        ? intval($_REQUEST['id'])      : 0;
    $admin_name  = isset($_REQUEST['name']) ?	 trim($_REQUEST['name']) : '';
    $admin_email = isset($_REQUEST['email'])     ? trim($_REQUEST['email'])     : '';

    $password = isset($_POST['new_password']) ? ", password = '".md5($_POST['new_password'])."'"    : '';
    if ($_REQUEST['act'] == 'update')
    {
        /* 查看是否有權限編輯其他管理員的信息 */
        if ($_SESSION['admin_id'] != $_REQUEST['id'])
        {
            admin_priv('admin_manage');
        }
        $g_link = 'privilege.php?act=list';
        $nav_list = '';
    }
    else
    {
        $nav_list = isset($_POST['nav_list'])     ? ", nav_list = '".@join(",", $_POST['nav_list'])."'" : '';
        $admin_id = $_SESSION['admin_id'];
        $g_link = 'privilege.php?act=modif';
    }
    /* 判斷管理員是否已經存在 */
    if (isset($admin_name))
    {
        $is_only = $exc->num('name', stripslashes($admin_name), $admin_id);
        if ($is_only == 1)
        {
            sys_msg(sprintf($_LANG['name_exist'], stripslashes($admin_name)), 1);
        }
    }

    /* Email地址是否有重複 */
    if (isset($admin_email))
    {
        $is_only = $exc->num('email', stripslashes($admin_email), $admin_id);

        if ($is_only == 1)
        {
            sys_msg(sprintf($_LANG['email_exist'], stripslashes($admin_email)), 1);
        }
    }

    //如果要修改密碼
    $pwd_modified = false;

    if (isset($_POST['new_password']))
    {
        /* 查詢舊密碼並與輸入的舊密碼比較是否相同 */
        $sql = "SELECT password FROM ".$chh->table('admin_user')." WHERE id = '$admin_id'";
        $old_password = $db->getOne($sql);
        if ($old_password <> (md5($_POST['old_password'])))
        {
           $link[] = array('text' => $_LANG['go_back'], 'href'=>'javascript:history.back(-1)');
           sys_msg($_LANG['pwd_error'], 0, $link);
        }

        /* 比較新密碼和確認密碼是否相同 */
        if ($_POST['new_password'] <> $_POST['pwd_confirm'])
        {
           $link[] = array('text' => $_LANG['go_back'], 'href'=>'javascript:history.back(-1)');
           sys_msg($_LANG['js_languages']['password_error'], 0, $link);
        }
        else
        {
            $pwd_modified = true;
        }
    }

    //更新管理員信息
    $sql = "UPDATE " .$chh->table('admin_user'). " SET ".
           "name = '$admin_name', ".
           "email = '$admin_email'".
           $password.
           $nav_list.
           "WHERE id = '$admin_id'";

   $db->query($sql);
   /* 記錄管理員操作 */
   admin_log($_POST['name'], 'edit', 'privilege');

   /* 如果修改了密碼，則需要將session中該管理員的數據清空 */
   if ($pwd_modified && $_REQUEST['act'] == 'update_self')
   {
       $sess->delete_spec_admin_session($_SESSION['admin_id']);
       $msg = $_LANG['edit_password_succeed'];
   }
   else
   {
       $msg = $_LANG['edit_profile_succeed'];
   }

   /* 提示信息 */
   $link[] = array('text' => strpos($g_link, 'list') ? $_LANG['back_admin_list'] : $_LANG['modif_info'], 'href'=>$g_link);
   sys_msg("$msg<script>parent.document.getElementById('header-frame').contentWindow.document.location.reload();</script>", 0, $link);

}

/*------------------------------------------------------ */
//-- 編輯個人資料
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'modif')
{
    /* 不能編輯demo這個管理員 */
    if ($_SESSION['admin_name'] == 'demo')
    {
       $link[] = array('text' => $_LANG['back_admin_list'], 'href'=>'privilege.php?act=list');
       sys_msg($_LANG['edit_admininfo_cannot'], 0, $link);
    }

    include_once('includes/inc_menu.php');

    /* 包含插件菜單語言項 */
    $sql = "SELECT code FROM ".$chh->table('plugins');
    $rs = $db->query($sql);
    while ($row = $db->FetchRow($rs))
    {
        /* 取得語言項 */
        if (file_exists(ROOT_PATH.'plugins/'.$row['code'].'/languages/common_'.$_CFG['lang'].'.php'))
        {
            include_once(ROOT_PATH.'plugins/'.$row['code'].'/languages/common_'.$_CFG['lang'].'.php');
        }

        /* 插件的菜單項 */
        if (file_exists(ROOT_PATH.'plugins/'.$row['code'].'/languages/inc_menu.php'))
        {
            include_once(ROOT_PATH.'plugins/'.$row['code'].'/languages/inc_menu.php');
        }
    }

    foreach ($modules AS $key => $value)
    {
        ksort($modules[$key]);
    }
    ksort($modules);

    foreach ($modules AS $key => $val)
    {
        $menus[$key]['label'] = $_LANG[$key];
        if (is_array($val))
        {
            foreach ($val AS $k => $v)
            {
                $menus[$key]['children'][$k]['label']  = $_LANG[$k];
                $menus[$key]['children'][$k]['action'] = $v;
            }
        }
        else
        {
            $menus[$key]['action'] = $val;
        }
    }

    /* 獲得當前管理員數據信息 */
    $sql = "SELECT id, name, email, nav_list ".
           "FROM " .$chh->table('admin_user'). " WHERE id = '".$_SESSION['admin_id']."'";
    $user_info = $db->getRow($sql);

    /* 獲取導航條 */
    $nav_arr = (trim($user_info['nav_list']) == '') ? array() : explode(",", $user_info['nav_list']);
    $nav_lst = array();
    foreach ($nav_arr AS $val)
    {
        $arr              = explode('|', $val);
        $nav_lst[$arr[1]] = $arr[0];
    }

    /* 模板賦值 */
    $smarty->assign('lang',        $_LANG);
    $smarty->assign('ur_here',     $_LANG['modif_info']);
    $smarty->assign('action_link', array('text' => $_LANG['admin_list'], 'href'=>'privilege.php?act=list'));
    $smarty->assign('user',        $user_info);
    $smarty->assign('menus',       $modules);
    $smarty->assign('nav_arr',     $nav_lst);

    $smarty->assign('form_act',    'update_self');
    $smarty->assign('action',      'modif');

    /* 顯示頁面 */
    assign_query_info();
    $smarty->display('privilege_info.htm');
}

/*------------------------------------------------------ */
//-- 為管理員分配權限
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'allot')
{
    include_once(ROOT_PATH . 'languages/' .$_CFG['lang']. '/admin/priv_action.php');

    admin_priv('allot_priv');
    if ($_SESSION['admin_id'] == $_GET['id'])
    {
        admin_priv('all');
    }

    /* 獲得該管理員的權限 */
    $priv_str = $db->getOne("SELECT action_list FROM " .$chh->table('admin_user'). " WHERE id = '$_GET[id]'");

    /* 如果被編輯的管理員擁有了all這個權限，將不能編輯 */
    if ($priv_str == 'all')
    {
       $link[] = array('text' => $_LANG['back_admin_list'], 'href'=>'privilege.php?act=list');
       sys_msg($_LANG['edit_admininfo_cannot'], 0, $link);
    }

    /* 獲取權限的分組數據 */
    $sql_query = "SELECT action_id, parent_id, action_code FROM " .$chh->table('admin_action').
                 " WHERE parent_id = 0";
    $res = $db->query($sql_query);
    while ($rows = $db->FetchRow($res))
    {
        $priv_arr[$rows['action_id']] = $rows;
    }

    /* 按權限組查詢底級的權限名稱 */
    $sql = "SELECT action_id, parent_id, action_code FROM " .$chh->table('admin_action').
           " WHERE parent_id " .db_create_in(array_keys($priv_arr));
    $result = $db->query($sql);
    while ($priv = $db->FetchRow($result))
    {
        $priv_arr[$priv["parent_id"]]["priv"][$priv["action_code"]] = $priv;
    }

    // 將同一組的權限使用 "," 連接起來，供JS全選
    foreach ($priv_arr AS $action_id => $action_group)
    {
        $priv_arr[$action_id]['priv_list'] = join(',', @array_keys($action_group['priv']));

        foreach ($action_group['priv'] AS $key => $val)
        {
            $priv_arr[$action_id]['priv'][$key]['cando'] = (strpos($priv_str, $val['action_code']) !== false || $priv_str == 'all') ? 1 : 0;
        }
    }

    /* 賦值 */
    $smarty->assign('lang',        $_LANG);
    $smarty->assign('ur_here',     $_LANG['allot_priv'] . ' [ '. $_GET['user'] . ' ] ');
    $smarty->assign('action_link', array('href'=>'privilege.php?act=list', 'text' => $_LANG['admin_list']));
    $smarty->assign('priv_arr',    $priv_arr);
    $smarty->assign('form_act',    'update_allot');
    $smarty->assign('id',     $_GET['id']);

    /* 顯示頁面 */
    assign_query_info();
    $smarty->display('privilege_allot.htm');
}

/*------------------------------------------------------ */
//-- 更新管理員的權限
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'update_allot')
{
    admin_priv('admin_manage');

    /* 取得當前管理員用戶名 */
    $admin_name = $db->getOne("SELECT name FROM " .$chh->table('admin_user'). " WHERE id = '$_POST[id]'");

    /* 更新管理員的權限 */
    $act_list = @join(",", $_POST['action_code']);
    $sql = "UPDATE " .$chh->table('admin_user'). " SET action_list = '$act_list' ".
           "WHERE id = '$_POST[id]'";

    $db->query($sql);
    /* 動態更新管理員的SESSION */
    if ($_SESSION["admin_id"] == $_POST['id'])
    {
        $_SESSION["action_list"] = $act_list;
    }

    /* 記錄管理員操作 */
    admin_log(addslashes($admin_name), 'edit', 'privilege');

    /* 提示信息 */
    $link[] = array('text' => $_LANG['back_admin_list'], 'href'=>'privilege.php?act=list');
    sys_msg($_LANG['edit'] . "&nbsp;" . $admin_name . "&nbsp;" . $_LANG['action_succeed'], 0, $link);

}

/*------------------------------------------------------ */
//-- 刪除一個管理員
/*------------------------------------------------------ */
elseif ($_REQUEST['act'] == 'remove')
{
    check_authz_json('admin_drop');

    $id = intval($_GET['id']);

    /* 獲得管理員用戶名 */
    $admin_name = $db->getOne('SELECT name FROM '.$chh->table('admin_user')." WHERE id='$id'");

    /* demo這個管理員不允許刪除 */
    if ($admin_name == 'demo')
    {
        make_json_error($_LANG['edit_remove_cannot']);
    }

    /* ID為1的不允許刪除 */
    if ($id == 1)
    {
        make_json_error($_LANG['remove_cannot']);
    }

    /* 管理員不能刪除自己 */
    if ($id == $_SESSION['admin_id'])
    {
        make_json_error($_LANG['remove_self_cannot']);
    }

    if ($exc->drop($id))
    {
        $sess->delete_spec_admin_session($id); // 刪除session中該管理員的記錄

        admin_log(addslashes($admin_name), 'remove', 'privilege');
        clear_cache_files();
    }

    $url = 'privilege.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);

    chh_header("Location: $url\n");
    exit;
}

/* 獲取管理員列表 */
function get_admin_userlist()
{
    $list = array();
    $sql  = 'SELECT id, name, email, add_time, last_login '.
            'FROM ' .$GLOBALS['chh']->table('admin_user').' ORDER BY id DESC';
    $list = $GLOBALS['db']->getAll($sql);

    foreach ($list AS $key=>$val)
    {
        $list[$key]['add_time']     = local_date($GLOBALS['_CFG']['time_format'], $val['add_time']);
        $list[$key]['last_login']   = local_date($GLOBALS['_CFG']['time_format'], $val['last_login']);
    }

    return $list;
}

/* 清除購物車中過期的數據 */
function clear_cart()
{
    /* 取得有效的session */
    $sql = "SELECT DISTINCT session_id " .
            "FROM " . $GLOBALS['chh']->table('cart') . " AS c, " .
                $GLOBALS['chh']->table('sessions') . " AS s " .
            "WHERE c.session_id = s.sesskey ";
    $valid_sess = $GLOBALS['db']->getCol($sql);

    // 刪除cart中無效的數據
    $sql = "DELETE FROM " . $GLOBALS['chh']->table('cart') .
            " WHERE session_id NOT " . db_create_in($valid_sess);
    $GLOBALS['db']->query($sql);
}

?>
