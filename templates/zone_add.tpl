{include file="header"}
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">{$name}</a></h2>

<div id="main">
<form name="form1" method="post" action="?page=zone&act=add" class="jNice">
	<table width="320"  border="0">
		<tr>
			<td><div align="right"><strong>Zone:</strong></div></td>
			<td><input class="text" type="text" name="name"></td>
			<td>(without dot at the end)</td>
		</tr>
		<tr>
			<td><div align="right"><strong>Owner: </strong></div></td>
			<td>
				<select name="owner">
					{foreach from=$res3 item=row3}
						<option value="{$row3[id]}">{$row3[username]}</option>
					{/foreach}
				</select>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr class="odd">
			<td>&nbsp;</td>
			<td><input name="Submit" type="submit" value="Add zone"></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>
</div>
{include file="footer"}