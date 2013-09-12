<?php /* Smarty version Smarty-3.1.14, created on 2013-09-11 16:55:05
         compiled from "D:\xampp\htdocs\cyarat\admin\templates\config_set_info.htm" */ ?>
<?php /*%%SmartyHeaderCode:397252309f0cb3a808-07735897%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '25e1a92b6023c47a665ddc7faba0dfe50b62ccaa' => 
    array (
      0 => 'D:\\xampp\\htdocs\\cyarat\\admin\\templates\\config_set_info.htm',
      1 => 1378918500,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '397252309f0cb3a808-07735897',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_52309f0cc1d149_89510003',
  'variables' => 
  array (
    'cat_list' => 0,
    'cat' => 0,
    'data' => 0,
    'lang' => 0,
    'lang_list' => 0,
    'data_info' => 0,
    'form_act' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_52309f0cc1d149_89510003')) {function content_52309f0cc1d149_89510003($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_radios')) include 'D:\\xampp\\htdocs\\cyarat\\includes\\Smarty\\libs\\plugins\\function.html_radios.php';
if (!is_callable('smarty_function_html_options')) include 'D:\\xampp\\htdocs\\cyarat\\includes\\Smarty\\libs\\plugins\\function.html_options.php';
?><?php echo $_smarty_tpl->getSubTemplate ("pageheader.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<!-- start data 表單 -->
<link href="templates/../../css/prettyPhoto/prettyPhoto.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/../../js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="templates/../../js/ajaxfileupload.js"></script>
<!---->
<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});

	/**
	 * 測試郵件的發送
	 */
	function sendTestEmail(o)
	{
		var eles = o.elements;
		var smtp_host	= eles['data[37]'] . value;
		var smtp_port	= eles['data[38]'] . value;
		var smtp_user	= eles['data[39]'] . value;
		var smtp_pass	= eles['data[40]'] . value;
		var reply_email	= eles['data[41]'] . value;
		var test_email	= eles['test_mail_address'] . value;

		var mail_charset = 0;

		for (i = 0; i < eles['data[42]'] . length; i++)
		{
			if (eles['data[42]'][i] . checked)
			{
				mail_charset = eles['data[42]'][i] . value;
			}
		}

		var mail_service = 0;

		for (i = 0; i < eles['data[35]'] . length; i++)
		{
			if (eles['data[35]'][i] . checked)
			{
				mail_service = eles['data[35]'][i] . value;
			}
		}

		data = {
				act:'send_test_email',
				mail_service:mail_service,
				smtp_host:smtp_host,
				smtp_port:smtp_port,
				smtp_user:smtp_user,
				smtp_pass:smtp_pass,
				reply_email:reply_email,
				test_email:test_email,
				mail_charset:mail_charset
			};
		$.ajax({
		   	data: data
		});

	}

	/*  刪除檔案 */
	function del_file(id){
		$.ajax({
		   	data: {act:'del_file', id:id}
		});
	}
</script>
<!---->
<div id="tabs">
    <ul>
		<!--<?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cat_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value){
$_smarty_tpl->tpl_vars['cat']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['cat']->key;
?>-->
        <li><a href="#fragment-<?php echo $_smarty_tpl->tpl_vars['cat']->value['id'];?>
"><span><?php echo $_smarty_tpl->tpl_vars['cat']->value['name'];?>
</span></a></li>
		<!--<?php } ?>-->
    </ul>

	<form action="" method="post" onsubmit="return do_ajax(this);">
    <!--<?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cat_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value){
$_smarty_tpl->tpl_vars['cat']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['cat']->key;
?>-->
	<div id="fragment-<?php echo $_smarty_tpl->tpl_vars['cat']->value['id'];?>
">
        <table width="90%" align="center">
			<!--<?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cat']->value['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value){
$_smarty_tpl->tpl_vars['data']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['data']->key;
?>-->
			<tr>
				<td class="label"><?php echo $_smarty_tpl->tpl_vars['data']->value['name'];?>
:</td>
				<td>
					<!--<?php if ($_smarty_tpl->tpl_vars['data']->value['type']==0){?>-->
					<input type="text" name="data[<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
]" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
" size="40" />

					<!--<?php }elseif($_smarty_tpl->tpl_vars['data']->value['type']==6){?>-->
         			 <input name="data[<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
]" type="password" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
" size="40" />

          			<!--<?php }elseif($_smarty_tpl->tpl_vars['data']->value['type']==5){?>-->
          			<textarea name="data[<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
]" cols="40" rows="5"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['data']->value['value'], ENT_QUOTES, 'UTF-8', true);?>
</textarea>

					<!--<?php }elseif($_smarty_tpl->tpl_vars['data']->value['type']==4){?>-->
						<!--<?php $_smarty_tpl->tpl_vars['id'] = new Smarty_variable($_smarty_tpl->tpl_vars['data']->value['id'], null, 0);?>-->
						<?php echo smarty_function_html_radios(array('name'=>"data[".((string)$_smarty_tpl->tpl_vars['id']->value)."]",'options'=>$_smarty_tpl->tpl_vars['lang']->value[$_smarty_tpl->tpl_vars['data']->value['code']],'selected'=>$_smarty_tpl->tpl_vars['data']->value['value']),$_smarty_tpl);?>


					<!--<?php }elseif($_smarty_tpl->tpl_vars['data']->value['type']==7){?>-->
						<!--<?php $_smarty_tpl->tpl_vars['id'] = new Smarty_variable($_smarty_tpl->tpl_vars['data']->value['id'], null, 0);?>-->
						<?php echo smarty_function_html_options(array('name'=>"data[".((string)$_smarty_tpl->tpl_vars['id']->value)."]",'options'=>$_smarty_tpl->tpl_vars['lang']->value[$_smarty_tpl->tpl_vars['data']->value['code']],'selected'=>$_smarty_tpl->tpl_vars['data']->value['value']),$_smarty_tpl);?>

					<!--<?php }elseif($_smarty_tpl->tpl_vars['data']->value['type']==2){?>-->
				  		<input name="<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
" type="file" size="40" />
				  		<!--<?php if (($_smarty_tpl->tpl_vars['data']->value['code']=="no_picture"||$_smarty_tpl->tpl_vars['data']->value['code']=="watermark")&&$_smarty_tpl->tpl_vars['data']->value['value']){?>-->
							<a href="javascript:;" onclick="del_file(<?php echo $_smarty_tpl->tpl_vars['data']->value['id'];?>
)"><img src="templates/images/no.gif" alt="Delete" border="0" /></a>
							<a href="../../<?php echo $_smarty_tpl->tpl_vars['data']->value['value'];?>
" rel="prettyPhoto" ><img src="templates/images/yes.gif" border="0" /></a>
						<!--<?php }else{ ?>-->
							<!--<?php if ($_smarty_tpl->tpl_vars['data']->value['value']!=''){?>-->
								<img src="templates/images/yes.gif" alt="yes" />
							<!--<?php }else{ ?>-->
								<img src="templates/images/no.gif" alt="no" />
							<!--<?php }?>-->
				  		<!--<?php }?>-->
					<!--<?php }elseif($_smarty_tpl->tpl_vars['data']->value['type']==3){?>-->
						<!--<?php if ($_smarty_tpl->tpl_vars['data']->value['code']=="lang"){?>-->
							<!--<?php $_smarty_tpl->tpl_vars['id'] = new Smarty_variable($_smarty_tpl->tpl_vars['data']->value['id'], null, 0);?>-->
							<?php echo smarty_function_html_options(array('name'=>"data[".((string)$_smarty_tpl->tpl_vars['id']->value)."]",'options'=>$_smarty_tpl->tpl_vars['lang_list']->value,'selected'=>$_smarty_tpl->tpl_vars['data']->value['value']),$_smarty_tpl);?>

						<!--<?php }?>-->
					<!--<?php }?>-->
				</td>
			</tr>
			<!--<?php } ?>-->
			<!--<?php if ($_smarty_tpl->tpl_vars['cat']->value['id']==5){?>-->
			<tr>
				<td class="label"><?php echo $_smarty_tpl->tpl_vars['lang']->value['test_mail_address'];?>
:</td>
				<td>
					<input type="text" name="test_mail_address" size="30" />
       				<input type="button" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['send'];?>
" onclick="sendTestEmail(this.form);" class="button" />
				</td>
			<!--<?php }?>-->
		</table>
    </div>
	<!--<?php } ?>-->

	<div class="button-div">
		<input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['data_info']->value['id'];?>
" />
		<input type="submit" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['button_submit'];?>
" class="button" />
		<input type="reset" value="<?php echo $_smarty_tpl->tpl_vars['lang']->value['button_reset'];?>
" class="button" />
	</div>
	<input type="hidden" name="act" value="<?php echo $_smarty_tpl->tpl_vars['form_act']->value;?>
" />
	</form>
</div>

<!-- end data 表單 -->
<!---->
<script language="JavaScript">
<!--
	$(document).ready(function(){
		$("a[rel^='prettyPhoto']").prettyPhoto({theme:'dark_rounded'});
	});
//-->
</script>
<!---->

<?php echo $_smarty_tpl->getSubTemplate ("pagefooter.htm", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>