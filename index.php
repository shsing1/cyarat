<?php
define('IN_CHH', true);

$id = isset($_GET['id']) ? $_GET['id'] : null;

require_once(dirname(__FILE__) . '/includes/init.php');

unset($main_nav[5]);

require_once(ROOT_PATH . '/includes/cls_indexbg_cat.php');
$cat = new cls_indexbg_cat($db, $chh->table("indexbg_cat") );

require_once(ROOT_PATH . '/includes/cls_indexbg.php');
$data = new cls_indexbg($db, $chh->table("indexbg"), $cat);

$bglist = $data->get_list(true, 1);
$bglist = $bglist['list'];
$firephp->info($bglist);

require_once(ROOT_PATH . '/includes/cls_news_cat.php');
$cat = new cls_news_cat($db, $chh->table("news_cat") );

require_once(ROOT_PATH . '/includes/cls_news.php');
$data = new cls_news($db, $chh->table("news"), $cat);

$_REQUEST['page_size'] = 3;

$newslist = $data->get_list(false, 1);
$newslist = $newslist['list'];
$firephp->info($newslist);


$css_ext = array('css/anythingslider.css', 'css/index.css');

array_push($js_ext, 'Scripts/jquery.anythingslider.min.js');
array_push($js_ext, 'Scripts/jquery.anythingslider.fx.min.js');
array_push($js_ext, 'Scripts/jquery.easing.1.2.js');
array_push($js_ext, 'Scripts/trunk8.min.js');
array_push($js_ext, 'Scripts/index.js');

?>
<?php include_once('header.php');?>
	<div id="pagebody">
		<div class="container">
			<div id="logo"><img src="images/index/logo.png"></div>
		</div>
		<div class="bg_slider">
			<a href="#" class="arrow arr_prev" id="slider_back"><span class=""></span></a>
			<div class="mask">
				<ul class="items_bar" id="slider">
					<?php foreach($bglist as $v){?>
					<li>
						<div class="rsContent">
							<img src="<?php echo $v['original_img']?>">
							<div class="slider_text">
								<h1 class="rsABlock main_title"><?php echo htmlspecialchars($v['main_title'])?></h1>
								<h2 class="rsABlock sub_title"><?php echo htmlspecialchars($v['sub_title'])?></h2>
							</div>
						</div>
					</li>
					<?php }?>
				</ul>
			</div>
			<a href="#" class="arrow arr_next" id="slider_forward"><span></span></a>
		</div>
		<div id="box_news">
			<div class="news_closs" id="news_open_btn">
				<div class="news_closs_btn"></div>
			</div>
			<div class="container" id="news_panel">
				<div class="news_btn" id="news_close_btn"></div>
				<div class="news_center">
					<ul>
						<?php foreach($newslist as $v){?>
						<li><a href="news_detail.php?id=<?php echo $v['id']?>"><span class="news_title"><?php echo htmlspecialchars($v['name'])?></span><span class="news_brief"><?php echo htmlspecialchars($v['brief'])?></span>（<?php echo $v['sp_date2']?>）</a>
						</li>
						<?php }?>
					</ul>
				</div>
			</div>
		</div>
		<?php include_once('main_nav.php');?>
	</div>
</div>
<div>
<?php include_once('footer.php');?>
