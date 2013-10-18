<?php
/**
 * Smarty-Light {capture}{/capture} block plugin
 *
 * Type:     block function
 * Name:     capture
 * Purpose:  removes content and stores it in a variable
 */
function tpl_block_capture($params, $content, &$tpl) {
	extract($params);
	if (!isset($assign) || empty($assign)) {
		$tpl->trigger_error("block: missing 'assign' parameter");
		return;
	}
	if (!empty($content)) {
		$tpl->assign($assign,$content);
	}
	return;
}
?>