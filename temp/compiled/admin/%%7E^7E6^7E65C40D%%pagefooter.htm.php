<?php /* Smarty version 2.6.26, created on 2012-05-05 10:02:08
         compiled from pagefooter.htm */ ?>
<div id="footer"> <?php echo $this->_tpl_vars['query_info']; ?>
<?php echo $this->_tpl_vars['gzip_enabled']; ?>
<?php echo $this->_tpl_vars['memory_info']; ?>
<br />
	<?php echo $this->_tpl_vars['lang']['copyright']; ?>
 </div>
<?php echo '
<script language="JavaScript">

	if(document.getElementById("listDiv")){
		
		/* 表格選取效果 */
		var listDiv = $(\'#listDiv\');
		listDiv.mouseover(function(){
			TR = $(\'#listDiv TR\');
			TR.mouseover(function(){
				$("TD", this).css(\'background\',\'#deedf0\');
			}).mouseout(function(){
				$("TD", this).css(\'background\',\'#FFFFFF\');
			});
		});
		
		document . getElementById("listDiv") . onclick = function (e)
		{
			var obj = Utils . srcElement(e);
		
			if (obj . tagName == "INPUT" && obj . type == "checkbox")
			{
				if (!document . forms[\'listForm\'])
				{
					return;
				}
				var nodes = document . forms[\'listForm\'] . elements;
				var checked = false;
		
				for (i = 0; i < nodes . length; i++)
				{
					if (nodes[i] . checked)
					{
						checked = true;
						break;
					}
				}
		
				if (document . getElementById("btnSubmit"))
				{
					document . getElementById("btnSubmit") . disabled = !checked;
				}
				for (i = 1; i <= 10; i++)
				{
					if (document . getElementById("btnSubmit" + i))
					{
						document . getElementById("btnSubmit" + i) . disabled = !checked;
					}
				}
			}
		}
	}
</script>
'; ?>

</body>
</html>