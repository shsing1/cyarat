<?php
define('IN_CHH', true);

require_once(dirname(__FILE__) . '/includes/init.php');

$main_nav[1]['current'] = true;

require_once(ROOT_PATH . '/includes/cls_activity_cat.php');
$cat = new cls_activity_cat($db, $chh->table("activity_cat") );

require_once(ROOT_PATH . '/includes/cls_activity.php');
$data = new cls_activity($db, $chh->table("activity"), $cat);

$cat_id = 1;

$root_info = $cat->get_info($cat_id);
$firephp->info($root_info);

$list = $data->get_date_list();
$firephp->info($list);

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
$fun_name = '城市地景藝術展';
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
                                    <td>
                                        <?php foreach($list as $v){?>
                                        <input name="" type="text" value="<?php echo $v['date'];?>" size="9" class="search_date">&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php }?>
                                    </td>
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
