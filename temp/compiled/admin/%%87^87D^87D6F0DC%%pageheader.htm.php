<?php /* Smarty version 2.6.26, created on 2012-05-05 10:02:08
         compiled from pageheader.htm */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->_tpl_vars['lang']['cp_home']; ?>
<?php if ($this->_tpl_vars['ur_here']): ?> - <?php echo $this->_tpl_vars['ur_here']; ?>
 <?php endif; ?></title>
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
<?php $_from = $this->_tpl_vars['lang']['js_languages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
var <?php echo $this->_tpl_vars['key']; ?>
 = "<?php echo $this->_tpl_vars['item']; ?>
";
<?php endforeach; endif; unset($_from); ?>

//-->
</script>
</head>
<body>
<h1> <?php if ($this->_tpl_vars['action_link']): ?> <span class="action-span"><a href="<?php echo $this->_tpl_vars['action_link']['href']; ?>
"><?php echo $this->_tpl_vars['action_link']['text']; ?>
</a></span> <?php endif; ?>
	<?php if ($this->_tpl_vars['action_link2']): ?> <span class="action-span"><a href="<?php echo $this->_tpl_vars['action_link2']['href']; ?>
"><?php echo $this->_tpl_vars['action_link2']['text']; ?>
</a>&nbsp;&nbsp;</span> <?php endif; ?> <span class="action-span1"><a href="index.php?act=main"><?php echo $this->_tpl_vars['lang']['cp_home']; ?>
</a> </span><span id="search_id" class="action-span1"><?php if ($this->_tpl_vars['ur_here']): ?> - <?php echo $this->_tpl_vars['ur_here']; ?>
 <?php endif; ?></span>
	<div style="clear:both"></div>
</h1>