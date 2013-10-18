<?php
/**
 * Smarty-Light wordwrap modifier plugin
 *
 * Type:     modifier
 * Name:     wordwrap
 * Purpose:  Wrapper for the PHP 'wordwrap' function
 */
function tpl_modifier_wordwrap($string, $length = 80, $break = '\n', $cut = false) {
	return wordwrap($string, $length, $break, $cut);
}
?>