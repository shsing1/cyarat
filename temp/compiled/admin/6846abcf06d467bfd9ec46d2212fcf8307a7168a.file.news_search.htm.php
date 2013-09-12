<?php /* Smarty version Smarty-3.1.14, created on 2013-09-11 16:33:03
         compiled from "D:\xampp\htdocs\cyarat\admin\templates\news_search.htm" */ ?>
<?php /*%%SmartyHeaderCode:2261952309b3f29cb48-61969770%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6846abcf06d467bfd9ec46d2212fcf8307a7168a' => 
    array (
      0 => 'D:\\xampp\\htdocs\\cyarat\\admin\\templates\\news_search.htm',
      1 => 1259940229,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2261952309b3f29cb48-61969770',
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
  'unifunc' => 'content_52309b3f2bbf42_58973489',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52309b3f2bbf42_58973489')) {function content_52309b3f2bbf42_58973489($_smarty_tpl) {?><div class="form-div">
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