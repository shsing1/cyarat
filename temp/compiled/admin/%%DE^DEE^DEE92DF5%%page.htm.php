<?php /* Smarty version 2.6.26, created on 2012-05-05 10:02:23
         compiled from page.htm */ ?>
<!-- start 頁碼 -->
<div id="turn-page"> <?php echo $this->_tpl_vars['lang']['total_records']; ?>
 <span id="totalRecords"><?php echo $this->_tpl_vars['filter']['record_count']; ?>
</span> <?php echo $this->_tpl_vars['lang']['total_pages']; ?>
 <span id="totalPages"><?php echo $this->_tpl_vars['filter']['page_count']; ?>
</span> <?php echo $this->_tpl_vars['lang']['page_current']; ?>
 <span id="pageCurrent"><?php echo $this->_tpl_vars['filter']['page']; ?>
</span> <?php echo $this->_tpl_vars['lang']['page_size']; ?>

	<input type='text' size='3' id='pageSize' value="<?php echo $this->_tpl_vars['filter']['page_size']; ?>
" onkeypress="return listTable.changePageSize(event)" />
	<span id="page-link"> <?php echo '<a href="javascript:listTable.gotoPageFirst()">'; ?>
<?php echo $this->_tpl_vars['lang']['page_first']; ?>
</a> <?php echo '<a href="javascript:listTable.gotoPagePrev()">'; ?>
<?php echo $this->_tpl_vars['lang']['page_prev']; ?>
</a> <?php echo '<a href="javascript:listTable.gotoPageNext()">'; ?>
<?php echo $this->_tpl_vars['lang']['page_next']; ?>
</a> <?php echo '<a href="javascript:listTable.gotoPageLast()">'; ?>
<?php echo $this->_tpl_vars['lang']['page_last']; ?>
</a>
	<select id="gotoPage" onchange="listTable.gotoPage(this.value)">
			<?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)1;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['filter']['page_count']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
			<option value="<?php echo $this->_sections['foo']['index']; ?>
" <?php if ($this->_sections['foo']['index'] == $this->_tpl_vars['filter']['page']): ?>selected<?php endif; ?>><?php echo $this->_sections['foo']['index']; ?>
</option>
			<?php endfor; endif; ?>
	</select>
	</span> 
</div>
<!-- end 頁碼 -->