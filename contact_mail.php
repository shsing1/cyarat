<!--utf8編碼-->
<style type="text/css">
td.label {
  text-align: right;
  vertical-align: top;
  font-weight: bold;
  padding: 5px 1em;
}
</style>
<table width="500" border="0" cellpadding="0" cellspacing="1" class="contact_mail_table">
	<tr>
		<td>此信件為系統自動發出，請勿直接回覆！</td>
	</tr>
</table>
<table width="500" border="0" cellpadding="0" cellspacing="1" class="contact_mail_table">
	<tr>
		<td class="label" width="100"><?=$_LANG['lab_add_time']?>:</td>
		<td><?=$field['add_time']?></td>
	</tr>
	<tr>
		<td class="label">姓名:</td>
		<td><?=htmlspecialchars($field['name'])?></td>
	</tr>
	<tr>
		<td class="label">電子郵件:</td>
		<td><?=htmlspecialchars($field['email'])?></td>
	</tr>
	<tr>
		<td class="label">留言內容:</td>
		<td><?=nl2br(htmlspecialchars($field['content']))?></td>
	</tr>
</table>
