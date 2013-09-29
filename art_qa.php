<?php
define('IN_CHH', true);

$id = null;

require_once(dirname(__FILE__) . '/includes/init.php');

$main_nav[1]['current'] = true;

require_once(ROOT_PATH . '/includes/cls_funbg_cat.php');
$cat = new cls_funbg_cat($db, $chh->table("funbg_cat") );

require_once(ROOT_PATH . '/includes/cls_funbg.php');
$data = new cls_funbg($db, $chh->table("funbg"), $cat);

$bg_info = $data->get_info(2);

require_once(ROOT_PATH . '/includes/cls_art_qa_cat.php');
$cat = new cls_art_qa_cat($db, $chh->table("art_qa_cat") );

require_once(ROOT_PATH . '/includes/cls_art_qa.php');
$data = new cls_art_qa($db, $chh->table("art_qa"), $cat);

$cat_id = 1;

$art_qa_root_info = $cat->get_info(1);
$firephp->info($root_info);

$page_title = $art_qa_root_info['name'] .' - '. $page_title;

$fun_name = '城市地景藝術展';
$_LANG['home'] = '首頁 / '.$fun_name;
$path = $cat->get_path($cat_id);

$tmp = array();
$list = array();
$tmp_list = $cat->get_list(1);
foreach ($tmp_list as $k=>&$v) {
    $v['current'] = false;
    if ($k === 0) {
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
    $list[] = $v;
}
$firephp->info($list);

$keywords = htmlspecialchars($info['meta_keywords']);
$description = htmlspecialchars($info['meta_description']);
if (empty($keywords)) {
    $keywords = $info['name'];
}
if (empty($description)) {
    $description = strip_tags($info['desc']);
    $description = preg_replace( "/\s/", "" , $description );
}


?>
<?php include_once('header.php');?>

    <div id="unit_about" style="background:url(<?php echo $bg_info['original_img']?>) no-repeat center top;">
        <div id="pagebody">
            <div class="container">
                <?php include_once('art_menu.php');?>

                <article id="box_center">
                    <?php include_once('main_nav.php');?>

                    <div id="path"><?php echo $path;?></div>
                    <div id="my_title"><h2>【<?php echo $art_qa_root_info['name']?>】</h2></div>
                    <section id="my_content" class="edtor">
                        <div class="qa_list" id="qa_list">
                            <p>搜尋您要找的問題類型 <select name="qa_select" id="qa_select">
                                <?php foreach($list as $v){?>
                                <option value="<?php echo $v['id']?>"><?php echo htmlspecialchars($v['name']);?></option>
                                <?php }?>
                            </select>
                            （下解答若無法解決您的疑問，請您聯絡我們）</p>
                            <ul>
                                <?php foreach($list as $v){?>
                                <li <?php if($v['current']){?>class="open"<?php }?>><a href="#"><?php echo htmlspecialchars($v['name']);?></a>
                                    <?php if($v['childs']){?>
                                    <ul>
                                        <?php foreach($v['childs'] as $v2){?>
                                        <li>
                                            <div class="q"><?php echo htmlspecialchars($v2['name']);?></div>
                                            <div class="a"><?php echo nl2br(htmlspecialchars($v2['desc']));?></div>
                                        </li>
                                        <?php }?>
                                    </ul>
                                    <?php }?>
                                </li>
                                <?php }?>
                            </ul>
                        </div>
                    </section>
                </article>
            </div>
        </div>
    </div>

<?php include_once('footer.php');?>