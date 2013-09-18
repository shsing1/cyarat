<?php
define('IN_CHH', true);

$id = null;

require_once(dirname(__FILE__) . '/includes/init.php');

$main_nav[2]['current'] = true;

require_once(ROOT_PATH . '/includes/cls_marathon_cat.php');
$cat = new cls_marathon_cat($db, $chh->table("marathon_cat") );

require_once(ROOT_PATH . '/includes/cls_marathon.php');
$data = new cls_marathon($db, $chh->table("marathon"), $cat);


$tmp = array();
$menu = array();
$list = $data->get_list(true, 1);
$list = $list['list'];
foreach ($list as &$v) {
    $v['current'] = false;
    if ($v['id'] === $id) {
        $v['current'] = true;
    }
    $menu[] = $v;
}
$firephp->info($menu);

$root_info = $cat->get_info(1);

$page_title = $cat->get_page_title(1);
$path = $cat->get_path(1);

require_once(ROOT_PATH . '/includes/cls_qa_cat.php');
$cat = new cls_qa_cat($db, $chh->table("qa_cat") );

require_once(ROOT_PATH . '/includes/cls_qa.php');
$data = new cls_qa($db, $chh->table("qa"), $cat);

$qa_root_info = $cat->get_info(1);
$firephp->info($root_info);
$page_title = $qa_root_info['name'] .' - '. $page_title;
$path .= ' / '. $qa_root_info['name'];

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

    <div id="unit_about" style="background:url(images/my/about_bg01.jpg) no-repeat center top;">
        <div id="pagebody">
            <div class="container">
                <aside>
                    <div id="logo"><img src="images/default/logo.png"></div>
                    <div id="navigation">
                        <div class="title"><h3><?php echo $root_info['name'];?></h3></div>
                        <div class="center">
                            <ul>
                                <li class="open">
                                    <ul>
                                        <?php foreach($menu as $v2){?>
                                        <li <?php if($v2['current']){?>class="click"<?php }?>><a href="marathon.php?id=<?php echo $v2['id'];?>"><?php echo htmlspecialchars($v2['name'])?></a></li>
                                        <?php }?>
                                        <li class="click"><a href="qa.php">Q&A</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>

                <article id="box_center">
                    <?php include_once('main_nav.php');?>

                    <div id="path"><?php echo $path;?></div>
                    <div id="my_title"><h2>【<?php echo $qa_root_info['name']?>】</h2></div>
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