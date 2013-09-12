<?php /* Smarty version Smarty-3.1.14, created on 2013-09-11 16:43:21
         compiled from "D:\xampp\htdocs\cyarat\admin\templates\config_list.htm" */ ?>
<?php /*%%SmartyHeaderCode:2020452309da9b29af4-40109366%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a5c868a643723cbbdeea298e01e01d2b27c71a4f' => 
    array (
      0 => 'D:\\xampp\\htdocs\\cyarat\\admin\\templates\\config_list.htm',
      1 => 1260856188,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2020452309da9b29af4-40109366',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'full_page' => 0,
    'lang' => 0,
    'sort_id' => 0,
    'sort_name' => 0,
    'sort_codee' => 0,
    'sort_type' => 0,
    'sort_value' => 0,
    'sort_is_show' => 0,
    'sort_sort' => 0,
    'data_list' => 0,
    'data' => 0,
    'cat_list_all' => 0,
    'filter' => 0,
    'key' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52309da9bc5f22_33265430',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52309da9bc5f22_33265430')) {function content_52309da9bc5f22_33265430($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['full_page']->value){?>
<?php echo $_smarty_tpl->getSubTemplate ("pageheader.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" src="templates/../../js/utils.js"></script>
<script type="text/javascript" src="templates/../js/listtable.js"></script>
<!-- 資料搜索 -->
<?php echo $_smarty_tpl->getSubTemplate ("config_search.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<!-- 資料列表 -->
<form method="post" action="" id="listForm" name="listForm" onsubmit="return confirmSubmit(this)">
	<!-- start data list -->
	<div class="list-div" id="listDiv"> <?php }?>		
		<table cellpadding="3" cellspacing="1">
			<tr>
				<th width="50"> <input onclick='listTable.selectAll(this, "checkboxes")' type="checkbox" />
					<a href="javascript:listTable.sort('id'); "><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_id'];?>
</a><?php echo $_smarty_tpl->tpl_vars['sort_id']->value;?>
 </th>
				<th><a href="javascript:listTable.sort('name'); "><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_name'];?>
</a><?php echo $_smarty_tpl->tpl_vars['sort_name']->value;?>
</th>
				<th width="200"><a href="javascript:listTable.sort('code'); "><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_code'];?>
</a><?php echo $_smarty_tpl->tpl_vars['sort_codee']->value;?>
</th>
				<th width="100"><a href="javascript:listTable.sort('type'); "><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_type'];?>
</a><?php echo $_smarty_tpl->tpl_vars['sort_type']->value;?>
</th>
				<th width="200"><a href="javascript:listTable.sort('value'); "><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_value'];?>
</a><?php echo $_smarty_tpl->tpl_vars['sort_value']->value;?>
</th>
				<th width="50"><a href="javascript:listTable.sort('is_show'); "><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_is_show'];?>
</a><?php echo $_smarty_tpl->tpl_vars['sort_is_show']->value;?>
</th>
				<th width="50"><a href="javascript:listTable.sort('sort'); "><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_sort'];?>
</a><?php echo $_smarty_tpl->tpl_vars['sort_sort']->value;?>
</th>
				<th width="150"><?php echo $_smarty_tpl->tpl_vars['lang']->value['lab_handler'];?>
</th>
			<tr> <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value){
$_smarty_tpl->tpl_vars['data']->_loop = true;
?>
			<tr>
				<td><input type="checkbox" name="checkboxes[]" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
" />
					<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
</td>
				<td class="first-cell"><span ><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</span></td>
				<td align="center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['code'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				<td align="center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['fomat_type'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				<td align="center"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
</td>
				<td align="center"><img src="templates/images/<?php if ($_smarty_tpl->tpl_vars['data']->value['is_show']){?>yes<?php }else{ ?>no<?php }?>.gif" /></td>
				<td align="center"><span ><?php echo $_smarty_tpl->tpl_vars['data']->value['sort'];?>
</span></td>
				<td align="center">
					<a href="../config.php?id=<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
" target="_blank" title="<?php echo $_smarty_tpl->tpl_vars['lang']->value['view'];?>
"><img src="templates/images/icon_view.gif" width="16" height="16" border="0" /></a>
					<a href="?act=edit&id=<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['lang']->value['edit'];?>
"><img src="templates/images/icon_edit.gif" width="16" height="16" border="0" /></a>
					<a href="?act=copy&id=<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['lang']->value['copy'];?>
"><img src="templates/images/icon_copy.gif" width="16" height="16" border="0" /></a>
					<a href="javascript:;" onclick="remove(<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
)" title="<?php echo $_smarty_tpl->tpl_vars['lang']->value['remove'];?>
"><img src="templates/images/icon_drop.gif" width="16" height="16" border="0" /></a></td>
			</tr>
			<?php }
if (!$_smarty_tpl->tpl_vars['data']->_loop) {
?>
			<tr>
				<td class="no-records" colspan="13"><?php echo $_smarty_tpl->tpl_vars['lang']->value['no_records'];?>
</td>
			</tr>
			<?php } ?>
		</table>
		<!-- end data list -->
		<!-- 分頁 -->
		<table id="page-table" cellspacing="0">
			<tr>
				<td align="right" nowrap="true"> <?php echo $_smarty_tpl->getSubTemplate ("page.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
 </td>
			</tr>
		</table>
		<?php if ($_smarty_tpl->tpl_vars['full_page']->value){?> </div>
	<div>
		<input type="hidden" name="act" value="batch" />
		<select name="type" id="selAction" onchange="changeAction()">
			<option value=""><?php echo $_smarty_tpl->tpl_vars['lang']->value['select_please'];?>
</option>
			<option value="drop"><?php echo $_smarty_tpl->tpl_vars['lang']->value['drop'];?>
</option>
			<option value="enabled"><?php echo $_smarty_tpl->tpl_vars['lang']->value['enabled'];?>
</option>
			<option value="disabled"><?php echo $_smarty_tpl->tpl_vars['lang']->value['disabled'];?>
</option>
			<option value="move_to"><?php echo $_smarty_tpl->tpl_vars['lang']->value['move_to'];?>
</option>
		</select>
		<select name="target_cat" style="display:none">
			<option value="0"><?php echo $_smarty_tpl->tpl_vars['lang']->value['select_please'];?>
</option>
			<?php echo $_smarty_tpl->tpl_vars['cat_list_all']->value;?>
  
		</select>
		<input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['button_submit'];?>
" id="btnSubmit" name="btnSubmit" class="button" disabled="true" />
	</div>
</form>
<script type="text/javascript">	
	<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['filter']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
	listTable.filter.<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 = '<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
';
	<?php } ?>
	
	
	/**
	* @param: bool ext 其他條件：用於轉移分類
	*/
	function confirmSubmit(frm, ext)
	{
		var b = false;
		if (frm . elements['type'] . value == 'drop'){
			jConfirm(batch_drop_confirm, SYS_MSG, function(r){if(r) do_batch_ajax();});
		}else if (frm . elements['type'] . value == 'move_to'){
			ext = (ext == undefined) ? true:ext;
			b =  ext && frm . elements['target_cat'] . value != 0;
		}
		else if (frm . elements['type'] . value == ''){
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
		data += '&is_ajax=1';
		$.ajax({
			data: data
		});			
	}
	
	function changeAction()
	{
		var frm = document . forms['listForm'];
	
		// 切換分類列表的顯示
		frm . elements['target_cat'] . style . display = frm . elements['type'] . value ==
			'move_to' ? '':'none';
	
//		if (!document . getElementById('btnSubmit') . disabled && confirmSubmit(frm, false))
//		{
//			//frm . submit();
//			confirmSubmit(frm);
//		}
	}
	
</script>
<?php echo $_smarty_tpl->getSubTemplate ("pagefooter.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?><?php }} ?>