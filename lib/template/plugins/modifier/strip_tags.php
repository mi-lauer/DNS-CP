<?php
/**
 * Smarty-Light strip_tags modifier plugin
 *
 * Type:     modifier
 * Name:     strip_tags
 * Purpose:  Wrapper for the PHP 'strip_tags' function
 */
function tpl_modifier_strip_tags($string) {
	return strip_tags($string);
}
?>