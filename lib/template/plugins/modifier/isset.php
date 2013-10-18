<?php
/**
 * Smarty-Light isset modifier plugin
 *
 * Type:     modifier
 * Name:     isset
 * Purpose:  Wrapper for the PHP 'isset' function
 */
function tpl_modifier_isset($string) {
	return isset($string);
}
?>