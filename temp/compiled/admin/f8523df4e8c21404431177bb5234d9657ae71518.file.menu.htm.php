<?php /* Smarty version Smarty-3.1.14, created on 2013-09-17 08:58:35
         compiled from "D:\xampp\htdocs\cyarat\admin\templates\menu.htm" */ ?>
<?php /*%%SmartyHeaderCode:9511523819bb3581b4-09561560%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f8523df4e8c21404431177bb5234d9657ae71518' => 
    array (
      0 => 'D:\\xampp\\htdocs\\cyarat\\admin\\templates\\menu.htm',
      1 => 1260018440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9511523819bb3581b4-09561560',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'menus' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_523819bb383146_46082176',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_523819bb383146_46082176')) {function content_523819bb383146_46082176($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>CHH Menu</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="templates/styles/general.css" rel="stylesheet" type="text/css" />
<link href="templates/styles/jquery.treeview.css" rel="stylesheet" />
<script type="text/javascript" src="templates/../../js/jquery.js"></script>
<script type="text/javascript" src="templates/../../js/jquery.cookie.js"></script>
<script type="text/javascript" src="templates/../../js/jquery.treeview.js"></script>


<script language="JavaScript">
<!--
var noHelp   = "<p align='center' style='color: #666'>{$lang.no_help}</p>";
var helpLang = "{$help_lang}";
//-->
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#browser").treeview({
			persist: "cookie",
			control: "#tabbar-div",
			toggle: function() {
//				console.log("%s was toggled.", $(this).find(">span").text());
			}
		});
	});
</script>


<style type="text/css">
body {
	background: #80BDCB;
}
#tabbar-div {
	background: #278296;
	padding-left: 10px;
	height: 21px;
	padding-top: 0px;
}
#tabbar-div p {
	margin: 1px 0 0 0;
}
.tab-front {
	background: #80BDCB;
	line-height: 20px;
	font-weight: bold;
	padding: 4px 15px 5px 18px;
	border-right: 2px solid #335b64;
	cursor: hand;
	cursor: pointer;
}
.tab-back {
	color: #F4FAFB;
	line-height: 20px;
	padding: 4px 15px 4px 18px;
	cursor: hand;
	cursor: pointer;
}
.tab-hover {
	color: #F4FAFB;
	line-height: 20px;
	padding: 4px 15px 4px 18px;
	cursor: hand;
	cursor: pointer;
	background: #2F9DB5;
}
#top-div {
	padding: 3px 0 2px;
	background: #BBDDE5;
	margin: 5px;
	text-align: center;
}
#main-div {
	border: 1px solid #345C65;
	padding: 5px;
	margin: 5px;
	background: #FFF;
}
#menu-list {
	padding: 0;
	margin: 0;
}
</style>

</head>
<body>
<div id="tabbar-div">
	<p><span class="tab-front" id="menu-tab"><?php echo $_smarty_tpl->tpl_vars['lang']->value['menu'];?>
</span> </p>
</div>
<div id="main-div">
	<div id="menu-list">
		<?php echo $_smarty_tpl->tpl_vars['menus']->value;?>


	</div>
	<div id="help-div" style="display:none">
		<h1 id="help-title"></h1>
		<div id="help-content"></div>
	</div>
</div>


</body>
</html><?php }} ?>