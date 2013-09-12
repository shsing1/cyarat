<?php /* Smarty version 2.6.26, created on 2012-05-05 10:02:08
         compiled from top.htm */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $this->_tpl_vars['app_name']; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="templates/styles/general.css" rel="stylesheet" type="text/css" />
<?php echo '
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
		window.top.frames[\'header-frame\'].document.location.reload();
		window.top.frames[\'menu-frame\'].document.location.reload();
		window.top.frames[\'main-frame\'].document.location.reload();				
	}
</script>
'; ?>

</head>
<body>
<div id="header-div">
	<div id="logo-div" style="bgcolor:#000000; color:#FFF; font-size:24px; font-weight:800;"><?php echo $this->_tpl_vars['lang']['cp_home']; ?>
</div>
	<div id="license-div" style="bgcolor:#000000;"></div>
	<div id="submenu-div">
		<ul>
			<li><a href="../" target="_blank"><?php echo $this->_tpl_vars['lang']['preview']; ?>
</a></li>
			<li style="border-left:none;"><a href="javascript:;" onclick="do_refresh();"><?php echo $this->_tpl_vars['lang']['refresh']; ?>
</a></li>
		</ul>
		<div id="send_info" style="padding: 5px 10px 0 0; clear:right;text-align: right; color: #FF9900;width:40%;float: right;"> <?php if ($this->_tpl_vars['send_mail_on'] == 'on'): ?> <span id="send_msg"><img src="templates/images/top_loader.gif" width="16" height="16" alt="<?php echo $this->_tpl_vars['lang']['loading']; ?>
" style="vertical-align: middle" /> <?php echo $this->_tpl_vars['lang']['email_sending']; ?>
</span> <a href="javascript:;" onClick="Javascript:switcher()" id="lnkSwitch" style="margin-right:10px;color: #FF9900;text-decoration: underline"><?php echo $this->_tpl_vars['lang']['pause']; ?>
</a> <?php endif; ?> <a href="index.php?act=clear_cache" target="main-frame" class="fix-submenu"><?php echo $this->_tpl_vars['lang']['clear_cache']; ?>
</a> <a href="privilege.php?act=logout" target="_top" class="fix-submenu"><?php echo $this->_tpl_vars['lang']['signout']; ?>
</a> </div>
		<?php if ($this->_tpl_vars['send_mail_on'] == 'on'): ?>
		<script type="text/javascript" charset="gb2312">
			var sm = window.setInterval("start_sendmail()", 5000);
			var finished = 0;
			var error = 0;
			var conti = "<?php echo $this->_tpl_vars['lang']['conti']; ?>
";
			var pause = "<?php echo $this->_tpl_vars['lang']['pause']; ?>
";
			var counter = 0;
			var str = "<?php echo $this->_tpl_vars['lang']['str']; ?>
";
			<?php echo '
			function start_sendmail()
			{
			  Ajax.call(\'index.php?is_ajax=1&act=send_mail\',\'\', start_sendmail_Response, \'GET\', \'JSON\');
			}
			function start_sendmail_Response(result)
			{
				if (typeof(result.count) == \'undefined\')
				{
					result.count = 0;
					result.message = \'\';
				}
				if (typeof(result.count) != \'undefined\' && result.count == 0)
				{
					counter --;
					document.getElementById(\'lnkSwitch\').style.display = "none";
					window.clearInterval(sm);
				}
		
				if( typeof(result.goon) != \'undefined\' )
				{
					start_sendmail();
				}
		
				counter ++ ;
		
				document.getElementById(\'send_msg\').innerHTML = result.message;
			}
			function switcher()
			{
				if(document.getElementById(\'lnkSwitch\').innerHTML == conti)
				{
					//do pause
					document.getElementById(\'lnkSwitch\').innerHTML = pause;
					sm = window.setInterval("start_sendmail()", 5000);
				}
				else
				{
					//do continue
					document.getElementById(\'lnkSwitch\').innerHTML = conti;
					document.getElementById(\'send_msg\').innerHTML = sprintf(str, counter);
					window.clearInterval(sm);
				}
			}
			'; ?>

		</script>
		<?php endif; ?>
		<div id="load-div" style="padding: 5px 10px 0 0; text-align: right; color: #FF9900; display: none;width:40%;float:right;"><img src="templates/images/top_loader.gif" width="16" height="16" alt="<?php echo $this->_tpl_vars['lang']['loading']; ?>
" style="vertical-align: middle" /> <?php echo $this->_tpl_vars['lang']['loading']; ?>
</div>
	</div>
</div>
<div id="menu-div">
	
	<br class="clear" />
</div>
</body>
</html>