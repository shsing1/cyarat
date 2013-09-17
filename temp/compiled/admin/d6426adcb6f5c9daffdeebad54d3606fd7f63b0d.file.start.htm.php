<?php /* Smarty version Smarty-3.1.14, created on 2013-09-17 08:58:35
         compiled from "D:\xampp\htdocs\cyarat\admin\templates\start.htm" */ ?>
<?php /*%%SmartyHeaderCode:5862523819bb363d31-37583690%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd6426adcb6f5c9daffdeebad54d3606fd7f63b0d' => 
    array (
      0 => 'D:\\xampp\\htdocs\\cyarat\\admin\\templates\\start.htm',
      1 => 1259553472,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5862523819bb363d31-37583690',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'warning_arr' => 0,
    'warning' => 0,
    'lang' => 0,
    'sys_info' => 0,
    'chh_charset' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_523819bb3d51d4_66837482',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_523819bb3d51d4_66837482')) {function content_523819bb3d51d4_66837482($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("pageheader.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<!-- directory install start -->
<ul id="lilist" style="padding:0; margin: 0; list-style-type:none; color: #CC0000;">
	<?php  $_smarty_tpl->tpl_vars['warning'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['warning']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['warning_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['warning']->key => $_smarty_tpl->tpl_vars['warning']->value){
$_smarty_tpl->tpl_vars['warning']->_loop = true;
?>
	<li style="border: 1px solid #CC0000; background: #FFFFCC; padding: 10px; margin-bottom: 5px;" ><?php echo $_smarty_tpl->tpl_vars['warning']->value;?>
</li>
	<?php } ?>
</ul>
<!-- directory install end -->
<br />
<!-- start system information -->
<div class="list-div">
	<table cellspacing='1' cellpadding='3'>
		<tr>
			<th colspan="4" class="group-title"><?php echo $_smarty_tpl->tpl_vars['lang']->value['system_info'];?>
</th>
		</tr>
		<tr>
			<td width="20%"><?php echo $_smarty_tpl->tpl_vars['lang']->value['os'];?>
</td>
			<td width="30%"><?php echo $_smarty_tpl->tpl_vars['sys_info']->value['os'];?>
 (<?php echo $_smarty_tpl->tpl_vars['sys_info']->value['ip'];?>
)</td>
			<td width="20%"><?php echo $_smarty_tpl->tpl_vars['lang']->value['web_server'];?>
</td>
			<td width="30%"><?php echo $_smarty_tpl->tpl_vars['sys_info']->value['web_server'];?>
</td>
		</tr>
		<tr>
			<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['php_version'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['sys_info']->value['php_ver'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['mysql_version'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['sys_info']->value['mysql_ver'];?>
</td>
		</tr>
		<tr>
			<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['safe_mode'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['sys_info']->value['safe_mode'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['safe_mode_gid'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['sys_info']->value['safe_mode_gid'];?>
</td>
		</tr>
		<tr>
			<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['socket'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['sys_info']->value['socket'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['timezone'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['sys_info']->value['timezone'];?>
</td>
		</tr>
		<tr>
			<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['gd_version'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['sys_info']->value['gd'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['zlib'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['sys_info']->value['zlib'];?>
</td>
		</tr>
		<tr>
			<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['ec_charset'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['chh_charset']->value;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['lang']->value['max_filesize'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['sys_info']->value['max_filesize'];?>
</td>
		</tr>
	</table>
</div>
<!-- end system information -->
<?php echo $_smarty_tpl->getSubTemplate ("pagefooter.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
 <?php }} ?>