<?php

/**
 * CHH 權限管理資料管理
 * ============================================================================
 *
 *
 * ============================================================================
 * Author: shsing1
 * Id: admin.php 2009-11-27 12:00:00
*/

define('IN_CHH', true);

require_once(dirname(__FILE__) . '/includes/init.php');

require_once(ROOT_PATH . '/includes/cls_admin_cat.php');
$cat = new cls_admin_cat($db, $chh->table("admin_cat") );

require_once(ROOT_PATH . '/includes/cls_admin.php');
$data = new cls_admin($db, $chh->table("admin_user"), $cat);

require_once(ROOT_PATH . '/includes/cls_admin_priv.php');
$priv = new cls_admin_priv($db, $chh->table("admin_priv") );

require_once(ROOT_PATH . '/includes/cls_sys_menu.php');
$sys_menu = new cls_sys_menu($db, $chh->table("sys_menu") );


/* act操作項的初始化 */
if (empty($_REQUEST['act']))
{
    $_REQUEST['act'] = 'list';
}
else
{
    $_REQUEST['act'] = trim($_REQUEST['act']);
}
/* 設定功能路徑 */
require_once(ROOT_PATH . '/includes/cls_sys_menu.php');
$sys_menu = new cls_sys_menu($db, $chh->table("sys_menu") );
$ur_here = $sys_menu->get_ur_here(15);
$smarty->assign('ur_here'		, $ur_here);
$smarty->assign('admin_cat_id'	, $_SESSION['admin_cat_id']);

/*------------------------------------------------------ */
//-- 依act進行應對動作
/*------------------------------------------------------ */
switch($_REQUEST['act'] ){
/*------------------------------------------------------ */
//-- 資料列表
/*------------------------------------------------------ */
	case 'list':
		/* 獲取資料列表 */
		$data_list = $data->get_list();

		/* 設定分類預設值 */
		$cat_id	=	!isset($_REQUEST['cat_id'])	?	0	:	intval($_REQUEST['cat_id']);

		/* 取得分類選項 */
		$cat_select = $cat->get_list_option(1, $cat_id, 1);
		$smarty->assign('cat_list',  $cat_select);

		/* 設定搜尋關鍵字預設值 */
		$serach_keyword	=	!isset($_REQUEST['keyword'])	?	''	:	trim($_REQUEST['keyword']);
		$smarty->assign('serach_keyword',  $serach_keyword);

		/* 取得分類選項for轉移分類用 */
		$cat_select = $cat->get_list_option();
		$smarty->assign('cat_list_all',  $cat_select);

		/* 模板賦值 */
		$smarty->assign('action_link',  array('href' => 'admin.php?act=add', 'text' => $_LANG['data_add']));
		$smarty->assign('full_page',    1);

		$smarty->assign('data_list',	$data_list['list']);
		$smarty->assign('filter',		$data_list['filter']);

		/* 排序標記 */
		$sort_flag  = sort_flag($data_list['filter']);
		$smarty->assign($sort_flag['tag'], $sort_flag['img']);

		/* 列表頁面 */
		assign_query_info();
		$smarty->display('admin_list.htm');

		break;
/*------------------------------------------------------ */
//-- 排序、分頁、查詢
/*------------------------------------------------------ */
	case 'query':
		/* 獲取資料列表 */
		$data_list = $data->get_list();

		/* 取得分類選項 */
		$cat_select = $cat->get_list_option(1, 0, 1);
		$smarty->assign('cat_list',  $cat_select);

		/* 模板賦值 */
		$smarty->assign('action_link',  array('href' => 'admin.php?act=add', 'text' => $_LANG['data_add']));

		$smarty->assign('data_list',	$data_list['list']);
		$smarty->assign('filter',		$data_list['filter']);

		/* 排序標記 */
		$sort_flag  = sort_flag($data_list['filter']);
		$smarty->assign($sort_flag['tag'], $sort_flag['img']);

		/* 列表頁面 */
		assign_query_info();

		make_json_result(	$smarty->fetch('admin_list.htm'),
							'',
							array('filter' => $data_list['filter'], 'page_count' => $data_list['page_count'])
						);

		break;
/*------------------------------------------------------ */
//-- 添加資料
/*------------------------------------------------------ */
	case 'add':
		/* 模板賦值 */
		$smarty->assign('action_link',  array('href' => 'admin.php?act=list', 'text' => $_LANG['data_list']));

		/* 創建 html editor */
		create_html_editor('desc');

		$cat_select = $cat->get_list_option(1, 3);
		$smarty->assign('cat_select',   $cat_select);

		$smarty->assign('form_act',     'insert');
		$smarty->assign('data_info',     array('is_show' => 1));

		/* 權限設定 */
		$priv_arr = $sys_menu->get_list_arr();
		$smarty->assign('priv_arr',     $priv_arr);

		/* 顯示頁面 */
		assign_query_info();
		$smarty->display('admin_info.htm');

		break;
/*------------------------------------------------------ */
//-- 資料添加時的處理
/*------------------------------------------------------ */
	case 'insert':
		/* 初始化變量 */
		$field['name']     			= !isset($_POST['name'])     	?	''		:	trim($_POST['name']);
		$field['cat_id']   			= !isset($_POST['cat_id'])     	?	1		:	intval($_POST['cat_id']);
		$field['email']				= !isset($_POST['email'])     	?	''		:	trim($_POST['email']);
		$field['password']			= !isset($_POST['password'])    ?	''		:	trim($_POST['password']);
		$field['pwd_confirm']		= !isset($_POST['pwd_confirm'])	?	''		:	trim($_POST['pwd_confirm']);
		$field['sort']   			= !isset($_POST['sort'])     	?	0		:	intval($_POST['sort']);
		$field['is_show']     		= !isset($_POST['is_show'])     ?	1		:	intval($_POST['is_show']);
		$field['add_time'] 			= gmtime();
		$priv_arr					= !isset($_POST['priv'])		?	array()	:	$_POST['priv'];

		/* 參數檢查 */
		if($field['name'] == ''){
			make_json_error($_LANG['name_empty']);
		}

		/* email檢查 */
		if(!is_email($field['email'])){
			make_json_error($_LANG['email_invalid']);
		}

		/* 密碼不可為空 */
		if(!check_password($field['password']) || !check_password($field['pwd_confirm'])){
			make_json_error($_LANG['password_invaild']);
		}

		/* 比較新密碼和確認密碼是否相同 */
		if ($field['password'] <> $field['pwd_confirm'])
		{
			make_json_error($_LANG['password_error']);
		}
		else
		{
			$field['password'] = md5($field['password']);
		}

		unset($field['old_password']);
		unset($field['new_password']);
		unset($field['pwd_confirm']);

		/* 資料入庫 */
		if(!$data->add($field)){
			make_json_error($_LANG['data_add_failed']);
		}

		$field['id'] = $data->get_insert_id();
		/* 更新管理者權限 */
		foreach($priv_arr as $v){
			$exist = $priv->is_exist($field['id'], $v);
			if(!$exist){
				$field2['admin_id'] = $field['id'];
				$field2['priv_id'] 	= $v;
				if(!$priv->add($field2)){
					make_json_error($_LANG['priv_add_failed']);
				}
			}
		}
		/* 找出未勾選的資料 */
		$exist_arr = $priv->get_priv_list($field['id']);
		$diff_arr = array_diff($exist_arr, $priv_arr);
		/* 刪除未勾選的資料*/
		foreach($diff_arr as $v){
			if(!$priv->del($field['id'], $v)){
				make_json_error($_LANG['priv_del_failed']);
			}
		}

		make_json_result('', $_LANG['data_add_succed'], array('url'=>'admin.php?'.get_last_filter_url() ) );

		break;
/*------------------------------------------------------ */
//-- 編輯資料
/*------------------------------------------------------ */
	case 'edit':
		$id	=	!isset($_REQUEST['id'])	?	0	:	intval($_REQUEST['id']);

		$data_info = $data->get_info($id);

		$smarty->assign('action_link', array('text' => $_LANG['data_list'], 'href' => 'admin.php?act=list'));

		/* 創建 html editor */
		create_html_editor('desc', $data_info['desc']);

		$cat_select = $cat->get_list_option(1, $data_info['cat_id']);
		$smarty->assign('cat_select',   $cat_select);

		$smarty->assign('data_info',    $data_info);
		$smarty->assign('form_act',    'update');
		$smarty->assign('data_select',  $data_select);

		/* 選得管理者權限 */
		$exist_arr = $priv->get_priv_list($id);

		/* 權限設定 */
		$priv_arr = $sys_menu->get_list_arr();

		$priv_arr = $priv->set_checked($priv_arr, $exist_arr);

		$smarty->assign('priv_arr',     $priv_arr);

		/* 顯示頁面 */
		assign_query_info();
		$smarty->assign('ur_here',     $ur_here . ' - '.$data_info['name'] );
		$smarty->display('admin_info.htm');

		break;
/*------------------------------------------------------ */
//-- 編輯資料後的處理
/*------------------------------------------------------ */
	case 'update':
		/* 初始化變量 */
		$field['id']				= !isset($_POST['id'])     		?	0		:	intval($_POST['id']);
		$field['name']     			= !isset($_POST['name'])     	?	''		:	trim($_POST['name']);
		$field['cat_id']   			= !isset($_POST['cat_id'])     	?	1		:	intval($_POST['cat_id']);
		$field['email']				= !isset($_POST['email'])     	?	''		:	trim($_POST['email']);
		$field['old_password']		= !isset($_POST['old_password'])?	''		:	trim($_POST['old_password']);
		$field['new_password']		= !isset($_POST['new_password'])?	''		:	trim($_POST['new_password']);
		$field['pwd_confirm']		= !isset($_POST['pwd_confirm']) ?	''		:	trim($_POST['pwd_confirm']);
		$field['sort']   			= !isset($_POST['sort'])     	?	0		:	intval($_POST['sort']);
		$field['is_show']     		= !isset($_POST['is_show'])     ?	1		:	intval($_POST['is_show']);
		$priv_arr					= !isset($_POST['priv'])		?	array()	:	$_POST['priv'];

		if(empty($field['id'])){
			make_json_error($_LANG['id_empty']);
		}

		if($field['name'] == ''){
			make_json_error($_LANG['name_empty']);
		}

		if(!is_email($field['email'])){
			make_json_error($_LANG['email_invalid']);
		}

		//如果要修改密碼
		$pwd_modified = false;
		if (!empty($field['new_password']))
		{
			/* 查詢舊密碼並與輸入的舊密碼比較是否相同 */
			$info = $data->get_info($field['id']);
			if ($info['password'] <> (md5($field['old_password'])))
			{
				make_json_error($_LANG['pwd_error']);
			}

			/* 密碼不可為空 */
			if(!check_password($field['new_password']) || !check_password($field['pwd_confirm'])){
				make_json_error($_LANG['password_invaild']);
			}


			/* 比較新密碼和確認密碼是否相同 */
			if (empty($field['new_password']) || empty($field['pwd_confirm']) || $field['new_password'] <> $field['pwd_confirm'])
			{
				make_json_error($_LANG['password_error']);
			}
			else
			{
				$pwd_modified = true;
			}
		}

		/* 更新管理者權限 */
		foreach($priv_arr as $v){
			$exist = $priv->is_exist($field['id'], $v);
			if(!$exist){
				$field2['admin_id'] = $field['id'];
				$field2['priv_id'] 	= $v;
				if(!$priv->add($field2)){
					make_json_error($_LANG['priv_add_failed']);
				}
			}
		}
		/* 找出未勾選的資料 */
		$exist_arr = $priv->get_priv_list($field['id']);
		$diff_arr = array_diff($exist_arr, $priv_arr);
		/* 刪除未勾選的資料*/
		foreach($diff_arr as $v){
			if(!$priv->del($field['id'], $v)){
				make_json_error($_LANG['priv_del_failed']);
			}
		}

		/* 是否要修改密碼 */
		if($pwd_modified){
			$field['password'] = md5($field['new_password']);
		}
		unset($field['old_password']);
		unset($field['new_password']);
		unset($field['pwd_confirm']);

		if(!$data->upd($field)){
			make_json_error($_LANG['data_upd_failed']);
		}

		if($pwd_modified && $field['id'] == $_SESSION['admin_id'] ){
			 /* 清除cookie */
			setcookie('CHH[admin_id]',   '', 1);
			setcookie('CHH[admin_pass]', '', 1);
			$sess->destroy_session();

			make_json_result('', $_LANG['edit_password_succeed'], array('reload_all'=>1));
		}else{

			make_json_result('', $_LANG['data_upd_succed'], array('url'=>'admin.php?'.get_last_filter_url() ) );

		}

		break;
/*------------------------------------------------------ */
//-- 複製資料
/*------------------------------------------------------ */
	case 'copy':
		$id	=	!isset($_REQUEST['id'])	?	0	:	intval($_REQUEST['id']);

		$data_info = $data->get_info($id);
		$data_info['sort'] = 0;

		$smarty->assign('action_link', array('text' => $_LANG['data_list'], 'href' => 'admin.php?act=list'));

		/* 創建 html editor */
		create_html_editor('desc', $data_info['desc']);

		$cat_select = $cat->get_list_option(1, $data_info['cat_id']);
		$smarty->assign('cat_select',   $cat_select);

		$smarty->assign('data_info',    $data_info);
		$smarty->assign('form_act',    'insert');
		$smarty->assign('data_select',  $data_select);

		/* 選得管理者權限 */
		$exist_arr = $priv->get_priv_list($id);

		/* 權限設定 */
		$priv_arr = $sys_menu->get_list_arr();

		$priv_arr = $priv->set_checked($priv_arr, $exist_arr);

		$smarty->assign('priv_arr',     $priv_arr);

		/* 顯示頁面 */
		assign_query_info();
		$smarty->display('admin_info.htm');

		break;
/*------------------------------------------------------ */
//-- 刪除資料
/*------------------------------------------------------ */
	case 'remove':
		/* 初始化資料ID */
		$id	=	!isset($_REQUEST['id'])	?	0	:	intval($_REQUEST['id']);

		/* 刪除權限資料 */
		$priv_arr = $priv->get_priv_list($id);
		foreach($priv_arr as $v){
			if(!$priv->del($id, $v)){
				make_json_error($_LANG['priv_del_failed']);
			}
		}

		/* 執行刪除動作 */
		if(!$data->del($id)){
			make_json_error($_LANG['data_del_failed']);
		}

		make_json_result('', $_LANG['data_del_succed'], array('url'=>'admin.php?'.get_last_filter_url() ) );

		break;
/*------------------------------------------------------ */
//-- 批量操作
/*------------------------------------------------------ */
	case 'batch':
		/* 取得要操作的商品編號 */
		$arr		=	!isset($_POST['checkboxes'])	?	array()	:	$_POST['checkboxes'];
		$type		=	!isset($_POST['type'])			?	''		:	$_POST['type'];
		$target_cat	=	!isset($_POST['target_cat'])	?	1		:	intval($_POST['target_cat']);

		/* 動作處理 */
		switch($type){
			case 'drop':
				foreach($arr as $id){
					/* 執行刪除動作 */
					if(!$data->del($id)){
						make_json_error($_LANG['data_del_failed']);
					}
				}
				break;
			case 'enabled':
				foreach($arr as $id){
					/* 執行啟用動作 */
					$field['id']		= $id;
					$field['is_show']	= 1;
					if(!$data->upd($field)){
						make_json_error($_LANG['data_enabled_failed']);
					}
				}
				break;
			case 'disabled':
				foreach($arr as $id){
					/* 執行禁用動作 */
					$field['id']		= $id;
					$field['is_show']  	= 0;
					if(!$data->upd($field)){
						make_json_error($_LANG['data_disabled_failed']);
					}
				}
				break;
			case 'move_to':
				foreach($arr as $id){
					/* 執行轉移動作 */
					$field['id']		= $id;
					$field['cat_id']  	= $target_cat;
					if(!$data->upd($field)){
						make_json_error($_LANG['data_move_to_failed']);
					}
				}
				break;
			default:
				break;
		}

		make_json_result('', $_LANG['data_batch_succed'], array('url'=>'admin.php?'.get_last_filter_url() ) );

		break;
/*------------------------------------------------------ */
//-- 忘記密碼
/*------------------------------------------------------ */
	case 'forget_pwd':
		$smarty->assign('form_act', 'forget_pwd');
		$smarty->assign('ur_here', $_LANG['get_newpassword']);

	    assign_query_info();
    	$smarty->display('get_pwd.htm');

		break;
/*------------------------------------------------------ */
//-- 取回密碼
/*------------------------------------------------------ */
	case 'get_pwd':
        $admin_username = !empty($_POST['user_name']) ? trim($_POST['user_name']) : '';
        $admin_email    = !empty($_POST['email'])     ? trim($_POST['email'])     : '';

		/* 名稱檢查 */
		if($admin_username == ''){
			make_json_error($_LANG['name_empty']);
		}

		/* email檢查 */
		if(!is_email($admin_email)){
			make_json_error($_LANG['email_invalid']);
		}

		/* 管理員用戶名和郵件地址是否匹配，並取得原密碼 */
        $sql = 'SELECT id, password FROM ' .$chh->table('admin_user').
               " WHERE name = '$admin_username' AND email = '$admin_email'";
        $admin_info = $db->getRow($sql);

        if (!empty($admin_info))
        {
            /* 生成驗證的code */
            $admin_id = $admin_info['id'];
            $code     = md5($admin_id . $admin_info['password']);

            /* 設置重置郵件模板所需要的內容信息 */

            $reset_email = $chh->url() . 'admin/admin.php?act=reset_pwd&uid='.$admin_id.'&code='.$code;

            $smarty->assign('user_name',   $admin_username);
            $smarty->assign('reset_email', $reset_email);
            $smarty->assign('shop_name',   $_CFG['shop_name']);
            $smarty->assign('send_date',   local_date($_CFG['date_format']));
            $smarty->assign('sent_date',   local_date($_CFG['date_format']));

            $content = $smarty->fetch('get_password_mail_tpl.htm');

            /* 發送確認重置密碼的確認郵件 */
            if (send_mail($admin_username, $admin_email, $_LANG['get_newpassword'], $content, 1))
            {
                make_json_result('', $_LANG['send_success'].$admin_email);
            }
            else
            {
                make_json_error($_LANG['send_mail_error']);
            }
        }
        else
        {
            /* 提示信息 */
            make_json_error($_LANG['email_username_error']);
        }

		break;
/*------------------------------------------------------ */
//-- 重設密碼
/*------------------------------------------------------ */
	case 'reset_pwd':
		$code    = !empty($_REQUEST['code']) ? trim($_REQUEST['code'])  : '';
        $adminid = !empty($_REQUEST['uid'])  ? intval($_REQUEST['uid']) : 0;

        if ($adminid == 0 || empty($code))
        {
            chh_header("Location: privilege.php?act=login\n");
            exit;
        }

        /* 以用戶的原密碼，與code的值匹配 */
        $sql = 'SELECT password FROM ' .$chh->table('admin_user'). " WHERE id = '$adminid'";
        $password = $db->getOne($sql);

        if (md5($adminid . $password) <> $code)
        {
            //此鏈接不合法
            $link[0]['text'] = $_LANG['back'];
            $link[0]['href'] = 'privilege.php?act=login';

            sys_msg($_LANG['code_param_error'], 0, $link);
        }
        else
        {
            $smarty->assign('adminid',  $adminid);
            $smarty->assign('code',     $code);
            $smarty->assign('form_act', 'reset_pwd_act');
        }

		$smarty->assign('ur_here', $_LANG['get_newpassword']);

	    assign_query_info();
    	$smarty->display('get_pwd.htm');

		break;
/*------------------------------------------------------ */
//-- 重設密碼 後續動作
/*------------------------------------------------------ */
	case 'reset_pwd_act':
		$new_password = isset($_POST['password']) ? trim($_POST['password'])  : '';
		$confirm_pwd = isset($_POST['confirm_pwd']) ? trim($_POST['confirm_pwd'])  : '';
        $adminid      = isset($_POST['adminid'])  ? intval($_POST['adminid']) : 0;
        $code         = isset($_POST['code'])     ? trim($_POST['code'])      : '';

		/* 密碼不可為空 */
		if(!check_password($new_password) || !check_password($confirm_pwd)){
			make_json_error($_LANG['password_invaild']);
		}

		/* 比較新密碼和確認密碼是否相同 */
		if (empty($new_password) || empty($confirm_pwd) || $new_password <> $confirm_pwd)
		{
			make_json_error($_LANG['password_error']);
		}

		/* 此鏈接不合法 */
        if (empty($code) || $adminid == 0)
        {
             make_json_error($_LANG['code_param_error']);
        }

        /* 以用戶的原密碼，與code的值匹配 */
        $sql = 'SELECT password FROM ' .$chh->table('admin_user'). " WHERE id = '$adminid'";
        $password = $db->getOne($sql);

        if (md5($adminid . $password) <> $code)
        {
            //此鏈接不合法
            make_json_error($_LANG['code_param_error']);
        }

        //更新管理員的密碼
        $sql = "UPDATE " .$chh->table('admin_user'). "SET password = '".md5($new_password)."' ".
               "WHERE id = '$adminid'";
        $result = $db->query($sql);
        if ($result)
        {
			make_json_result('', $_LANG['update_pwd_success'], array('url'=>'privilege.php?act=login' ) );
        }
        else
        {
            make_json_error($_LANG['update_pwd_failed']);
		}

		break;
	default:
		break;
}
?>