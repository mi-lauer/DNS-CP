{include file="header"}
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">{$name}</a></h2>
<div id="main">
	{if $data|isset}{$data}{/if}
	<form name="form1" method="post" action="?page=users&act=add" class="jNice">
		<table width="320"  border="0">
			<tr>
				<td><div align="right"><strong>Username:</strong></div></td>
				<td><input class="text" type="text" name="username_one" ></td>
			</tr>
			<tr>
				<td><div align="right"><strong>Administrator:</strong></div></td>
				<td>
					<label><input type="radio" name="admin" value="1" />yes</label> 
					<label><input type="radio" name="admin" value="0" checked="checked" />no</label>
				</td>
			</tr>
			<tr>
				<td><div align="right"><strong>password:</strong></div></td>
				<td><input class="text" type="password" name="password_one" ></td>
			</tr>
			<tr>
				<td><div align="right"><strong>Confirm password:</strong></div></td>
				<td><input class="text" type="password" name="confirm_password" ></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="odd">
				<td>&nbsp;</td>
				<td><input name="Submit" type="submit" value="Save"></td>
			</tr>
		</table>
	</form>
</div>
{include file="footer"}