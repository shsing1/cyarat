<?php
require_once(ROOT_PATH . '/includes/cls_art_cat.php');
$cat = new cls_art_cat($db, $chh->table("art_cat") );

require_once(ROOT_PATH . '/includes/cls_art.php');
$data = new cls_art($db, $chh->table("art"), $cat);

$tmp = array();
$menu = array();
$tmp_list = $cat->get_list(1, true);
foreach ($tmp_list as &$v) {
    $v['current'] = false;
    if (in_array($php_self, array('/art.php', '/art_detail.php'))) {
        if ($v['id'] === $cat_id) {
            $v['current'] = true;
        }
    }
    $tmp = $data->get_list(true, $v['id']);
    $tmp = $tmp['list'];
    $tmp2 = array();
    foreach ($tmp as &$v2) {
        $v2['current'] = false;
        if ($php_self === '/art_detail.php') {
            if ($v2['id'] === $id) {
                $v2['current'] = true;
            }
        }

        $tmp2[] = $v2;
    }
    $v['childs'] = $tmp2;
    $menu[] = $v;
}
$firephp->info($menu);

require_once(ROOT_PATH . '/includes/cls_activity_cat.php');
$cat = new cls_activity_cat($db, $chh->table("activity_cat") );
$tmp_info = $cat->get_info(1);
$activity_name = $tmp_info['name'];

?>
                <aside>
                    <div id="logo"><img src="images/default/logo.png"></div>
                    <div id="navigation">
                        <div class="title"><h3><?php echo $fun_name;?></h3></div>
                        <div class="center">
                            <ul>
                                <?php foreach($menu as $v){?>
                                <li <?php if($v['current']){?>class="open"<?php }?>><a href="#" class="accordion_item"><?php echo htmlspecialchars($v['name'])?></a>
                                    <?php if($v['childs']){?>
                                    <ul class="accordion_panel">
                                        <?php foreach($v['childs'] as $v2){?>
                                        <li <?php if($v2['current']){?>class="click"<?php }?>><a href="art_detail.php?id=<?php echo $v2['id'];?>"><?php echo htmlspecialchars($v2['name'])?></a></li>
                                        <?php }?>
                                    </ul>
                                    <?php }?>
                                </li>
                                <?php }?>
                                <li><a href="activity.php" ><?php echo htmlspecialchars($activity_name)?></a></li>
                                <li><a href="art_qa.php" >Q & A</a></li>
                            </ul>
                        </div>
                    </div>
                </aside>
