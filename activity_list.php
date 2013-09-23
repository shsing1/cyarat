<?php
define('IN_CHH', true);

$mindate = isset($_POST['mindate']) ? $_POST['mindate'] : null;
$maxdate = isset($_POST['maxdate']) ? $_POST['maxdate'] : null;
$date = isset($_POST['date']) ? $_POST['date'] : null;

$cat_id = 1;

require_once(dirname(__FILE__) . '/includes/init.php');

$main_nav[1]['current'] = true;

require_once(ROOT_PATH . '/includes/cls_activity_cat.php');
$cat = new cls_activity_cat($db, $chh->table("activity_cat") );

require_once(ROOT_PATH . '/includes/cls_activity.php');
$data = new cls_activity($db, $chh->table("activity"), $cat);

require_once(ROOT_PATH . '/includes/cls_activity_img.php');
$data_img = new cls_activity_img($db, $chh->table("activity_img") );

// 快速查詢
if ($date) {
    $list = $data->get_list_by_date($date);
    $list = $list['list'];
// 範圍搜尋
} else {
    $list = $data->get_search_list($mindate, $maxdate);
    $list = $list['list'];
}

$tmp_list = array();
// 取得第一張圖
foreach($list as $v) {
    $img = $data_img->get_first_img($v['id']);
    $firephp->info($img);
    $v['thumb'] = $img['thumb'];


    $tmp_list[] = $v;
}
$list = $tmp_list;
$firephp->info($list);

$root_info = $cat->get_info($cat_id);

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

array_push($js_ext, 'Scripts/masonry.pkgd.min.js');
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
                        <div class="photo_list">
                            <?php if (count($list) > 0) {?>
                            <ul>
                                <?php foreach($list as $v){?>
                                <li>
                                    <div class="photo_listl"><a href="activity_detail.php?id=<?php echo $v['id'];?>"><img src="<?php echo $v['thumb'];?>" width="105"></a></div>
                                    <div class="photo_listr">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="80"><?php echo $_LANG['lab_date'];?>：</td>
                                                <td><?php echo $v['date']?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $_LANG['lab_location'];?>：</td>
                                                <td><?php echo htmlspecialchars($v['location'])?></td>
                                            </tr>
                                            <tr>
                                                <td valign="top"><?php echo $_LANG['lab_content'];?>：</td>
                                                <td><?php echo htmlspecialchars($v['content'])?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </li>
                                <?php }?>
                            </ul>
                            <?php }else{?>
                            <div class="empty_data">查無資料！</div>
                            <?php }?>
                        </div>
                    </section>
                </activityicle>
            </div>
        </div>
    </div>
<?php include_once('footer.php');?>
