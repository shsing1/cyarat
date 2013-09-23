<?php
define('IN_CHH', true);

$id = isset($_GET['id']) ? $_GET['id'] : null;

require_once(dirname(__FILE__) . '/includes/init.php');

$main_nav[1]['current'] = true;

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
$fun_name = '城市藝境';
$_LANG['home'] = '首頁 / '.$fun_name;
$path = $cat->get_path($cat_id);

array_push($css_ext, 'css/galleriffic-2.css');

array_push($js_ext, 'Scripts/jquery.galleriffic.js');
array_push($js_ext, 'Scripts/jquery.opacityrollover.js');
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
                            <div class="box_album">
                                <div id="gallery" class="content">
                                    <div id="controls" class="controls"></div>
                                    <div class="slideshow-container">
                                        <div id="loading" class="loader"></div>
                                        <div id="slideshow" class="slideshow"></div>
                                    </div>
                                    <div id="caption" class="caption-container"></div>
                                </div>
                                <div id="thumbs" class="navigation">
                                    <ul class="thumbs noscript">
                                        <li>
                                            <a class="thumb" name="leaf" href="http://farm4.static.flickr.com/3261/2538183196_8baf9a8015.jpg" title="Title #0">
                                                <img src="http://farm4.static.flickr.com/3261/2538183196_8baf9a8015_s.jpg" alt="Title #0" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm4.static.flickr.com/3261/2538183196_8baf9a8015_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #0</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" name="drop" href="http://farm3.static.flickr.com/2404/2538171134_2f77bc00d9.jpg" title="Title #1">
                                                <img src="http://farm3.static.flickr.com/2404/2538171134_2f77bc00d9_s.jpg" alt="Title #1" />
                                            </a>
                                            <div class="caption">
                                                Any html can be placed here ...
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" name="bigleaf" href="http://farm3.static.flickr.com/2093/2538168854_f75e408156.jpg" title="Title #2">
                                                <img src="http://farm3.static.flickr.com/2093/2538168854_f75e408156_s.jpg" alt="Title #2" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm3.static.flickr.com/2093/2538168854_f75e408156_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #2</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" name="lizard" href="http://farm4.static.flickr.com/3153/2538167690_c812461b7b.jpg" title="Title #3">
                                                <img src="http://farm4.static.flickr.com/3153/2538167690_c812461b7b_s.jpg" alt="Title #3" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm4.static.flickr.com/3153/2538167690_c812461b7b_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #3</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm4.static.flickr.com/3150/2538167224_0a6075dd18.jpg" title="Title #4">
                                                <img src="http://farm4.static.flickr.com/3150/2538167224_0a6075dd18_s.jpg" alt="Title #4" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm4.static.flickr.com/3150/2538167224_0a6075dd18_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #4</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm4.static.flickr.com/3204/2537348699_bfd38bd9fd.jpg" title="Title #5">
                                                <img src="http://farm4.static.flickr.com/3204/2537348699_bfd38bd9fd_s.jpg" alt="Title #5" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm4.static.flickr.com/3204/2537348699_bfd38bd9fd_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #5</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm4.static.flickr.com/3124/2538164582_b9d18f9d1b.jpg" title="Title #6">
                                                <img src="http://farm4.static.flickr.com/3124/2538164582_b9d18f9d1b_s.jpg" alt="Title #6" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm4.static.flickr.com/3124/2538164582_b9d18f9d1b_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #6</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm4.static.flickr.com/3205/2538164270_4369bbdd23.jpg" title="Title #7">
                                                <img src="http://farm4.static.flickr.com/3205/2538164270_4369bbdd23_s.jpg" alt="Title #7" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm4.static.flickr.com/3205/2538164270_c7d1646ecf_o.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #7</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm4.static.flickr.com/3211/2538163540_c2026243d2.jpg" title="Title #8">
                                                <img src="http://farm4.static.flickr.com/3211/2538163540_c2026243d2_s.jpg" alt="Title #8" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm4.static.flickr.com/3211/2538163540_c2026243d2_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #8</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm3.static.flickr.com/2315/2537343449_f933be8036.jpg" title="Title #9">
                                                <img src="http://farm3.static.flickr.com/2315/2537343449_f933be8036_s.jpg" alt="Title #9" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm3.static.flickr.com/2315/2537343449_f933be8036_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #9</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm3.static.flickr.com/2167/2082738157_436d1eb280.jpg" title="Title #10">
                                                <img src="http://farm3.static.flickr.com/2167/2082738157_436d1eb280_s.jpg" alt="Title #10" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm3.static.flickr.com/2167/2082738157_436d1eb280_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #10</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm3.static.flickr.com/2342/2083508720_fa906f685e.jpg" title="Title #11">
                                                <img src="http://farm3.static.flickr.com/2342/2083508720_fa906f685e_s.jpg" alt="Title #11" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm3.static.flickr.com/2342/2083508720_fa906f685e_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #11</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm3.static.flickr.com/2132/2082721339_4b06f6abba.jpg" title="Title #12">
                                                <img src="http://farm3.static.flickr.com/2132/2082721339_4b06f6abba_s.jpg" alt="Title #12" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm3.static.flickr.com/2132/2082721339_4b06f6abba_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #12</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm3.static.flickr.com/2139/2083503622_5b17f16a60.jpg" title="Title #13">
                                                <img src="http://farm3.static.flickr.com/2139/2083503622_5b17f16a60_s.jpg" alt="Title #13" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm3.static.flickr.com/2139/2083503622_5b17f16a60_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #13</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm3.static.flickr.com/2041/2083498578_114e117aab.jpg" title="Title #14">
                                                <img src="http://farm3.static.flickr.com/2041/2083498578_114e117aab_s.jpg" alt="Title #14" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm3.static.flickr.com/2041/2083498578_114e117aab_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #14</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm3.static.flickr.com/2149/2082705341_afcdda0663.jpg" title="Title #15">
                                                <img src="http://farm3.static.flickr.com/2149/2082705341_afcdda0663_s.jpg" alt="Title #15" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm3.static.flickr.com/2149/2082705341_afcdda0663_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #15</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm3.static.flickr.com/2014/2083478274_26775114dc.jpg" title="Title #16">
                                                <img src="http://farm3.static.flickr.com/2014/2083478274_26775114dc_s.jpg" alt="Title #16" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm3.static.flickr.com/2014/2083478274_26775114dc_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #16</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm3.static.flickr.com/2194/2083464534_122e849241.jpg" title="Title #17">
                                                <img src="http://farm3.static.flickr.com/2194/2083464534_122e849241_s.jpg" alt="Title #17" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm3.static.flickr.com/2194/2083464534_122e849241_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #17</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm4.static.flickr.com/3127/2538173236_b704e7622e.jpg" title="Title #18">
                                                <img src="http://farm4.static.flickr.com/3127/2538173236_b704e7622e_s.jpg" alt="Title #18" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm4.static.flickr.com/3127/2538173236_b704e7622e_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #18</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm3.static.flickr.com/2375/2538172432_3343a47341.jpg" title="Title #19">
                                                <img src="http://farm3.static.flickr.com/2375/2538172432_3343a47341_s.jpg" alt="Title #19" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm3.static.flickr.com/2375/2538172432_3343a47341_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #19</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm3.static.flickr.com/2353/2083476642_d00372b96f.jpg" title="Title #20">
                                                <img src="http://farm3.static.flickr.com/2353/2083476642_d00372b96f_s.jpg" alt="Title #20" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm3.static.flickr.com/2353/2083476642_d00372b96f_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #20</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm3.static.flickr.com/2201/1502907190_7b4a2a0e34.jpg" title="Title #21">
                                                <img src="http://farm3.static.flickr.com/2201/1502907190_7b4a2a0e34_s.jpg" alt="Title #21" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm3.static.flickr.com/2201/1502907190_7b4a2a0e34_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #21</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm2.static.flickr.com/1116/1380178473_fc640e097a.jpg" title="Title #22">
                                                <img src="http://farm2.static.flickr.com/1116/1380178473_fc640e097a_s.jpg" alt="Title #22" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm2.static.flickr.com/1116/1380178473_fc640e097a_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #22</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>

                                        <li>
                                            <a class="thumb" href="http://farm2.static.flickr.com/1260/930424599_e75865c0d6.jpg" title="Title #23">
                                                <img src="http://farm2.static.flickr.com/1260/930424599_e75865c0d6_s.jpg" alt="Title #23" />
                                            </a>
                                            <div class="caption">
                                                <div class="download">
                                                    <a href="http://farm2.static.flickr.com/1260/930424599_e75865c0d6_b.jpg">Download Original</a>
                                                </div>
                                                <div class="image-title">Title #23</div>
                                                <div class="image-desc">Description</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div style="clear: both;"></div>
                            </div>
                        </div>
                    </section>
                </activityicle>
            </div>
        </div>
    </div>
<?php include_once('footer.php');?>
