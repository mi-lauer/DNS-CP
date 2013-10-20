<?php
/**
 * Smarty-Light isset modifier plugin
 *
 * Type:     modifier
 * Name:     isset
 * Purpose:  Wrapper for the PHP 'isset' function
 */
function tpl_modifier_isset($string) {
	if(isset($string) && !empty($string))
		return true;
	else
		return false;
}
?>