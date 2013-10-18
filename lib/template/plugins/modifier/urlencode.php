<?php
/**
 * Smarty-Light url encode modifier plugin
 *
 * Type:     modifier
 * Name:     urlencode
 * Purpose:  Wrapper for the PHP 'urlencode' function
 */
function tpl_modifier_urlencode($string) {
	return urlencode($string);
}
?>