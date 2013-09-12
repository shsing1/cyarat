<?php /* Smarty version Smarty-3.1.14, created on 2013-09-11 16:32:53
         compiled from "D:\xampp\htdocs\cyarat\admin\templates\pageheader.htm" */ ?>
<?php /*%%SmartyHeaderCode:2236652309b359baca4-89852343%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '57f23c70cb851418b281a25312ad7cbe036bcdab' => 
    array (
      0 => 'D:\\xampp\\htdocs\\cyarat\\admin\\templates\\pageheader.htm',
      1 => 1302530452,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2236652309b359baca4-89852343',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'ur_here' => 0,
    'key' => 0,
    'item' => 0,
    'action_link' => 0,
    'action_link2' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52309b359ddf30_25371920',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52309b359ddf30_25371920')) {function content_52309b359ddf30_25371920($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_smarty_tpl->tpl_vars['lang']->value['cp_home'];?>
<?php if ($_smarty_tpl->tpl_vars['ur_here']->value){?> - <?php echo $_smarty_tpl->tpl_vars['ur_here']->value;?>
 <?php }?></title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="templates/styles/general.css" rel="stylesheet" type="text/css" />
<link href="templates/styles/main.css" rel="stylesheet" type="text/css" />
<link href="templates/../../css/alerts/jquery.alerts.css" rel="stylesheet" type="text/css" />
<link href="templates/../../css/redmond/jquery-ui-1.8.2.custom.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="templates/../../js/jquery.js"></script>
<script type="text/javascript" src="templates/../../js/jquery.ui.custom.js"></script>
<script type="text/javascript" src="templates/../../js/jquery.alerts.js"></script>
<script type="text/javascript" src="templates/../../js/jquery.chh.js"></script>
<script type="text/javascript" src="templates/../../js/jquery.prettyPhoto.js"></script>

<script language="JavaScript">
<!--
// 這裡把JS用到的所有語言都賦值到這裡
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['lang']->value['js_languages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
var <?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 = "<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
";
<?php } ?>

//-->
</script>
</head>
<body>
<h1> <?php if ($_smarty_tpl->tpl_vars['action_link']->value){?> <span class="action-span"><a href="<?php echo $_smarty_tpl->tpl_vars['action_link']->value['href'];?>
"><?php echo $_smarty_tpl->tpl_vars['action_link']->value['text'];?>
</a></span> <?php }?>
	<?php if ($_smarty_tpl->tpl_vars['action_link2']->value){?> <span class="action-span"><a href="<?php echo $_smarty_tpl->tpl_vars['action_link2']->value['href'];?>
"><?php echo $_smarty_tpl->tpl_vars['action_link2']->value['text'];?>
</a>&nbsp;&nbsp;</span> <?php }?> <span class="action-span1"><a href="index.php?act=main"><?php echo $_smarty_tpl->tpl_vars['lang']->value['cp_home'];?>
</a> </span><span id="search_id" class="action-span1"><?php if ($_smarty_tpl->tpl_vars['ur_here']->value){?> - <?php echo $_smarty_tpl->tpl_vars['ur_here']->value;?>
 <?php }?></span>
	<div style="clear:both"></div>
</h1><?php }} ?>