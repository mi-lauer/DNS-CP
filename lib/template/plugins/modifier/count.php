<?php
/**
 * Smarty-Light count plugin
 *
 * Type:     modifier
 * Name:     count
 * Purpose:  displays the number of elements in the modified array
 */
function tpl_modifier_count($string) {
	if (is_array($string)) {
		return count($string);
	} else {
		return 0;
	}
}
?>