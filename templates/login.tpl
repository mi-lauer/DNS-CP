{include file="header"}
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">{$name}</a></h2>
<div id="main">
{if $error|isset}{$error}{/if}
<form method="post" name="login" action="?page=login" class="jNice">
	<table width="320"  border="0" align="center">
		<tr>
			<td><strong>Username:</strong></td>
			<td><input class="text" type="text" name="username" /></td>
		</tr>
		<tr>
			<td><strong>Password:</strong></td>
			<td><input class="text" type="password" name="password" /></td>
		</tr>
		<tr class="odd">
			<td><center><input type="submit" name="Submit" value="Login" /></center></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>
</div>
{include file="footer"}