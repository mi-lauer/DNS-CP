{include file="header"}
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">{$name}</a></h2>
<div id="main">
	{$error}
	<form name="form1" method="post" action="?page=settings" class="jNice">
		<table width="320" border="0">
			<tr>
				<td><div align="right"><strong>Old password:</strong></div></td>
				<td><input class="text" type="password" name="password_old" ></td>
			</tr>
			<tr>
				<td><div align="right"><strong>New password:</strong></div></td>
				<td><input class="text" type="password" name="password_one" ></td>
			</tr>
			<tr>
				<td><div align="right"><strong>Confirm new password:</strong></div></td>
				<td><input class="text" type="password" name="confirm_password" ></td>
			</tr>
		</table>

		<br />
		<input name="Submit" type="submit" class="a" value="Save settings">
	</form>
</div>
{include file="footer"}