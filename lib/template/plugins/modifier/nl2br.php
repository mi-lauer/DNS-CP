<?php
/**
 * Smarty-Light nl2br modifier plugin
 *
 * Type:     modifier
 * Name:     nl2br
 * Purpose:  Wrapper for the PHP 'nl2br' function
 */
function tpl_modifier_nl2br($string) {
	return nl2br($string);
}
?>