<?php /* Smarty version 2.6.26, created on 2013-09-11 15:16:07
         compiled from news_cat_list.htm */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pageheader.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="templates/../../js/utils.js"></script>
<script type="text/javascript" src="templates/../js/listtable.js"></script>
<form method="post" action="" name="listForm">
	<!-- start 資料列表 -->
	<div class="list-div" id="listDiv">
		<table width="100%" cellspacing="1" cellpadding="2" id="list-table">
			<tr>
				<th><?php echo $this->_tpl_vars['lang']['lab_name']; ?>
</th>
				<th width="50" ><?php echo $this->_tpl_vars['lang']['lab_is_show']; ?>
</th>
				<th width="150" ><?php echo $this->_tpl_vars['lang']['lab_handler']; ?>
</th>
			</tr>
			<?php $_from = $this->_tpl_vars['cat_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cat']):
?>
			<tr align="center" class="<?php echo $this->_tpl_vars['cat']['depth']; ?>
">
				<td align="left" class="first-cell" > <?php if ($this->_tpl_vars['cat']['is_leaf'] != 1): ?> <img src="templates/images/menu_minus.gif" width="9" height="9" border="0" style="margin-left:<?php echo $this->_tpl_vars['cat']['depth']; ?>
em" onclick="rowClicked(this)" /> <?php else: ?> <img src="templates/images/menu_arrow.gif" width="9" height="9" border="0" style="margin-left:<?php echo $this->_tpl_vars['cat']['depth']; ?>
em" /> <?php endif; ?> <span><?php echo $this->_tpl_vars['cat']['name']; ?>
</span></td>
				<td><img src="templates/images/<?php if ($this->_tpl_vars['cat']['is_show'] == '1'): ?>yes<?php else: ?>no<?php endif; ?>.gif" /></td>				
				<td>
					<a href="?act=edit&cat_id=<?php echo $this->_tpl_vars['cat']['id']; ?>
"><img src="templates/images/icon_edit.gif" border="0" /></a>
					<a href="javascript:;" onclick="remove(<?php echo $this->_tpl_vars['cat']['id']; ?>
)" title="<?php echo $this->_tpl_vars['lang']['remove']; ?>
"><img src="templates/images/icon_drop.gif" border="0" /></a></td>
			</tr>
			<?php endforeach; else: ?>
			<tr>
				<td class="no-records" colspan="10"><?php echo $this->_tpl_vars['lang']['no_records']; ?>
</td>
			</tr>
			<?php endif; unset($_from); ?>
		</table>
	</div>
	<!-- end 資料列表 -->
</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagefooter.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>