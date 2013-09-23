<?php
require_once(ROOT_PATH . '/includes/cls_custom.php');
$data = new cls_custom($db, $chh->table("custom") );
$footer_info = $data->get_info(1);
$footer_info['desc'] = str_replace('../images/editor_upload', './images/editor_upload', $footer_info['desc']);
?>
    <footer>
        <div id="footer">
            <div class="footer_copyright">© 2013 新竹藝動節. All Rights Reserved.</div>
            <div class="share"><a href="https://www.facebook.com/SuperheroIGotU" target="_blank"><img src="images/default/icon_fb.png"></a> <img src="images/default/icon_yt.png"></div>
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
