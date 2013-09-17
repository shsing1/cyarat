<?php
/**
 * CHH 前台公用文件
 * ============================================================================
 *
 * ============================================================================
 * Author: shsing1
 * Id: init.php 2009-12-17 16:00:00
*/
if (!defined('IN_CHH'))
{
    die('Hacking attempt');
}


if (__FILE__ == '')
{
    die('Fatal error code: 1');
}

/* 取得當前ecshop所在的根目錄 */
define('ROOT_PATH', str_replace('includes/init.php', '', str_replace('\\', '/', __FILE__)));

/* 初始化設置 */
@ini_set('memory_limit',          '64M');
@ini_set('session.cache_expire',  180);
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies',   1);
@ini_set('session.auto_start',    0);
@ini_set('display_errors',        0);

if (DIRECTORY_SEPARATOR == '\\')
{
    @ini_set('include_path', '.;' . ROOT_PATH);
}
else
{
    @ini_set('include_path', '.:' . ROOT_PATH);
}

// 是否開啟firephp
require_once(ROOT_PATH . 'includes/FirePHPCore/FirePHP.class.php');
$firephp = FirePHP::getInstance(true);
if (file_exists(ROOT_PATH . 'includes/formal.php')) {
    error_reporting(0);
    require_once(ROOT_PATH . 'includes/config.php');
    $firephp->setEnabled(false);
} else {
    error_reporting(E_ALL);
    require_once(ROOT_PATH . 'includes/config_dev.php');
}


if (defined('DEBUG_MODE') == false)
{
    define('DEBUG_MODE', 0);
}

if (PHP_VERSION >= '5.1' && !empty($timezone))
{
    date_default_timezone_set($timezone);
}

$php_self = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
if ('/' == substr($php_self, -1))
{
    $php_self .= 'index.php';
}
define('PHP_SELF', $php_self);

//require(ROOT_PATH . 'includes/inc_constant.php');
require(ROOT_PATH . 'includes/cls_chh.php');
require(ROOT_PATH . 'includes/cls_error.php');
require(ROOT_PATH . 'includes/lib_time.php');
require(ROOT_PATH . 'includes/lib_base.php');
require(ROOT_PATH . 'includes/lib_common.php');
require(ROOT_PATH . 'includes/lib_main.php');
//require(ROOT_PATH . 'includes/lib_insert.php');
//require(ROOT_PATH . 'includes/lib_goods.php');
//require(ROOT_PATH . 'includes/lib_article.php');


/* 將加密的參數進行解密 */
if(!empty($_GET['p'])){
	$p = authcode($_GET['p']);
	parse_str($p , $_GET);
	$_REQUEST = array_merge($_REQUEST, $_GET);
}else{
	$_GET = array();
}

/* 對用戶傳入的變量進行轉義操作。*/
if (!get_magic_quotes_gpc())
{
    if (!empty($_GET))
    {
        $_GET  = addslashes_deep($_GET);
    }
    if (!empty($_POST))
    {
        $_POST = addslashes_deep($_POST);
    }

    $_COOKIE   = addslashes_deep($_COOKIE);
    $_REQUEST  = addslashes_deep($_REQUEST);
}

/* 創建 chh 對像 */
$chh = new CHH($db_name, $prefix);
define('DATA_DIR', $chh->data_dir());
define('IMAGE_DIR', $chh->image_dir());

/* 初始化數據庫類 */
require(ROOT_PATH . 'includes/cls_mysql.php');
$db = new cls_mysql($db_host, $db_user, $db_pass, $db_name);
$db->set_disable_cache_tables(array($chh->table('sessions'), $chh->table('sessions_data'), $chh->table('cart')));
$db_host = $db_user = $db_pass = $db_name = NULL;

/* 創建錯誤處理對像 */
$err = new chh_error('message.dwt');

/* 載入系統參數 */
$_CFG = load_config();

/* 載入語言文件 */
require(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/common.php');
if (file_exists(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/' . basename(PHP_SELF)))
{
    include_once(ROOT_PATH . 'languages/' . $_CFG['lang'] . '/' . basename(PHP_SELF));
}

/* 是否有購物車功能 */
define('HAS_CART', file_exists(ROOT_PATH . 'includes/cls_cart.php') );

/* 此網站沒有會員功能 */
define('HAS_USERS',  file_exists(ROOT_PATH . 'includes/cls_user.php'));

if ($_CFG['site_closed'] == 1)
{
    /* 商店關閉了，輸出關閉的消息 */
    header('Content-type: text/html; charset='.CHH_CHARSET);

    die('<div style="margin: 150px; text-align: center; font-size: 14px"><p>' . $_LANG['site_closed'] . '</p><p>' . $_CFG['close_comment'] . '</p></div>');
}

//if (is_spider())
//{
//    /* 如果是蜘蛛的訪問，那麼默認為訪客方式，並且不記錄到日誌中 */
//    if (!defined('INIT_NO_USERS'))
//    {
//        define('INIT_NO_USERS', true);
//        /* 整合UC後，如果是蜘蛛訪問，初始化UC需要的常量 */
//        if($_CFG['integrate_code'] == 'ucenter')
//        {
//             $user = & init_users();
//        }
//    }
//    $_SESSION = array();
//    $_SESSION['user_id']     = 0;
//    $_SESSION['user_name']   = '';
//    $_SESSION['email']       = '';
//    $_SESSION['user_rank']   = 0;
//    $_SESSION['discount']    = 1.00;
//}

if (!defined('INIT_NO_USERS') && HAS_USERS)
{
    /* 初始化session */
    include(ROOT_PATH . 'includes/cls_session.php');

    $sess = new cls_session($db, $chh->table('sessions'), 'CHH_ID');

    define('SESS_ID', $sess->get_session_id());
}

if (!defined('INIT_NO_SMARTY'))
{
    header('Cache-control: private');
    header('Content-type: text/html; charset='.CHH_CHARSET);

    /* 創建 Smarty 對象。*/
    require(ROOT_PATH . 'includes/cls_template.php');
    $smarty = new cls_template;

    $smarty->cache_lifetime = $_CFG['cache_time'];
    $smarty->template_dir   = ROOT_PATH . 'themes/' . $_CFG['template'];
    $smarty->cache_dir      = ROOT_PATH . 'temp/caches';
    $smarty->compile_dir    = ROOT_PATH . 'temp/compiled';
	define('TMP_DIR', 'themes/' . $_CFG['template'] . '/' );
    if ((DEBUG_MODE & 2) == 2)
    {
        $smarty->direct_output = true;
        $smarty->force_compile = true;
    }
    else
    {
        $smarty->direct_output = false;
        $smarty->force_compile = false;
    }

    $smarty->assign('lang', $_LANG);
    $smarty->assign('chh_charset', CHH_CHARSET);
    if (!empty($_CFG['stylename']))
    {
        $smarty->assign('chh_css_path', 'themes/' . $_CFG['template'] . '/style_' . $_CFG['stylename'] . '.css');
    }
    else
    {
        $smarty->assign('chh_css_path', 'themes/' . $_CFG['template'] . '/style.css');
    }

}

if (!defined('INIT_NO_USERS'))
{
	if (file_exists(ROOT_PATH . 'includes/cls_user.php'))
	{
		require_once(ROOT_PATH . 'includes/cls_user_cat.php');
		$cat = new cls_user_cat($db, $chh->table("user_cat") );

		require_once(ROOT_PATH . 'includes/cls_user.php');
		$user = new cls_user($db, $chh->table("user"), $cat);

		if (empty($_SESSION['user_id']))
		{

			if(!$user->get_cookie()){
				$_SESSION['user_id']     = 0;
				$_SESSION['user_name']   = '';
				$_SESSION['email']       = '';
				$_SESSION['user_rank']   = 0;
				$_SESSION['discount']    = 1.00;
				if (!isset($_SESSION['login_fail']))
				{
					$_SESSION['login_fail'] = 0;
				}
			}
		}else{
			$user->set_session($_SESSION['user_id']);
		}
	}else{
		session_start();
		$_SESSION['user_id']     = 0;
		$_SESSION['user_name']   = '';
		$_SESSION['email']       = '';
		$_SESSION['user_rank']   = 0;
		$_SESSION['discount']    = 1.00;
		if (!isset($_SESSION['login_fail']))
		{
			$_SESSION['login_fail'] = 0;
		}
	}

    if (isset($smarty))
    {
        $smarty->assign('chh_session', $_SESSION);
    }
}

// if ((DEBUG_MODE & 1) == 1)
// {
//     error_reporting(E_ALL);
// }
// else
// {
//     error_reporting(E_ALL ^ E_NOTICE);
// }
if ((DEBUG_MODE & 4) == 4)
{
    include(ROOT_PATH . 'includes/lib.debug.php');
}

/* 判斷是否支持 Gzip 模式 */
if (!defined('INIT_NO_SMARTY') && gzip_enabled())
{
    ob_start('ob_gzhandler');
}
else
{
    ob_start();
}

$page_title = $GLOBALS['_CFG']['site_title'];
$keywords = htmlspecialchars($GLOBALS['_CFG']['site_keywords']);
$description = htmlspecialchars($GLOBALS['_CFG']['site_desc']);

// 左邊選單
$menu = array();

// 上方選單
$main_nav = array(
    array('name' => '關於藝動節', 'url' => 'about.php', 'current' => false),
    array('name' => '城市藝境', 'url' => 'index.php', 'current' => false),
    array('name' => '1010國慶超人路跑', 'url' => 'index.php', 'current' => false),
    array('name' => '最新動態', 'url' => 'news.php', 'current' => false),
    array('name' => '聯絡我們', 'url' => 'index.php', 'current' => false),
    array('name' => '回首頁', 'url' => 'index.php', 'current' => false)
);

$css_ext = array('css/style.css');

$js_ext = array();
?>