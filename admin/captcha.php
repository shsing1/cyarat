<?php

/**
 * CHH 生成驗證碼
 * ============================================================================
 *
 *
 * ============================================================================
 * Author: shsing1
 * Id: captcha.php 2009-11-04 21:00:00
*/
define('IN_CHH', true);
define('INIT_NO_SMARTY', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/cls_captcha.php');

$img = new captcha(ROOT_PATH . 'data/captcha/', 145, 20);
@ob_end_clean(); //清除之前出現的多餘輸入
if (isset($_REQUEST['is_login']))
{
    $img->session_word = 'captcha_login';
}
$img->generate_image();
?>