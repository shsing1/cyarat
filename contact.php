<?php
define('IN_CHH', true);

$id = isset($_GET['id']) ? $_GET['id'] : null;

require_once(dirname(__FILE__) . '/includes/init.php');

$main_nav[4]['current'] = true;

require_once(ROOT_PATH . '/includes/cls_contact_cat.php');
$cat = new cls_contact_cat($db, $chh->table("contact_cat") );

require_once(ROOT_PATH . '/includes/cls_contact.php');
$data = new cls_contact($db, $chh->table("contact"), $cat);

$cat_list = array();
$data_list = array();
$cat_id = null;

// 沒有id
if ($id === null) {
    $cat_list = $cat->get_list(1);
    foreach ($cat_list as $v) {
        $cat_id = $v['id'];
        break;
    }
    $data_list = $data->get_list(true, $cat_id);
    $data_list = $data_list['list'];
    foreach ($data_list as $v) {
        $id = $v['id'];
        break;
    }
}
// $firephp->info($cat_id);
// $firephp->info($id);

$info = $data->get_info($id);
$cat_id = $info['cat_id'];
$firephp->info($info);

$root_info = $cat->get_info(1);
$firephp->info($root_info);

$tmp = array();
$menu = array();
$list = $cat->get_list(1);
foreach ($list as &$v) {
    $v['current'] = false;
    if ($v['id'] === $cat_id) {
        $v['current'] = true;
    }
    $tmp = $data->get_list(true, $v['id']);
    $tmp = $tmp['list'];
    $tmp2 = array();
    foreach ($tmp as &$v2) {
        $v2['current'] = false;
        if ($v2['id'] === $id) {
            $v2['current'] = true;
        }
        $tmp2[] = $v2;
    }
    $v['childs'] = $tmp2;
    $menu[] = $v;
}
$firephp->info($menu);

$page_title = $cat->get_page_title(1);
$keywords = htmlspecialchars($info['meta_keywords']);
$description = htmlspecialchars($info['meta_description']);
if (empty($keywords)) {
    $keywords = $info['name'];
}
if (empty($description)) {
    $description = strip_tags($info['desc']);
    $description = preg_replace( "/\s/", "" , $description );
}
$path = $cat->get_path(1);

$captcha_img = 'admin/captcha.php?act=captcha&rand='.mt_rand();

array_push($css_ext, 'css/ui-lightness/jquery-ui-1.10.3.custom.min.css');
array_push($css_ext, 'css/validationEngine.jquery.css');

array_push($js_ext, 'Scripts/jquery-ui-1.10.3.custom.min.js');
array_push($js_ext, 'Scripts/languages/jquery.validationEngine-zh_TW.js');
array_push($js_ext, 'Scripts/jquery.validationEngine.js');
array_push($js_ext, 'Scripts/contact.js');

?>
<?php include_once('header.php');?>
    <div id="unit_contact" style="background:url(images/my/about_bg01.jpg) no-repeat center top;">
        <div id="pagebody">
            <div class="container">
                <aside>
                    <div id="logo"><img src="images/default/logo.png"></div>
                    <div id="navigation">
                        <div class="title"><h3><?php echo $root_info['name'];?></h3></div>
                    </div>
                </aside>

                <article id="box_center">
                    <?php include_once('main_nav.php');?>

                    <div id="path"><?php echo $path;?></div>
                    <div id="my_title"><h2>【<?php echo $root_info['name'];?>】</h2></div>
                    <section id="my_content" class="edtor">
                        <p>謝謝您訪問我們的網站。如果您對我們的產品和服務有任何問題和建議，請填寫下列表格或E-mail到服務信箱，我們將盡快的回覆您。</p>
                        <div class="contact_form">
                            <form method="post">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="2">名稱<br/><input type="text" placeholder="真實姓名 /  暱稱" class="contact_input validate[required]" name="name" id="name"></td>
                                    </tr>
                                    <tr>
                                        <td height="25" colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">目前使用的電子郵件地址<br/><input name="email" id="email" type="text" placeholder="如：abc@gmail.com" class="contact_input2 validate[required, custom[email]]"></td>
                                    </tr>
                                    <tr>
                                        <td height="25" colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">留言內容<br/><textarea rows="4" class="contact_textarea validate[required]" name="content" id="content"></textarea></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td height="25" colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td>驗證碼<br/><input name="captcha" id="captcha" type="text" placeholder="請輸入圖片中的英文或數字" size="40" class="captcha validate[required]"> <img src="<?=$captcha_img?>"></td>
                                        <td align="right" valign="bottom"><button type="reset"><img src="images/default/btn_correct.png"></button> <button type="send"><img src="images/default/btn_send.png"></button></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </section>
                </article>
            </div>
        </div>
    </div>
<?php include_once('footer.php');?>