<?php /* Smarty version Smarty-3.1.14, created on 2013-09-11 16:32:58
         compiled from "D:\xampp\htdocs\cyarat\admin\templates\sys_menu_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:3073252309b3aa92c38-75290773%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c6bd044113638a3c72175a0ef6d64a92312b262' => 
    array (
      0 => 'D:\\xampp\\htdocs\\cyarat\\admin\\templates\\sys_menu_list.htm',
      1 => 1259850539,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3073252309b3aa92c38-75290773',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'cat_info' => 0,
    'cat' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52309b3ab0bdd6_34622114',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52309b3ab0bdd6_34622114')) {function content_52309b3ab0bdd6_34622114($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("pageheader.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" src="templates/../../js/utils.js"></script>
<script type="text/javascript" src="templates/../js/listtable.js"></script>
<form method="post" action="" name="listForm">
	<!-- start 資料 list -->
	<div class="list-div" id="listDiv">
		<table width="100%" cellspacing="1" cellpadding="2" id="list-table">
			<tr>
				<th><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_name'];?>
</th>
				<th width="300"><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_url'];?>
</th>
				<th width="100"><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_is_chh'];?>
</th>
				<th width="150"><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_handler'];?>
</th>
			</tr>
			<?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_info']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value){
$_smarty_tpl->tpl_vars['cat']->_loop = true;
?>
			<tr align="center" class="<?php echo $_smarty_tpl->tpl_vars['cat']->value['depth'];?>
">
				<td align="left" class="first-cell" > <?php if ($_smarty_tpl->tpl_vars['cat']->value['is_leaf']!=1){?> <img src="templates/images/menu_minus.gif" width="9" height="9" border="0" style="margin-left:<?php echo $_smarty_tpl->tpl_vars['cat']->value['depth'];?>
em" onclick="rowClicked(this)" /> <?php }else{ ?> <img src="templates/images/menu_arrow.gif" width="9" height="9" border="0" style="margin-left:<?php echo $_smarty_tpl->tpl_vars['cat']->value['depth'];?>
em" /> <?php }?> <span><?php echo $_smarty_tpl->tpl_vars['cat']->value['name'];?>
</span></td>
				<td><?php echo $_smarty_tpl->tpl_vars['cat']->value['url'];?>
</td>
				<td><img src="templates/images/<?php if ($_smarty_tpl->tpl_vars['cat']->value['is_chh']=='1'){?>yes<?php }else{ ?>no<?php }?>.gif" /></td>				
				<td align="center">
					<a href="?act=edit&cat_id=<?php echo $_smarty_tpl->tpl_vars['cat']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['lang']->value['edit'];?>
"><img src="templates/images/icon_edit.gif" border="0" /></a>
					<a href="javascript:;" onclick="remove(<?php echo $_smarty_tpl->tpl_vars['cat']->value['id'];?>
)" title="<?php echo $_smarty_tpl->tpl_vars['lang']->value['remove'];?>
"><img src="templates/images/icon_drop.gif" border="0" /></a></td>
			</tr>
			<?php }
if (!$_smarty_tpl->tpl_vars['cat']->_loop) {
?>
			<tr>
				<td class="no-records" colspan="10"><?php echo $_smarty_tpl->tpl_vars['lang']->value['no_records'];?>
</td>
			</tr>
			<?php } ?>
		</table>
	</div>
	<!-- end 資料 list -->
</form>

<?php echo $_smarty_tpl->getSubTemplate ("pagefooter.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>