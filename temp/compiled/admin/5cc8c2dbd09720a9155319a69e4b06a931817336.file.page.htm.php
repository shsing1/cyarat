<?php /* Smarty version Smarty-3.1.14, created on 2013-09-23 15:52:34
         compiled from "D:\xampp\htdocs\cyarat\admin\templates\page.htm" */ ?>
<?php /*%%SmartyHeaderCode:2078524063c23900e7-99846949%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5cc8c2dbd09720a9155319a69e4b06a931817336' => 
    array (
      0 => 'D:\\xampp\\htdocs\\cyarat\\admin\\templates\\page.htm',
      1 => 1259490410,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2078524063c23900e7-99846949',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'filter' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_524063c23bb079_47698512',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_524063c23bb079_47698512')) {function content_524063c23bb079_47698512($_smarty_tpl) {?><!-- start 頁碼 -->
<div id="turn-page"> <?php echo $_smarty_tpl->tpl_vars['lang']->value['total_records'];?>
 <span id="totalRecords"><?php echo $_smarty_tpl->tpl_vars['filter']->value['record_count'];?>
</span> <?php echo $_smarty_tpl->tpl_vars['lang']->value['total_pages'];?>
 <span id="totalPages"><?php echo $_smarty_tpl->tpl_vars['filter']->value['page_count'];?>
</span> <?php echo $_smarty_tpl->tpl_vars['lang']->value['page_current'];?>
 <span id="pageCurrent"><?php echo $_smarty_tpl->tpl_vars['filter']->value['page'];?>
</span> <?php echo $_smarty_tpl->tpl_vars['lang']->value['page_size'];?>

	<input type='text' size='3' id='pageSize' value="<?php echo $_smarty_tpl->tpl_vars['filter']->value['page_size'];?>
" onkeypress="return listTable.changePageSize(event)" />
	<span id="page-link"> <a href="javascript:listTable.gotoPageFirst()"><?php echo $_smarty_tpl->tpl_vars['lang']->value['page_first'];?>
</a> <a href="javascript:listTable.gotoPagePrev()"><?php echo $_smarty_tpl->tpl_vars['lang']->value['page_prev'];?>
</a> <a href="javascript:listTable.gotoPageNext()"><?php echo $_smarty_tpl->tpl_vars['lang']->value['page_next'];?>
</a> <a href="javascript:listTable.gotoPageLast()"><?php echo $_smarty_tpl->tpl_vars['lang']->value['page_last'];?>
</a>
	<select id="gotoPage" onchange="listTable.gotoPage(this.value)">
			<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['foo'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['name'] = 'foo';
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['filter']->value['page_count']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['foo']['total']);
?>
			<option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['foo']['index'];?>
" <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['foo']['index']==$_smarty_tpl->tpl_vars['filter']->value['page']){?>selected<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['foo']['index'];?>
</option>
			<?php endfor; endif; ?>
	</select>
	</span> 
</div>
<!-- end 頁碼 --><?php }} ?>