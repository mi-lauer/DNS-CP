{include file="header"}
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">{$name}</a></h2>
<div id="main">
{if $data|isset}{$data}{/if}
<table width="100%"  border="0" cellspacing="1" class="jNice">
	<tr>
		<td><strong>Name</strong></td>
		<td><strong>Serial</strong></td>
		<td><strong>Records</strong></td>
		<td><strong>Manage</strong></td>
	</tr>
	{foreach from=$zones key=zoneid item=row}
		<tr>
			<td class="action"><a class="view" href="?page=zone&id={$row[id]}">{$row[origin]}</a></td>
			<td class="action"><a class="edit" href="?page=zone&id={$row[id]}">{$row[serial]}</a></td>
			<td class="action"><a class="edit" href="?page=zone&id={$row[id]}">{$row[records]}</a></td>
			{if $isAdmin}
			<td class="action"><a class="delete" href="?page=zone&id={$row[id]}&act=del" onClick="return confirm('Do you really want to remove this zone?');">Delete</a></td>
			{else}
			<td>&nbsp;</td>
			{/if}
		</tr>
	{/foreach}
</table>
</div>
{include file="footer"}