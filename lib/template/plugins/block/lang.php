<?php
/**
 * Smarty-Light {lang}{/lang} block plugin
 *
 * Type:     block function
 * Name:     lang
 */
function tpl_block_lang($params, $content, &$tpl) {
	$lang = $tpl->language;
	if(isset($lang[$content]))
		return $lang[$content];
	else
		return $content;
}
?>