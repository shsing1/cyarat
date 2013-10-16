<?php
require_once(ROOT_PATH . '/includes/cls_custom.php');
$data = new cls_custom($db, $chh->table("custom") );
$footer_info = $data->get_info(1);
$footer_info['desc'] = str_replace('../images/editor_upload', './images/editor_upload', $footer_info['desc']);
?>
    <footer>
        <div id="footer">
            <div class="footer_copyright">© 2013 新竹藝動節. All Rights Reserved.</div>
            <div class="share">
                <a target="_blank" href="https://www.facebook.com/pages/2013%E6%96%B0%E7%AB%B9%E8%97%9D%E5%8B%95%E7%AF%80-%E5%9F%8E%E5%B8%82%E5%9C%B0%E6%99%AF%E8%97%9D%E8%A1%93%E5%B1%95/575660252470323?ref=hl">
                <img src="images/default/icon_fb.png"></a>&nbsp;
                <a target="_blank" href="https://www.facebook.com/SuperheroIGotU">
                <img src="images/default/icon_fb2.png"></a>
            </div>
            <?php echo $footer_info['desc'];?>
        </div>
    </footer>
</div>

<script src="Scripts/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="Scripts/common.js" type="text/javascript"></script>
<?php foreach ($js_ext as $v) {?>
<script src="<?php echo $v;?>" type="text/javascript"></script>
<?php }?>

</body>
</html>
