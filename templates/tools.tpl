{include file="header"}
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">{$name}</a></h2>
<div id="main">
{if $submit|isset}
{$content}
{else}
<form method="post" name="target" action="?page=tools" class="jNice">
	<table width="320"  border="0" align="center">
		<tr>
			<td><strong>DNS lookup:</strong></td>
			<td><input class="text" type="text" name="dns" /></td>
		</tr>
			<td><strong>Domain WHOIS:</strong></td>
			<td><input class="text" type="text" name="whois" /></td>
		<tr class="odd">
			<td>&nbsp;</td>
			<td><center><input type="submit" name="Submit" value="Check" /></center></td>
		</tr>
	</table>
</form>
{/if}
</div>
{include file="footer"}
