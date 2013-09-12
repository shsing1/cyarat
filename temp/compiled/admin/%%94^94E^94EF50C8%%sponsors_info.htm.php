<?php /* Smarty version 2.6.26, created on 2012-05-05 10:03:10
         compiled from sponsors_info.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'sponsors_info.htm', 67, false),array('modifier', 'default', 'sponsors_info.htm', 113, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pageheader.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- start data 表單 -->
<link href="templates/../../css/prettyPhoto/prettyPhoto.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templates/../../js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="templates/../../js/ajaxfileupload.js"></script>
<?php echo '
<script type="text/javascript">
	$(function() {
		$("#tabs").tabs();
	});
		
	/**
	* 刪除該資料圖片
	*/
	function drop_img(id)
	{
		jConfirm(drop_img_confirm, 
				 SYS_MSG, 
				 function(r){
					if(r){
						$.ajax({
							url: get_url(),
							data: {	act:\'drop_img\',
									id:id
								},
							success: function(r){
								if(r.error == 1){
									jAlert(r.message, SYS_MSG);
								}else{
									if(r.message){
										jAlert( r.message, 
												SYS_MSG, 
												function(){
													if(	r.url){
														location.href = r.url;
													}
												}
										);
									}
								}
							}
						});
					}
		});			
	}
	
</script>
'; ?>

<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span><?php echo $this->_tpl_vars['lang']['tab_general']; ?>
</span></a></li>
            </ul>
	
	<form action="" method="post" onsubmit="return do_ajax(this);">
    
	<div id="fragment-1">
        <table width="90%" align="center">
				
			<tr>
				<td class="label">網址:</td>
				<td><input type="text" name="link" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['data_info']['link'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" size="27" /><br/>
				ex:<span style="color:#F00">http://www.google.com.tw</span>
				</td>
			</tr>
            <tr>
				<td class="label">另開:</td>
				<td>
                	<input type="radio" name="is_target" value="1" <?php if ($this->_tpl_vars['data_info']['is_target'] != 0): ?> checked="true"<?php endif; ?>/>
					<?php echo $this->_tpl_vars['lang']['yes']; ?>

					<input type="radio" name="is_target" value="0" <?php if ($this->_tpl_vars['data_info']['is_target'] == 0): ?> checked="true"<?php endif; ?> />
					<?php echo $this->_tpl_vars['lang']['no']; ?>

				</td>
			</tr>	 
			<tr style="display:none;">
				<td class="label"><?php echo $this->_tpl_vars['lang']['lab_cat']; ?>
:</td>
				<td>
					<select name="cat_id">					
            			<?php echo $this->_tpl_vars['cat_select']; ?>
       
					</select>
				</td>
			</tr>			
			<tr style="display:none;">
				<td class="label"><?php echo $this->_tpl_vars['lang']['lab_meta_keywords']; ?>
:</td>
				<td><input type='text' name='meta_keywords' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['data_info']['meta_keywords'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
' size='27' /></td>
			</tr>
			<tr style="display:none;">
				<td class="label"><?php echo $this->_tpl_vars['lang']['lab_meta_description']; ?>
:</td>
				<td><input type='text' name='meta_description' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['data_info']['meta_description'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
' size='27' /></td>
			</tr>
			<tr style="display:none;">
				<td class="label"><?php echo $this->_tpl_vars['lang']['lab_brief']; ?>
:</td>
				<td><textarea name="brief" cols="50" rows="5"><?php echo ((is_array($_tmp=$this->_tpl_vars['data_info']['brief'])) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea></td>
			</tr>	
			<tr>
				<td class="label"><?php echo $this->_tpl_vars['lang']['lab_img']; ?>
:</td>
				<td><input type="file" name="img" id="img" />
					<!--<?php if ($this->_tpl_vars['data_info']['img']): ?>-->
						<a href="javascript:;" onclick="drop_img(<?php echo $this->_tpl_vars['data_info']['id']; ?>
)"><img src="templates/images/no.gif" alt="Delete" border="0" /></a>
						<a href="../../<?php echo $this->_tpl_vars['data_info']['original_img']; ?>
" rel="prettyPhoto" ><img src="templates/images/yes.gif" border="0" /></a>
					<!--<?php else: ?>-->
						<img src="templates/images/no.gif" alt="no" />
					<!--<?php endif; ?>-->
				</td>
			</tr>
			<tr>
				<td class="label"><?php echo $this->_tpl_vars['lang']['lab_sort']; ?>
:</td>
				<td><input type="text" name="sort" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['data_info']['sort'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
" size="5" /><?php echo $this->_tpl_vars['lang']['notice_sort']; ?>
</td>
			</tr>
			<tr>
				<td class="label"><?php echo $this->_tpl_vars['lang']['lab_is_show']; ?>
:</td>
				<td><input type="radio" name="is_show" value="1" <?php if ($this->_tpl_vars['data_info']['is_show'] != 0): ?> checked="true"<?php endif; ?>/>
					<?php echo $this->_tpl_vars['lang']['yes']; ?>

					<input type="radio" name="is_show" value="0" <?php if ($this->_tpl_vars['data_info']['is_show'] == 0): ?> checked="true"<?php endif; ?> />
					<?php echo $this->_tpl_vars['lang']['no']; ?>
 </td>
			</tr>
		</table>
    </div>
    	<div class="button-div">
		<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['data_info']['id']; ?>
" />
		<input type="submit" value="<?php echo $this->_tpl_vars['lang']['button_submit']; ?>
" class="button" />
		<input type="reset" value="<?php echo $this->_tpl_vars['lang']['button_reset']; ?>
" class="button" />
	</div>
	<input type="hidden" name="act" value="<?php echo $this->_tpl_vars['form_act']; ?>
" />
	</form>
</div>

<!-- end data 表單 -->

<!-- end data 表單 -->
<?php echo '
<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$("a[rel^=\'prettyPhoto\']").prettyPhoto({theme:\'dark_rounded\'});
	});
</script>
'; ?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pagefooter.htm", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 