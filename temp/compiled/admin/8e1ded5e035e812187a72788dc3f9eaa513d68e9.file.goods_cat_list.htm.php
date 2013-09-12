<?php /* Smarty version Smarty-3.1.14, created on 2013-09-11 16:56:39
         compiled from "D:\xampp\htdocs\cyarat\admin\templates\goods_cat_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:155495230a0c795b534-78193320%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8e1ded5e035e812187a72788dc3f9eaa513d68e9' => 
    array (
      0 => 'D:\\xampp\\htdocs\\cyarat\\admin\\templates\\goods_cat_list.htm',
      1 => 1271484762,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '155495230a0c795b534-78193320',
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
  'unifunc' => 'content_5230a0c79c4cd1_27015369',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5230a0c79c4cd1_27015369')) {function content_5230a0c79c4cd1_27015369($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("pageheader.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" src="templates/../../js/utils.js"></script>
<script type="text/javascript" src="templates/../js/listtable.js"></script>
<link href="templates/../../css/prettyPhoto/prettyPhoto.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/../../js/jquery.prettyPhoto.js"></script>
<form method="post" action="" name="listForm">
	<!-- start 資料 list -->
	<div class="list-div" id="listDiv">
		<table width="100%" cellspacing="1" cellpadding="2" id="list-table">
			<tr>
				<th><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_name'];?>
</th>
				<th width="50" ><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_is_show'];?>
</th>
				<th width="150" ><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_handler'];?>
</th>
			</tr>
			<?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_info']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value){
$_smarty_tpl->tpl_vars['cat']->_loop = true;
?>
			<tr align="center" class="<?php echo $_smarty_tpl->tpl_vars['cat']->value['depth'];?>
">
				<td align="left" class="first-cell" >
					<?php if ($_smarty_tpl->tpl_vars['cat']->value['img']){?>
						<span style="float:right"><a href="<?php echo $_smarty_tpl->tpl_vars['cat']->value['original_img'];?>
" rel="prettyPhoto"><img height="16" border="0" width="16" alt="<?php echo $_smarty_tpl->tpl_vars['cat']->value['name'];?>
" src="templates/images/picflag.gif"/></a></span>
					<?php }?>
					<?php if ($_smarty_tpl->tpl_vars['cat']->value['is_leaf']!=1){?>
						<img src="templates/images/menu_minus.gif" width="9" height="9" border="0" style="margin-left:<?php echo $_smarty_tpl->tpl_vars['cat']->value['depth'];?>
em" onclick="rowClicked(this)" />
					<?php }else{ ?>
						<img src="templates/images/menu_arrow.gif" width="9" height="9" border="0" style="margin-left:<?php echo $_smarty_tpl->tpl_vars['cat']->value['depth'];?>
em" />
					<?php }?>
					<span><?php echo $_smarty_tpl->tpl_vars['cat']->value['name'];?>
</span></td>
				<td><img src="templates/images/<?php if ($_smarty_tpl->tpl_vars['cat']->value['is_show']=='1'){?>yes<?php }else{ ?>no<?php }?>.gif" /></td>				
				<td>
					<a href="?act=edit&cat_id=<?php echo $_smarty_tpl->tpl_vars['cat']->value['id'];?>
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

<script language="JavaScript">
<!--
	$(document).ready(function(){
		$("a[rel^='prettyPhoto']").prettyPhoto({theme:'dark_rounded'});
	});
//-->
</script>

<?php echo $_smarty_tpl->getSubTemplate ("pagefooter.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>