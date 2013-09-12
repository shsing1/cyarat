<?php /* Smarty version 2.6.26, created on 2012-05-05 10:02:08
         compiled from start.htm */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pageheader.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- directory install start -->
<ul id="lilist" style="padding:0; margin: 0; list-style-type:none; color: #CC0000;">
	<?php $_from = $this->_tpl_vars['warning_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['warning']):
?>
	<li style="border: 1px solid #CC0000; background: #FFFFCC; padding: 10px; margin-bottom: 5px;" ><?php echo $this->_tpl_vars['warning']; ?>
</li>
	<?php endforeach; endif; unset($_from); ?>
</ul>
<!-- directory install end -->
<br />
<!-- start system information -->
<div class="list-div">
	<table cellspacing='1' cellpadding='3'>
		<tr>
			<th colspan="4" class="group-title"><?php echo $this->_tpl_vars['lang']['system_info']; ?>
</th>
		</tr>
		<tr>
			<td width="20%"><?php echo $this->_tpl_vars['lang']['os']; ?>
</td>
			<td width="30%"><?php echo $this->_tpl_vars['sys_info']['os']; ?>
 (<?php echo $this->_tpl_vars['sys_info']['ip']; ?>
)</td>
			<td width="20%"><?php echo $this->_tpl_vars['lang']['web_server']; ?>
</td>
			<td width="30%"><?php echo $this->_tpl_vars['sys_info']['web_server']; ?>
</td>
		</tr>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['php_version']; ?>
</td>
			<td><?php echo $this->_tpl_vars['sys_info']['php_ver']; ?>
</td>
			<td><?php echo $this->_tpl_vars['lang']['mysql_version']; ?>
</td>
			<td><?php echo $this->_tpl_vars['sys_info']['mysql_ver']; ?>
</td>
		</tr>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['safe_mode']; ?>
</td>
			<td><?php echo $this->_tpl_vars['sys_info']['safe_mode']; ?>
</td>
			<td><?php echo $this->_tpl_vars['lang']['safe_mode_gid']; ?>
</td>
			<td><?php echo $this->_tpl_vars['sys_info']['safe_mode_gid']; ?>
</td>
		</tr>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['socket']; ?>
</td>
			<td><?php echo $this->_tpl_vars['sys_info']['socket']; ?>
</td>
			<td><?php echo $this->_tpl_vars['lang']['timezone']; ?>
</td>
			<td><?php echo $this->_tpl_vars['sys_info']['timezone']; ?>
</td>
		</tr>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['gd_version']; ?>
</td>
			<td><?php echo $this->_tpl_vars['sys_info']['gd']; ?>
</td>
			<td><?php echo $this->_tpl_vars['lang']['zlib']; ?>
</td>
			<td><?php echo $this->_tpl_vars['sys_info']['zlib']; ?>
</td>
		</tr>
		<tr>
			<td><?php echo $this->_tpl_vars['lang']['ec_charset']; ?>
</td>
			<td><?php echo $this->_tpl_vars['chh_charset']; ?>
</td>
			<td><?php echo $this->_tpl_vars['lang']['max_filesize']; ?>
</td>
			<td><?php echo $this->_tpl_vars['sys_info']['max_filesize']; ?>
</td>
		</tr>
	</table>
</div>
<!-- end system information -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagefooter.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 