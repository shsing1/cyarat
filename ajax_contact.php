<?php
/**
 * CHH 聯絡我們文件
 * ============================================================================
 *
 * ============================================================================
 * Author: shsing1
 * Id: contact.php 2009-12-17 19:00:00
*/
define('IN_CHH', true);

require_once(dirname(__FILE__) . '/includes/init.php');
require_once(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/contact.php');

header('Content-type: application/json; charset='.CHH_CHARSET);

require_once(ROOT_PATH . '/includes/cls_contact_cat.php');
$cat = new cls_contact_cat($db, $chh->table("contact_cat") );

require_once(ROOT_PATH . '/includes/cls_contact.php');
$data = new cls_contact($db, $chh->table("contact"), $cat);

/* 初始化變量 */
$field['name']              = !isset($_POST['name'])            ?   ''  : trim($_POST['name']);
$field['id_number']         = !isset($_POST['id_number'])       ?   ''  : trim($_POST['id_number']);
$field['sex']               = !isset($_POST['sex'])             ?   ''  : trim($_POST['sex']);
$field['address']           = !isset($_POST['address'])         ?   ''  : trim($_POST['address']);
$field['phone']             = !isset($_POST['phone'])           ?   ''  : trim($_POST['phone']);
$field['phone2']            = !isset($_POST['phone2'])          ?   ''  : trim($_POST['phone2']);
$field['mobile']            = !isset($_POST['mobile'])          ?   ''  : trim($_POST['mobile']);
$field['cat_id']            = !isset($_POST['cat_id'])          ?   1   : intval($_POST['cat_id']);
$field['email']             = !isset($_POST['email'])           ?   ''  : trim($_POST['email']);
$field['sort']              = !isset($_POST['sort'])            ?   0   : intval($_POST['sort']);
$field['content']           = !isset($_POST['content'])         ?   ''  : trim($_POST['content']);
$field['add_time']          = gmtime();

$rs = new stdClass;
$rs->error = false;

/* 參數檢查 */
if($field['name'] == ''){
    $rs->error = true;
    $rs->msg = $_LANG['name_empty'];
    die(json_encode($rs));
}

/* email檢查 */
if(!is_email($field['email'])){
    $rs->error = true;
    $rs->msg = $_LANG['email_invalid'];
    die(json_encode($rs));
}

/* 參數檢查 */
if($field['content'] == ''){
    $rs->error = true;
    $rs->msg = $_LANG['content_empty'];
    die(json_encode($rs));
}

/* 驗證碼檢查 */
$_POST['captcha'] = trim($_POST['captcha']);
if (isset($_POST['captcha']) )
{
    include_once(ROOT_PATH . 'includes/cls_captcha.php');

    /* 檢查驗證碼是否正確 */
    $validator = new captcha();

    if(empty($_POST['captcha'])){
        $rs->error = true;
        $rs->msg = $_LANG['captcha_empty'];
        die(json_encode($rs));
    }else{
        if (isset($_POST['captcha']) && !$validator->check_word($_POST['captcha']))
        {
            $rs->error = true;
            $rs->msg = $_LANG['captcha_error'];
            die(json_encode($rs));
        }
    }
}


/* 資料入庫 */
if(!$data->add($field)){
    $rs->error = true;
    $rs->msg = $_LANG['data_add_failed'];
    die(json_encode($rs));
} else {

    $field['sex_name'] = $field['sex'] == '1' ? '男' : '女';

    /* 發送新增email */
    $field['add_time'] = local_date($_CFG['time_format'], $field['add_time']);

    ob_start();
    include_once('contact_mail.php');
    $content = ob_get_contents();
    ob_end_clean();
// $firephp->info($_CFG['service_email']);
    send_mail($_CFG['site_name'], $_CFG['service_email'], sprintf($_LANG['add_mail_title'], $field['name'], $field['add_time']), $content, 1, false, $field['name'], $field['email']);
    send_mail($field['name'], $field['email'], sprintf($_LANG['add_mail_title2'], $_CFG['site_name'], $field['add_time']), $content, 1, false, $_CFG['site_name'], $_CFG['service_email']);

    // if (!send_mail($_CFG['site_name'], $_CFG['service_email'], sprintf($_LANG['add_mail_title'], $field['name'], $field['add_time']), $content, 1, false, $field['name'], $field['email']))
    // {
    //     make_json_error( $_LANG['send_to_system_failed'] );
    // }

    // if (!send_mail($field['name'], $field['email'], sprintf($_LANG['add_mail_title2'], $_CFG['site_name'], $field['add_time']), $content, 1, false, $_CFG['site_name'], $_CFG['service_email']))
    // {
    //     make_json_error( $_LANG['send_to_insert_failed'] );
    // }

    $rs->msg = $_LANG['info_add_succed'];
    die(json_encode($rs));
}
?>