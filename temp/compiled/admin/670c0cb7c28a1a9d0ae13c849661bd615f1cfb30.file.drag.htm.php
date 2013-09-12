<?php /* Smarty version Smarty-3.1.14, created on 2013-09-11 16:32:53
         compiled from "D:\xampp\htdocs\cyarat\admin\templates\drag.htm" */ ?>
<?php /*%%SmartyHeaderCode:2335852309b35922701-03057826%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '670c0cb7c28a1a9d0ae13c849661bd615f1cfb30' => 
    array (
      0 => 'D:\\xampp\\htdocs\\cyarat\\admin\\templates\\drag.htm',
      1 => 1257564863,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2335852309b35922701-03057826',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52309b35959212_35060292',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52309b35959212_35060292')) {function content_52309b35959212_35060292($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!-- $Id: drag.htm 14216 2008-03-10 02:27:21Z testyang $ -->
<html>
<head>
<title></title>

<style type="text/css">
body {
	margin: 0;
	padding: 0;
	background: #80BDCB;
	cursor: E-resize;
}
</style>
<script type="text/javascript" language="JavaScript">
<!--
var pic = new Image();
pic.src="templates/images/arrow_right.gif";

function toggleMenu()
{
  frmBody = parent.document.getElementById('frame-body');
  imgArrow = document.getElementById('img');

  if (frmBody.cols == "0, 10, *")
  {
    frmBody.cols="200, 10, *";
    imgArrow.src = "templates/images/arrow_left.gif";
  }
  else
  {
    frmBody.cols="0, 10, *";
    imgArrow.src = "templates/images/arrow_right.gif";
  }
}

var orgX = 0;
document.onmousedown = function(e)
{
  var evt = Utils.fixEvent(e);
  orgX = evt.clientX;

  if (Browser.isIE) document.getElementById('tbl').setCapture();
}

document.onmouseup = function(e)
{
  var evt = Utils.fixEvent(e);

  frmBody = parent.document.getElementById('frame-body');
  frmWidth = frmBody.cols.substr(0, frmBody.cols.indexOf(','));
  frmWidth = (parseInt(frmWidth) + (evt.clientX - orgX));

  frmBody.cols = frmWidth + ", 10, *";

  if (Browser.isIE) document.releaseCapture();
}

var Browser = new Object();

Browser.isMozilla = (typeof document.implementation != 'undefined') && (typeof document.implementation.createDocument != 'undefined') && (typeof HTMLDocument != 'undefined');
Browser.isIE = window.ActiveXObject ? true : false;
Browser.isFirefox = (navigator.userAgent.toLowerCase().indexOf("firefox") != - 1);
Browser.isSafari = (navigator.userAgent.toLowerCase().indexOf("safari") != - 1);
Browser.isOpera = (navigator.userAgent.toLowerCase().indexOf("opera") != - 1);

var Utils = new Object();

Utils.fixEvent = function(e)
{
  var evt = (typeof e == "undefined") ? window.event : e;
  return evt;
}
//-->
</script>

</head>
<body onselect="return false;">
<table height="100%" cellspacing="0" cellpadding="0" id="tbl">
	<tr>
		<td><a href="javascript:toggleMenu();"><img src="templates/images/arrow_left.gif" width="10" height="30" id="img" border="0" /></a></td>
	</tr>
</table>
</body>
</html><?php }} ?>