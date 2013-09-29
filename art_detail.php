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

require_once(ROOT_PATH . '/includes/cls_art_cat.php');
$cat = new cls_art_cat($db, $chh->table("art_cat") );

require_once(ROOT_PATH . '/includes/cls_art.php');
$data = new cls_art($db, $chh->table("art"), $cat);

require_once(ROOT_PATH . '/includes/cls_art_img.php');
$data_img = new cls_art_img($db, $chh->table("art_img") );

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

array_push($css_ext, 'css/lightbox.css');

array_push($js_ext, 'Scripts/lightbox-2.6.min.js');
array_push($js_ext, 'Scripts/art.js');
?>
<?php include_once('header.php');?>
    <div id="unit_art" style="background:url(<?php echo $bg_info['original_img']?>) no-repeat center top;">
        <div id="pagebody">
            <div class="container">
                <?php include_once('art_menu.php');?>

                <article id="box_center">
                    <?php include_once('main_nav.php');?>

                    <div id="path"><?php echo $path;?></div>
                    <div id="my_title"><h2>【<?php echo htmlspecialchars($info['name']);?>】</h2></div>
                    <section id="my_content" class="edtor">
                        <div class="art2_1">
                            <div class="art_img"><img src="<?php echo $info['img'];?>"></div>
                            <div class="art_imgr">
                                <div class="art_imgr_h"><?php echo nl2br(htmlspecialchars($info['author_title']));?></div>
                                <p><?php echo nl2br(htmlspecialchars($info['author_desc']));?></p>
                            </div>
                        </div>
                        <div class="art2_2">
                            <div class="art_imgr_h2"><?php echo nl2br(htmlspecialchars($info['works_title']));?></div>
                            <p><?php echo nl2br(htmlspecialchars($info['works_desc']));?></p>
                        </div>
                        <?php if($img_list) {?>
                        <div class="art2_3">
                            <ul>
                                <?php foreach($img_list as $v) {?>
                                <li><a href="<?php echo $v['original_img'];?>" data-lightbox="roadtrip"><img src="<?php echo $v['thumb'];?>"></a></li>
                                <?php }?>
                            </ul>
                        </div>
                        <?php }?>
                    </section>
                </article>
            </div>
        </div>
    </div>
<?php include_once('footer.php');?>
