<?php
define('IN_CHH', true);

$id = isset($_GET['id']) ? $_GET['id'] : null;

require_once(dirname(__FILE__) . '/includes/init.php');

$main_nav[0]['current'] = true;

require_once(ROOT_PATH . '/includes/cls_funbg_cat.php');
$cat = new cls_funbg_cat($db, $chh->table("funbg_cat") );

require_once(ROOT_PATH . '/includes/cls_funbg.php');
$data = new cls_funbg($db, $chh->table("funbg"), $cat);

$bg_info = $data->get_info(1);

require_once(ROOT_PATH . '/includes/cls_about_us_cat.php');
$cat = new cls_about_us_cat($db, $chh->table("about_us_cat") );

require_once(ROOT_PATH . '/includes/cls_about_us.php');
$data = new cls_about_us($db, $chh->table("about_us"), $cat);

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
$path = $data->get_path($id);

?>
<?php include_once('header.php');?>

    <div id="unit_about" style="background:url(<?php echo $bg_info['original_img']?>) no-repeat center top;">
        <div id="pagebody">
            <div class="container">
                <aside>
                    <div id="logo"><img src="images/default/logo.png"></div>
                    <div id="navigation">
                        <div class="title"><h3><?php echo $root_info['name'];?></h3></div>
                        <div class="center">
                            <ul>
                                <?php foreach($menu as $v){?>
                                <li <?php if($v['current']){?>class="open"<?php }?>><a href="#" class="accordion_item"><?php echo htmlspecialchars($v['name'])?></a>
                                    <?php if($v['childs']){?>
                                    <ul class="accordion_panel">
                                        <?php foreach($v['childs'] as $v2){?>
                                        <li <?php if($v2['current']){?>class="click"<?php }?>><a href="about.php?id=<?php echo $v2['id'];?>"><?php echo htmlspecialchars($v2['name'])?></a></li>
                                        <?php }?>
                                    </ul>
                                    <?php }?>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </aside>

                <article id="box_center">
                    <?php include_once('main_nav.php');?>

                    <div id="path"><?php echo $path;?></div>
                    <div id="my_title"><h2>【<?php echo $info['name']?>】</h2></div>
                    <section id="my_content" class="edtor"><?php echo $info['desc']?></section>
                </article>
            </div>
        </div>
    </div>

<?php include_once('footer.php');?>