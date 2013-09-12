<?php /* Smarty version 2.6.26, created on 2013-09-11 15:16:12
         compiled from news_search.htm */ ?>
<div class="form-div">
	<form action="javascript:searchGoods()" name="searchForm">
		<img src="templates/images/icon_search.gif" width="26" height="22" border="0" alt="SEARCH" />
		<!-- 分類 -->
		<select name="cat_id">
			<option value="0"><?php echo $this->_tpl_vars['lang']['all_cat']; ?>
</option>
			<?php echo $this->_tpl_vars['cat_list']; ?>

		</select>
		<!-- 關鍵字 -->
		<?php echo $this->_tpl_vars['lang']['keyword']; ?>

		<input type="text" name="keyword" size="15" value="<?php echo $this->_tpl_vars['serach_keyword']; ?>
" />
		<input type="submit" value="<?php echo $this->_tpl_vars['lang']['button_search']; ?>
" class="button" />
	</form>
</div>
<?php echo '
<script language="JavaScript">
    function searchGoods()
    {
'; ?>

        <?php if ($_GET['act'] != 'trash'): ?>
        listTable.filter['cat_id'] = document.forms['searchForm'].elements['cat_id'].value;
        <?php endif; ?>
<?php echo '
        listTable.filter[\'keyword\'] = Utils.trim(document.forms[\'searchForm\'].elements[\'keyword\'].value);
        listTable.filter[\'page\'] = 1;

        listTable.loadList();
    }
</script>
'; ?>