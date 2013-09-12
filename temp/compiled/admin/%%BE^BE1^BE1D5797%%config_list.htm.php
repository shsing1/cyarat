<?php /* Smarty version 2.6.26, created on 2013-09-11 15:25:06
         compiled from config_list.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'config_list.htm', 26, false),)), $this); ?>
<?php if ($this->_tpl_vars['full_page']): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pageheader.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="templates/../../js/utils.js"></script>
<script type="text/javascript" src="templates/../js/listtable.js"></script>
<!-- 資料搜索 -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "config_search.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- 資料列表 -->
<form method="post" action="" id="listForm" name="listForm" onsubmit="return confirmSubmit(this)">
	<!-- start data list -->
	<div class="list-div" id="listDiv"> <?php endif; ?>		
		<table cellpadding="3" cellspacing="1">
			<tr>
				<th width="50"> <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" />
					<a href="javascript:listTable.sort('id'); "><?php echo $this->_tpl_vars['lang']['lab_id']; ?>
</a><?php echo $this->_tpl_vars['sort_id']; ?>
 </th>
				<th><a href="javascript:listTable.sort('name'); "><?php echo $this->_tpl_vars['lang']['lab_name']; ?>
</a><?php echo $this->_tpl_vars['sort_name']; ?>
</th>
				<th width="200"><a href="javascript:listTable.sort('code'); "><?php echo $this->_tpl_vars['lang']['lab_code']; ?>
</a><?php echo $this->_tpl_vars['sort_codee']; ?>
</th>
				<th width="100"><a href="javascript:listTable.sort('type'); "><?php echo $this->_tpl_vars['lang']['lab_type']; ?>
</a><?php echo $this->_tpl_vars['sort_type']; ?>
</th>
				<th width="200"><a href="javascript:listTable.sort('value'); "><?php echo $this->_tpl_vars['lang']['lab_value']; ?>
</a><?php echo $this->_tpl_vars['sort_value']; ?>
</th>
				<th width="50"><a href="javascript:listTable.sort('is_show'); "><?php echo $this->_tpl_vars['lang']['lab_is_show']; ?>
</a><?php echo $this->_tpl_vars['sort_is_show']; ?>
</th>
				<th width="50"><a href="javascript:listTable.sort('sort'); "><?php echo $this->_tpl_vars['lang']['lab_sort']; ?>
</a><?php echo $this->_tpl_vars['sort_sort']; ?>
</th>
				<th width="150"><?php echo $this->_tpl_vars['lang']['lab_handler']; ?>
</th>
			<tr> <?php $_from = $this->_tpl_vars['data_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['data']):
?>
			<tr>
				<td><input type="checkbox" name="checkboxes[]" value="<?php echo $this->_tpl_vars['data']['id']; ?>
" />
					<?php echo $this->_tpl_vars['data']['id']; ?>
</td>
				<td class="first-cell"><span ><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['name'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</span></td>
				<td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['code'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</td>
				<td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['fomat_type'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</td>
				<td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['value'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</td>
				<td align="center"><img src="templates/images/<?php if ($this->_tpl_vars['data']['is_show']): ?>yes<?php else: ?>no<?php endif; ?>.gif" /></td>
				<td align="center"><span ><?php echo $this->_tpl_vars['data']['sort']; ?>
</span></td>
				<td align="center">
					<a href="../config.php?id=<?php echo $this->_tpl_vars['data']['id']; ?>
" target="_blank" title="<?php echo $this->_tpl_vars['lang']['view']; ?>
"><img src="templates/images/icon_view.gif" width="16" height="16" border="0" /></a>
					<a href="?act=edit&id=<?php echo $this->_tpl_vars['data']['id']; ?>
" title="<?php echo $this->_tpl_vars['lang']['edit']; ?>
"><img src="templates/images/icon_edit.gif" width="16" height="16" border="0" /></a>
					<a href="?act=copy&id=<?php echo $this->_tpl_vars['data']['id']; ?>
" title="<?php echo $this->_tpl_vars['lang']['copy']; ?>
"><img src="templates/images/icon_copy.gif" width="16" height="16" border="0" /></a>
					<a href="javascript:;" onclick="remove(<?php echo $this->_tpl_vars['data']['id']; ?>
)" title="<?php echo $this->_tpl_vars['lang']['remove']; ?>
"><img src="templates/images/icon_drop.gif" width="16" height="16" border="0" /></a></td>
			</tr>
			<?php endforeach; else: ?>
			<tr>
				<td class="no-records" colspan="13"><?php echo $this->_tpl_vars['lang']['no_records']; ?>
</td>
			</tr>
			<?php endif; unset($_from); ?>
		</table>
		<!-- end data list -->
		<!-- 分頁 -->
		<table id="page-table" cellspacing="0">
			<tr>
				<td align="right" nowrap="true"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "page.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </td>
			</tr>
		</table>
		<?php if ($this->_tpl_vars['full_page']): ?> </div>
	<div>
		<input type="hidden" name="act" value="batch" />
		<select name="type" id="selAction" onchange="changeAction()">
			<option value=""><?php echo $this->_tpl_vars['lang']['select_please']; ?>
</option>
			<option value="drop"><?php echo $this->_tpl_vars['lang']['drop']; ?>
</option>
			<option value="enabled"><?php echo $this->_tpl_vars['lang']['enabled']; ?>
</option>
			<option value="disabled"><?php echo $this->_tpl_vars['lang']['disabled']; ?>
</option>
			<option value="move_to"><?php echo $this->_tpl_vars['lang']['move_to']; ?>
</option>
		</select>
		<select name="target_cat" style="display:none">
			<option value="0"><?php echo $this->_tpl_vars['lang']['select_please']; ?>
</option>
			<?php echo $this->_tpl_vars['cat_list_all']; ?>
  
		</select>
		<input type="submit" value="<?php echo $this->_tpl_vars['lang']['button_submit']; ?>
" id="btnSubmit" name="btnSubmit" class="button" disabled="true" />
	</div>
</form>
<script type="text/javascript">	
	<?php $_from = $this->_tpl_vars['filter']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
	listTable.filter.<?php echo $this->_tpl_vars['key']; ?>
 = '<?php echo $this->_tpl_vars['item']; ?>
';
	<?php endforeach; endif; unset($_from); ?>
	
	<?php echo '
	/**
	* @param: bool ext 其他條件：用於轉移分類
	*/
	function confirmSubmit(frm, ext)
	{
		var b = false;
		if (frm . elements[\'type\'] . value == \'drop\'){
			jConfirm(batch_drop_confirm, SYS_MSG, function(r){if(r) do_batch_ajax();});
		}else if (frm . elements[\'type\'] . value == \'move_to\'){
			ext = (ext == undefined) ? true:ext;
			b =  ext && frm . elements[\'target_cat\'] . value != 0;
		}
		else if (frm . elements[\'type\'] . value == \'\'){
			b =  false;
		}else{
			b = true;
		}
		if(b){
			do_batch_ajax();
		}
		return false;
	}
	
	function do_batch_ajax(){
		var data = $("#listForm").serialize();
		data += \'&is_ajax=1\';
		$.ajax({
			data: data
		});			
	}
	
	function changeAction()
	{
		var frm = document . forms[\'listForm\'];
	
		// 切換分類列表的顯示
		frm . elements[\'target_cat\'] . style . display = frm . elements[\'type\'] . value ==
			\'move_to\' ? \'\':\'none\';
	
//		if (!document . getElementById(\'btnSubmit\') . disabled && confirmSubmit(frm, false))
//		{
//			//frm . submit();
//			confirmSubmit(frm);
//		}
	}
	'; ?>

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagefooter.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>