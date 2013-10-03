<?php
define('IN_CHH', true);

$id = isset($_GET['id']) ? $_GET['id'] : null;

require_once(dirname(__FILE__) . '/includes/init.php');

$main_nav[3]['current'] = true;

require_once(ROOT_PATH . '/includes/cls_funbg_cat.php');
$cat = new cls_funbg_cat($db, $chh->table("funbg_cat") );

require_once(ROOT_PATH . '/includes/cls_funbg.php');
$data = new cls_funbg($db, $chh->table("funbg"), $cat);

$bg_info = $data->get_info(4);

require_once(ROOT_PATH . '/includes/cls_news_cat.php');
$cat = new cls_news_cat($db, $chh->table("news_cat") );

require_once(ROOT_PATH . '/includes/cls_news.php');
$data = new cls_news($db, $chh->table("news"), $cat);

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

$prev = array();
$next = array();
$list = $data->get_list(true, 1);
$list = $list['list'];
foreach ($list as $k=>$v) {
    if ($v['id'] === $id) {
        if (isset($list[$k - 1])) {
            $prev = $list[$k - 1];
        }
        if (isset($list[$k + 1])) {
            $next = $list[$k + 1];
        }
    }
}


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
$path = $cat->get_path($cat_id);

?>
<?php include_once('header.php');?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=176461279207780";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
    <div id="unit_news" style="background:url(<?php echo $bg_info['original_img']?>) no-repeat center top;">
        <div id="pagebody">
            <div class="container">
                <aside>
                    <div id="logo"><img src="images/default/logo.png"></div>
                    <div id="navigation">
                        <div class="title"><h3><?php echo $root_info['name'];?></h3></div>
                        <div class="center">
                            <?php /*?>
                            <ul>
                                <li class="open"><a href="#">藝動節緣起</a>
                                    <ul>
                                        <li class="click"><a href="#">活動宗旨</a></li>
                                        <li><a href="#">展覽概念</a></li>
                                        <li><a href="#">策展人介紹</a></li>
                                        <li><a href="#">展覽資訊</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">主協辦單位</a></li>
                            </ul>
                            <? */?>
                        </div>
                    </div>
                </aside>

                <article id="box_center">
                    <?php include_once('main_nav.php');?>

                    <div id="path"><?php echo $path;?></div>
                    <div id="my_title"><h2>【<?php echo $info['name']?>】</h2></div>
                    <section id="my_content" class="edtor">
                        <div class="news_detail">
                            <span class="news_date"><?php echo $info['sp_date'];?></span>
                            <p><?php echo $info['desc']?></div>
                        <div class="btn_list">
                            <span class="new_fb">
                                <div class="fb-like" data-href="<?php echo curPageURL();?>" data-width="100" data-layout="button_count" data-action="recommend" data-show-faces="true" data-send="true"></div>
                            </span>
                            <span class="btn_go"><?php if($prev){?><a href="news_detail.php?id=<?php echo $prev['id'];?>">< 上一則</a><?php }?>　|　<?php if($next){?><a href="news_detail.php?id=<?php echo $next['id'];?>">下一則 ></a><?php }?></span>
                        </div>
                    </section>
                </article>
            </div>
        </div>
    </div>
<?php include_once('footer.php');?>
