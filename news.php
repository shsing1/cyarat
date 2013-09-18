<?php
define('IN_CHH', true);

$id = 1;

require_once(dirname(__FILE__) . '/includes/init.php');

$main_nav[3]['current'] = true;

require_once(ROOT_PATH . '/includes/cls_news_cat.php');
$cat = new cls_news_cat($db, $chh->table("news_cat") );

require_once(ROOT_PATH . '/includes/cls_news.php');
$data = new cls_news($db, $chh->table("news"), $cat);


$info = $cat->get_info($id);
$firephp->info($info);

$root_info = $cat->get_info(1);
$firephp->info($root_info);


$list = $data->get_list(true, $id);
$list = $list['list'];
$firephp->info($list);

$page_title = $cat->get_page_title($id);
$keywords = htmlspecialchars($info['meta_keywords']);
$description = htmlspecialchars($info['meta_description']);
if (empty($keywords)) {
    $keywords = $info['name'];
}
if (empty($description)) {
    $description = strip_tags($info['name']);
    $description = preg_replace( "/\s/", "" , $description );
}
$path = $cat->get_path($id);

?>
<?php include_once('header.php');?>
    <div id="unit_news" style="background:url(images/my/about_bg02.jpg) no-repeat center top;">
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
                    <div id="my_title"><h2>【<?php echo $root_info['name'];?>】</h2></div>
                    <section id="my_content" class="edtor">
                        <div class="news_list">
                            <ul>
                                <?php foreach($list as $v){?>
                                <li><a href="news_detail.php?id=<?php echo $v['id'];?>"><?php echo htmlspecialchars($v['name'])?>    <span class="news_date"><?php echo $v['sp_date'];?></span></a></li>
                                <?php }?>
                            </ul>
                        </div>
                    </section>
                </article>
            </div>
        </div>
    </div>
<?php include_once('footer.php');?>