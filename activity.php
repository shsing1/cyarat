<?php
define('IN_CHH', true);

$id = isset($_GET['id']) ? $_GET['id'] : null;

require_once(dirname(__FILE__) . '/includes/init.php');

$main_nav[1]['current'] = true;

require_once(ROOT_PATH . '/includes/cls_activity_cat.php');
$cat = new cls_activity_cat($db, $chh->table("activity_cat") );

require_once(ROOT_PATH . '/includes/cls_activity.php');
$data = new cls_activity($db, $chh->table("activity"), $cat);

$cat_list = array();
$data_list = array();
$cat_id = null;

// 沒有id
if ($id === null) {
    $cat_list = $cat->get_list(1, true);
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
$firephp->info($cat_id, 'cat_id');
$firephp->info('id:'.$id);

$list = array();
foreach ($data_list as &$v) {
    $brief = strip_tags($v['author_title']);
    preg_replace( "/\s/", "" , $brief);
    $v['brief'] = $brief;

    $list[] = $v;
}

$info = $data->get_info($id);
$cat_id = $info['cat_id'];
$firephp->info($info);

$root_info = $cat->get_info(1);
$firephp->info($root_info);

$tmp = array();
$menu = array();
$tmp_list = $cat->get_list(1, true);
foreach ($tmp_list as &$v) {
    $v['current'] = false;
    if ($v['id'] === $cat_id) {
        $v['current'] = true;
    }
    $tmp = $data->get_list(true, $v['id']);
    $tmp = $tmp['list'];
    $tmp2 = array();
    foreach ($tmp as &$v2) {
        $v2['current'] = false;
        // if ($v2['id'] === $id) {
        //     $v2['current'] = true;
        // }
        $tmp2[] = $v2;
    }
    $v['childs'] = $tmp2;
    $menu[] = $v;
}
$firephp->info($menu);

$page_title = $cat->get_page_title($cat_id);
$keywords = htmlspecialchars($info['meta_keywords']);
$description = htmlspecialchars($info['meta_description']);
if (empty($keywords)) {
    $keywords = $info['name'];
}
if (empty($description)) {
    $description = strip_tags($info['desc']);
    $description = preg_replace( "/\s/", "" , $description );
}
$fun_name = '城市藝境';
$_LANG['home'] = '首頁 / '.$fun_name;
$path = $cat->get_path($cat_id);

array_push($css_ext, 'css/ui-lightness/jquery-ui-1.10.3.custom.min.css');
array_push($css_ext, 'css/validationEngine.jquery.css');

array_push($js_ext, 'Scripts/jquery-ui-1.10.3.custom.min.js');
array_push($js_ext, 'Scripts/languages/jquery.ui.datepicker-zh-TW.js');
array_push($js_ext, 'Scripts/languages/jquery.validationEngine-zh_TW.js');
array_push($js_ext, 'Scripts/jquery.validationEngine.js');
array_push($js_ext, 'Scripts/activity.js');
?>
<?php include_once('header.php');?>
    <div id="unit_activity" style="background:url(images/my/about_bg02.jpg) no-repeat center top;">
        <div id="pagebody">
            <div class="container">
                <?php include_once('art_menu.php');?>

                <activityicle id="box_center">
                    <?php include_once('main_nav.php');?>

                    <div id="path"><?php echo $path;?></div>
                    <div id="my_title"><h2>【<?php echo $root_info['name'];?>】</h2></div>
                    <section id="my_content" class="edtor">
                        <div class="note">本行事曆提供近六個月之所有上線藝術活動，每次查詢之起日~迄日的設定區間為兩個月。<br/>請妥善利用，方便快速您搜尋到您感興趣的藝術活動。</div>
                        <form method="post" action="activity_list.php">
                        <div class="photo_date">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td valign="top" width="80">自訂查詢：</td>
                                    <td>起日 <input name="mindate" id="mindate" type="text" value="" size="9" class="validate[required]"> <img src="images/default/icon_date.gif">&nbsp;&nbsp;&nbsp;迄日 <input name="maxdate" id="maxdate" type="text" value="" size="9" class="validate[required]"> <img src="images/default/icon_date.gif"><br/><span class="photo_date_ps">可查詢近六個月藝術活動，每次查詢區間最多為二個月</span></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top">快速查詢：</td>
                                    <td><input name="" type="text" value="2013/08/12" size="9">&nbsp;&nbsp;&nbsp;&nbsp;<input name="" type="text" value="2013/08/12" size="9">&nbsp;&nbsp;&nbsp;&nbsp;<input name="" type="text" value="2013/08/12" size="9">&nbsp;&nbsp;&nbsp;&nbsp;<input name="" type="text" value="2013/08/12" size="9">&nbsp;&nbsp;&nbsp;&nbsp;<input name="" type="text" value="2013/08/12" size="9">&nbsp;&nbsp;&nbsp;&nbsp;<input name="" type="text" value="2013/08/12" size="9"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="box_btn">
                            <input type="submit" value="" class="search_btn" />
                        </div>
                    </form>
                    </section>
                </activityicle>
            </div>
        </div>
    </div>
<?php include_once('footer.php');?>
