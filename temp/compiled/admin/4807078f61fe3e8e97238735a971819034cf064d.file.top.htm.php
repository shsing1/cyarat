<?php /* Smarty version Smarty-3.1.14, created on 2013-09-17 08:58:35
         compiled from "D:\xampp\htdocs\cyarat\admin\templates\top.htm" */ ?>
<?php /*%%SmartyHeaderCode:2494523819bb3310a5-25986006%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4807078f61fe3e8e97238735a971819034cf064d' => 
    array (
      0 => 'D:\\xampp\\htdocs\\cyarat\\admin\\templates\\top.htm',
      1 => 1259950672,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2494523819bb3310a5-25986006',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'app_name' => 0,
    'lang' => 0,
    'send_mail_on' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_523819bb386fc7_10399379',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_523819bb386fc7_10399379')) {function content_523819bb386fc7_10399379($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_smarty_tpl->tpl_vars['app_name']->value;?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="templates/styles/general.css" rel="stylesheet" type="text/css" />

<style type="text/css">
#header-div {
	background: #278296;
	border-bottom: 1px solid #FFF;
}
#logo-div {
	height: 50px;
	float: left;
}
#license-div {
	height: 50px;
	float: left;
	text-align:center;
	vertical-align:middle;
	line-height:50px;
}
#license-div a:visited, #license-div a:link {
	color: #EB8A3D;
}
#license-div a:hover {
	text-decoration: none;
	color: #EB8A3D;
}
#submenu-div {
	height: 50px;
}
#submenu-div ul {
	margin: 0;
	padding: 0;
	list-style-type: none;
}
#submenu-div li {
	float: right;
	padding: 0 10px;
	margin: 3px 0;
	border-left: 1px solid #FFF;
}
#submenu-div a:visited, #submenu-div a:link {
	color: #FFF;
	text-decoration: none;
}
#submenu-div a:hover {
	color: #F5C29A;
}
#loading-div {
	clear: right;
	text-align: right;
	display: block;
}
#menu-div {
	background: #80BDCB;
	font-weight: bold;
	height: 24px;
	line-height:24px;
}
#menu-div ul {
	margin: 0;
	padding: 0;
	list-style-type: none;
}
#menu-div li {
	float: left;
	border-right: 1px solid #192E32;
	border-left:1px solid #BBDDE5;
}
#menu-div a:visited, #menu-div a:link {
	display:block;
	padding: 0 20px;
	text-decoration: none;
	color: #335B64;
	background:#9CCBD6;
}
#menu-div a:hover {
	color: #000;
	background:#80BDCB;
}
#submenu-div a.fix-submenu {
	clear:both;
	margin-left:5px;
	padding:1px 5px;
*padding:3px 5px 5px;
	background:#DDEEF2;
	color:#278296;
}
#submenu-div a.fix-submenu:hover {
	padding:1px 5px;
*padding:3px 5px 5px;
	background:#FFF;
	color:#278296;
}
#menu-div li.fix-spacel {
	width:30px;
	border-left:none;
}
#menu-div li.fix-spacer {
	border-right:none;
}
</style>
<script type="text/javascript" charset="gb2312">
	function do_refresh(){
		window.top.frames['header-frame'].document.location.reload();
		window.top.frames['menu-frame'].document.location.reload();
		window.top.frames['main-frame'].document.location.reload();				
	}
</script>

</head>
<body>
<div id="header-div">
	<div id="logo-div" style="bgcolor:#000000; color:#FFF; font-size:24px; font-weight:800;"><?php echo $_smarty_tpl->tpl_vars['lang']->value['cp_home'];?>
</div>
	<div id="license-div" style="bgcolor:#000000;"></div>
	<div id="submenu-div">
		<ul>
			<li><a href="../" target="_blank"><?php echo $_smarty_tpl->tpl_vars['lang']->value['preview'];?>
</a></li>
			<li style="border-left:none;"><a href="javascript:;" onclick="do_refresh();"><?php echo $_smarty_tpl->tpl_vars['lang']->value['refresh'];?>
</a></li>
		</ul>
		<div id="send_info" style="padding: 5px 10px 0 0; clear:right;text-align: right; color: #FF9900;width:40%;float: right;"> <?php if ($_smarty_tpl->tpl_vars['send_mail_on']->value=='on'){?> <span id="send_msg"><img src="templates/images/top_loader.gif" width="16" height="16" alt="<?php echo $_smarty_tpl->tpl_vars['lang']->value['loading'];?>
" style="vertical-align: middle" /> <?php echo $_smarty_tpl->tpl_vars['lang']->value['email_sending'];?>
</span> <a href="javascript:;" onClick="Javascript:switcher()" id="lnkSwitch" style="margin-right:10px;color: #FF9900;text-decoration: underline"><?php echo $_smarty_tpl->tpl_vars['lang']->value['pause'];?>
</a> <?php }?> <a href="index.php?act=clear_cache" target="main-frame" class="fix-submenu"><?php echo $_smarty_tpl->tpl_vars['lang']->value['clear_cache'];?>
</a> <a href="privilege.php?act=logout" target="_top" class="fix-submenu"><?php echo $_smarty_tpl->tpl_vars['lang']->value['signout'];?>
</a> </div>
		<?php if ($_smarty_tpl->tpl_vars['send_mail_on']->value=='on'){?>
		<script type="text/javascript" charset="gb2312">
			var sm = window.setInterval("start_sendmail()", 5000);
			var finished = 0;
			var error = 0;
			var conti = "<?php echo $_smarty_tpl->tpl_vars['lang']->value['conti'];?>
";
			var pause = "<?php echo $_smarty_tpl->tpl_vars['lang']->value['pause'];?>
";
			var counter = 0;
			var str = "<?php echo $_smarty_tpl->tpl_vars['lang']->value['str'];?>
";
			
			function start_sendmail()
			{
			  Ajax.call('index.php?is_ajax=1&act=send_mail','', start_sendmail_Response, 'GET', 'JSON');
			}
			function start_sendmail_Response(result)
			{
				if (typeof(result.count) == 'undefined')
				{
					result.count = 0;
					result.message = '';
				}
				if (typeof(result.count) != 'undefined' && result.count == 0)
				{
					counter --;
					document.getElementById('lnkSwitch').style.display = "none";
					window.clearInterval(sm);
				}
		
				if( typeof(result.goon) != 'undefined' )
				{
					start_sendmail();
				}
		
				counter ++ ;
		
				document.getElementById('send_msg').innerHTML = result.message;
			}
			function switcher()
			{
				if(document.getElementById('lnkSwitch').innerHTML == conti)
				{
					//do pause
					document.getElementById('lnkSwitch').innerHTML = pause;
					sm = window.setInterval("start_sendmail()", 5000);
				}
				else
				{
					//do continue
					document.getElementById('lnkSwitch').innerHTML = conti;
					document.getElementById('send_msg').innerHTML = sprintf(str, counter);
					window.clearInterval(sm);
				}
			}
			
		</script>
		<?php }?>
		<div id="load-div" style="padding: 5px 10px 0 0; text-align: right; color: #FF9900; display: none;width:40%;float:right;"><img src="templates/images/top_loader.gif" width="16" height="16" alt="<?php echo $_smarty_tpl->tpl_vars['lang']->value['loading'];?>
" style="vertical-align: middle" /> <?php echo $_smarty_tpl->tpl_vars['lang']->value['loading'];?>
</div>
	</div>
</div>
<div id="menu-div">
	
	<br class="clear" />
</div>
</body>
</html><?php }} ?>