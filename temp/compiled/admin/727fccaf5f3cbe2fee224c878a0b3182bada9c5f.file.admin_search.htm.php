<?php /* Smarty version Smarty-3.1.14, created on 2013-09-11 16:40:24
         compiled from "D:\xampp\htdocs\cyarat\admin\templates\admin_search.htm" */ ?>
<?php /*%%SmartyHeaderCode:1795952309cf8637814-53495577%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '727fccaf5f3cbe2fee224c878a0b3182bada9c5f' => 
    array (
      0 => 'D:\\xampp\\htdocs\\cyarat\\admin\\templates\\admin_search.htm',
      1 => 1259940199,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1795952309cf8637814-53495577',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'cat_list' => 0,
    'serach_keyword' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52309cf864ef15_51855150',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52309cf864ef15_51855150')) {function content_52309cf864ef15_51855150($_smarty_tpl) {?><div class="form-div">
	<form action="javascript:searchGoods()" name="searchForm">
		<img src="templates/images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
		<!-- 分類 -->
		<select name="cat_id">
			<option value="0"><?php echo $_smarty_tpl->tpl_vars['lang']->value['all_cat'];?>
</option>
			<?php echo $_smarty_tpl->tpl_vars['cat_list']->value;?>

		</select>
		<!-- 關鍵字 -->
		<?php echo $_smarty_tpl->tpl_vars['lang']->value['keyword'];?>

		<input type="text" name="keyword" size="15" value="<?php echo $_smarty_tpl->tpl_vars['serach_keyword']->value;?>
" />
		<input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['button_search'];?>
" class="button" />
	</form>
</div>

<script language="JavaScript">
    function searchGoods()
    {

        <?php if ($_GET['act']!="trash"){?>
        listTable.filter['cat_id'] = document.forms['searchForm'].elements['cat_id'].value;
        <?php }?>

        listTable.filter['keyword'] = Utils.trim(document.forms['searchForm'].elements['keyword'].value);
        listTable.filter['page'] = 1;

        listTable.loadList();
    }
</script>
<?php }} ?>