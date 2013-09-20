<?php /* Smarty version Smarty-3.1.14, created on 2013-09-20 07:39:15
         compiled from "D:\xampp\htdocs\cyarat\admin\templates\pagefooter.htm" */ ?>
<?php /*%%SmartyHeaderCode:26912523bfba33d52c9-03629418%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3ba6d8dfebca1ea1954206fd7b3a40f30e5257c6' => 
    array (
      0 => 'D:\\xampp\\htdocs\\cyarat\\admin\\templates\\pagefooter.htm',
      1 => 1259829511,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26912523bfba33d52c9-03629418',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'query_info' => 0,
    'gzip_enabled' => 0,
    'memory_info' => 0,
    'lang' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_523bfba33dcfc6_63029589',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_523bfba33dcfc6_63029589')) {function content_523bfba33dcfc6_63029589($_smarty_tpl) {?><div id="footer"> <?php echo $_smarty_tpl->tpl_vars['query_info']->value;?>
<?php echo $_smarty_tpl->tpl_vars['gzip_enabled']->value;?>
<?php echo $_smarty_tpl->tpl_vars['memory_info']->value;?>
<br />
	<?php echo $_smarty_tpl->tpl_vars['lang']->value['copyright'];?>
 </div>

<script language="JavaScript">

	if(document.getElementById("listDiv")){
		
		/* 表格選取效果 */
		var listDiv = $('#listDiv');
		listDiv.mouseover(function(){
			TR = $('#listDiv TR');
			TR.mouseover(function(){
				$("TD", this).css('background','#deedf0');
			}).mouseout(function(){
				$("TD", this).css('background','#FFFFFF');
			});
		});
		
		document . getElementById("listDiv") . onclick = function (e)
		{
			var obj = Utils . srcElement(e);
		
			if (obj . tagName == "INPUT" && obj . type == "checkbox")
			{
				if (!document . forms['listForm'])
				{
					return;
				}
				var nodes = document . forms['listForm'] . elements;
				var checked = false;
		
				for (i = 0; i < nodes . length; i++)
				{
					if (nodes[i] . checked)
					{
						checked = true;
						break;
					}
				}
		
				if (document . getElementById("btnSubmit"))
				{
					document . getElementById("btnSubmit") . disabled = !checked;
				}
				for (i = 1; i <= 10; i++)
				{
					if (document . getElementById("btnSubmit" + i))
					{
						document . getElementById("btnSubmit" + i) . disabled = !checked;
					}
				}
			}
		}
	}
</script>

</body>
</html><?php }} ?>