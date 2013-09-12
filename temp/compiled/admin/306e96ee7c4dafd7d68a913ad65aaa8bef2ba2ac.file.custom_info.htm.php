<?php /* Smarty version Smarty-3.1.14, created on 2013-09-11 16:56:33
         compiled from "D:\xampp\htdocs\cyarat\admin\templates\custom_info.htm" */ ?>
<?php /*%%SmartyHeaderCode:71885230a0c151bfc0-21439578%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '306e96ee7c4dafd7d68a913ad65aaa8bef2ba2ac' => 
    array (
      0 => 'D:\\xampp\\htdocs\\cyarat\\admin\\templates\\custom_info.htm',
      1 => 1263179359,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '71885230a0c151bfc0-21439578',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'admin_cat_id' => 0,
    'lang' => 0,
    'data_info' => 0,
    'cat_select' => 0,
    'FCKeditor_desc' => 0,
    'form_act' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_5230a0c15b06f9_33752489',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5230a0c15b06f9_33752489')) {function content_5230a0c15b06f9_33752489($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("pageheader.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<!-- start data 表單 -->

<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
</script>

<div id="tabs">
    <ul>
		<!--<?php if ($_smarty_tpl->tpl_vars['admin_cat_id']->value==2){?>-->
        <li><a href="#fragment-1"><span><?php echo $_smarty_tpl->tpl_vars['lang']->value['tab_general'];?>
</span></a></li>
		<!--<?php }?>-->
        <li><a href="#fragment-2"><span><?php echo $_smarty_tpl->tpl_vars['lang']->value['tab_detail'];?>
</span></a></li>		
    </ul>
	
	<form action="" method="post" onsubmit="return do_ajax(this);">
    <!--<?php if ($_smarty_tpl->tpl_vars['admin_cat_id']->value==2){?>-->
	<div id="fragment-1">
        <table width="90%" align="center">
			<tr>
				<td class="label"><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_name'];?>
:</td>
				<td><input type="text" name="name" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data_info']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
" size="27" /><?php echo $_smarty_tpl->tpl_vars['lang']->value['require_field'];?>
</td>
			</tr>			 
			<tr>
				<td class="label"><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_cat'];?>
:</td>
				<td>
					<select name="cat_id">					
            			<?php echo $_smarty_tpl->tpl_vars['cat_select']->value;?>
       
					</select>
				</td>
			</tr>			
			<tr>
				<td class="label"><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_meta_keywords'];?>
:</td>
				<td><input type='text' name='meta_keywords' value='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data_info']->value['meta_keywords'], ENT_QUOTES, 'UTF-8', true);?>
' size='27' /></td>
			</tr>
			<tr>
				<td class="label"><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_meta_description'];?>
:</td>
				<td><input type='text' name='meta_description' value='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data_info']->value['meta_description'], ENT_QUOTES, 'UTF-8', true);?>
' size='27' /></td>
			</tr>
			<tr>
				<td class="label"><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_sort'];?>
:</td>
				<td><input type="text" name="sort" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['data_info']->value['sort'])===null||$tmp==='' ? 0 : $tmp);?>
" size="5" /><?php echo $_smarty_tpl->tpl_vars['lang']->value['notice_sort'];?>
</td>
			</tr>
			<tr>
				<td class="label"><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_is_show'];?>
:</td>
				<td><input type="radio" name="is_show" value="1" <?php if ($_smarty_tpl->tpl_vars['data_info']->value['is_show']!=0){?> checked="true"<?php }?>/>
					<?php echo $_smarty_tpl->tpl_vars['lang']->value['yes'];?>

					<input type="radio" name="is_show" value="0" <?php if ($_smarty_tpl->tpl_vars['data_info']->value['is_show']==0){?> checked="true"<?php }?> />
					<?php echo $_smarty_tpl->tpl_vars['lang']->value['no'];?>
 </td>
			</tr>
		</table>
    </div>
	<!--<?php }?>-->
    <div id="fragment-2">
        <table width="90%">
			<tr>
				<td><?php echo $_smarty_tpl->tpl_vars['FCKeditor_desc']->value;?>
</td>
			</tr>
		</table>
    </div>
	
	<div class="button-div">
		<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['data_info']->value['id'];?>
" />
		<input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['button_submit'];?>
" class="button" />
		<input type="reset" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['button_reset'];?>
" class="button" />
	</div>
	<input type="hidden" name="act" value="<?php echo $_smarty_tpl->tpl_vars['form_act']->value;?>
" />
	</form>
</div>

<!-- end data 表單 -->

<?php echo $_smarty_tpl->getSubTemplate ("pagefooter.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
 <?php }} ?>