<?php /* Smarty version 2.6.26, created on 2013-09-11 14:57:24
         compiled from login.htm */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->_tpl_vars['lang']['cp_home']; ?>
<?php if ($this->_tpl_vars['ur_here']): ?> - <?php echo $this->_tpl_vars['ur_here']; ?>
<?php endif; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="templates/styles/general.css" rel="stylesheet" type="text/css" />
<link href="templates/styles/main.css" rel="stylesheet" type="text/css" />
<link href="templates/../../css/alerts/jquery.alerts.css" rel="stylesheet" type="text/css" />
<?php echo '
<style type="text/css">
body {
	color: white;
}
</style>
'; ?>

<script type="text/javascript" src="templates/../../js/jquery.js"></script>
<script type="text/javascript" src="templates/../../js/jquery.ui.custom.js"></script>
<script type="text/javascript" src="templates/../../js/jquery.alerts.js"></script>
<script type="text/javascript" src="templates/../../js/jquery.chh.js"></script>
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
<?php echo '
//if (window.parent != window)
//{
//  window.top.location.href = location.href;
//}
'; ?>

//-->
</script>
</head>
<body style="background: #278296">
<form action="" method="post" onsubmit="return do_ajax(this)">
	<table cellspacing="0" cellpadding="0" style="margin-top: 100px" align="center">
		<tr>
			<td class="login"><?php echo $this->_tpl_vars['lang']['cp_home']; ?>
</td>
			<td style="padding-left: 50px"><table>
					<tr>
						<td><?php echo $this->_tpl_vars['lang']['label_username']; ?>
</td>
						<td><input type="text" name="username" /></td>
					</tr>
					<tr>
						<td><?php echo $this->_tpl_vars['lang']['label_password']; ?>
</td>
						<td><input type="password" name="password" /></td>
					</tr>
					<?php if ($this->_tpl_vars['gd_version'] > 0): ?>
					<tr>
						<td><?php echo $this->_tpl_vars['lang']['label_captcha']; ?>
</td>
						<td><input type="text" name="captcha" class="capital" /></td>
					</tr>
					<tr>
						<td colspan="2" align="right"><img src="templates/../captcha.php?act=captcha&<?php echo $this->_tpl_vars['random']; ?>
" alt="CAPTCHA" border="1" onclick= this.src="captcha.php?act=captcha&"+Math.random() style="cursor: pointer;" title="<?php echo $this->_tpl_vars['lang']['click_for_another']; ?>
" /></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td colspan="2"><input type="checkbox" value="1" name="remember" id="remember" />
							<label for="remember"><?php echo $this->_tpl_vars['lang']['remember']; ?>
</label></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="submit" value="<?php echo $this->_tpl_vars['lang']['signin_now']; ?>
" class="button" /></td>
					</tr>
					<tr>
						<td colspan="2" align="right">&raquo; <a href="../" style="color:white"><?php echo $this->_tpl_vars['lang']['back_home']; ?>
</a> &raquo; <a href="admin.php?act=forget_pwd" style="color:white"><?php echo $this->_tpl_vars['lang']['forget_pwd']; ?>
</a></td>
					</tr>
				</table></td>
		</tr>
	</table>
	<input type="hidden" name="act" value="signin" />
</form>
<script language="JavaScript">
<!--
	$("form input[name='username']").focus();
//-->
</script>
</body>
</html>