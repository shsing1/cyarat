<?php
define('IN_CHH', true);

$id = isset($_GET['id']) ? $_GET['id'] : null;

require_once(dirname(__FILE__) . '/includes/init.php');

$main_nav[1]['current'] = true;

require_once(ROOT_PATH . '/includes/cls_funbg_cat.php');
$cat = new cls_funbg_cat($db, $chh->table("funbg_cat") );

require_once(ROOT_PATH . '/includes/cls_funbg.php');
$data = new cls_funbg($db, $chh->table("funbg"), $cat);

$bg_info = $data->get_info(2);

require_once(ROOT_PATH . '/includes/cls_activity_cat.php');
$cat = new cls_activity_cat($db, $chh->table("activity_cat") );

require_once(ROOT_PATH . '/includes/cls_activity.php');
$data = new cls_activity($db, $chh->table("activity"), $cat);

require_once(ROOT_PATH . '/includes/cls_activity_img.php');
$data_img = new cls_activity_img($db, $chh->table("activity_img") );

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
$info['date'] = local_date('Y / m / d', $info['date']);
$cat_id = $info['cat_id'];
$firephp->info($info);

// 取得資料data_img圖片
$img_list = $data_img->get_img_list($info['id']);
$img_list = $img_list['list'];
$firephp->info($img_list);

$root_info = $cat->get_info(1);
$firephp->info($root_info);

$page_title = $data->get_page_title($id);
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

array_push($css_ext, 'css/galleriffic-2.css');

array_push($js_ext, 'Scripts/jquery.galleriffic.js');
array_push($js_ext, 'Scripts/jquery.opacityrollover.js');
array_push($js_ext, 'Scripts/activity.js');
?>
<?php include_once('header.php');?>
    <div id="unit_activity" style="background:url(<?php echo $bg_info['original_img']?>) no-repeat center top;">
        <div id="pagebody">
            <div class="container">
                <?php include_once('art_menu.php');?>

                <activityicle id="box_center">
                    <?php include_once('main_nav.php');?>

                    <div id="path"><?php echo $path;?></div>
                    <div id="my_title"><h2>【<?php echo htmlspecialchars($info['name']);?>】</h2></div>
                    <section id="my_content" class="edtor">
                        <div class="photo_detail">
                            <div class="note">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="80"><?php echo $_LANG['lab_date'];?>：</td>
                                            <td><?php echo $info['date']?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $_LANG['lab_location'];?>：</td>
                                            <td><?php echo htmlspecialchars($info['location'])?></td>
                                        </tr>
                                        <tr>
                                            <td valign="top"><?php echo $_LANG['lab_content'];?>：</td>
                                            <td><?php echo nl2br(htmlspecialchars($info['content']))?></td>
                                        </tr>
                                    </table>
                            </div>
                            <?php if(count($img_list) > 0) {?>
                            <div class="box_album">
                                <div id="gallery" class="content">
                                    <div class="slideshow-container">
                                        <div id="loading" class="loader"></div>
                                        <div id="slideshow" class="slideshow"></div>
                                    </div>
                                    <div id="controls" class="controls"></div>
                                </div>
                                <div id="thumbs" class="navigation">
                                    <ul class="thumbs noscript">
                                        <?php foreach($img_list as $v){?>
                                        <li>
                                            <a class="thumb" name="leaf" href="<?php echo $v['img'];?>" title="<?php echo htmlspecialchars($v['name'])?>">
                                                <img src="<?php echo $v['thumb'];?>" alt="<?php echo htmlspecialchars($v['name'])?>" width="75" />
                                            </a>
                                        </li>
                                        <?php }?>
                                    </ul>
                                </div>
                                <div style="clear: both;"></div>
                            </div>
                            <?php }?>
                        </div>
                    </section>
                </activityicle>
            </div>
        </div>
    </div>
<?php include_once('footer.php');?>
