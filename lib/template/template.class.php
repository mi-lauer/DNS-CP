<?php
/*
 * Project:	Smarty-Light, a smarter template engine
 * File:	class.template.php
 * Author:	Paul Lockaby <paul@paullockaby.com>
 * Author:	since 2.2.13 Serge Gilette<sgilette@yahoo.com>
 * Version:	2.2.13
 * Copyright:	2003,2004,2005 by Paul Lockaby. 2006 by Serge Gilette
 * Credit:	This work is a light version of Smarty: the PHP compiling
 *		template engine, v2.5.0-CVS. Smarty was originally
 *		programmed by Monte Ohrt and Andrei Zmievski and can be
 *		found at http://smarty.php.net
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * You may contact the original author of Flat-Frog by e-mail at:
 * paul@paullockaby.com
 *
 * You may contact the package maintainer and current developper by e-mail at:
 * sgilette@yahoo.com
 *
 * The latest version of Flat-Frog can be obtained from:
 * https://sourceforge.net/projects/flatfrog
 *
 */

class template {
	// public configuration variables
	var $left_tag			= "{";		// the left delimiter for template tags
	var $right_tag			= "}";		// the right delimiter for template tags
	var $cache			= false;	// whether or not to allow caching of files
	var $force_compile		= false;	// force a compile regardless of saved state
	var $template_dir		= "templates";	// where the templates are to be found
	var $plugin_dir			= "plugins";	// where the plugins are to be found
	var $compile_dir		= "compiled";	// the directory to store the compiled files in
	var $config_dir			= "templates";	// where the config files are
	var $cache_dir			= "cache";	// where cache files are stored
	var $config_overwrite		= false;
	var $config_booleanize		= true;
	var $config_fix_new_lines	= true;
	var $config_read_hidden		= true;
	var $cache_lifetime		= 0;		// how long the file in cache should be considered "fresh"
	var $tpl_ending			= "tpl";
	var $language			= array();
	
	// private internal variables
	var $_vars		= array();	// stores all internal assigned variables
	var $_confs		= array();	// stores all internal config variables
	var $_plugins		= array();	// stores all internal plugins
	var $_linenum		= 0;		// the current line number in the file we are processing
	var $_file		= "";		// the current file we are processing
	var $_config_obj	= null;
	var $_compile_obj	= null;
	var $_cache_id		= null;
	var $_cache_dir		= "";		// stores where this specific file is going to be cached
	var $_cache_info	= array('config' => array(), 'template' => array());
	var $_sl_md5		= '39fc70570b8b60cbc1b85839bf242aff';

	function assign($key, $value = null) {
		if (is_array($key)) {
			foreach($key as $var => $val)
				if ($var != "" && !is_numeric($var))
					$this->_vars[$var] = $val;
		} else {
			if ($key != "" && !is_numeric($key))
				$this->_vars[$key] = $value;
		}
	}

	function assign_config($key, $value = null) {
		if (is_array($key)) {
			foreach($key as $var => $val)
				if ($var != "" && !is_numeric($var))
					$this->_confs[$var] = $val;
		} else {
			if ($key != "" && !is_numeric($key))
				$this->_confs[$key] = $value;
		}
	}

	function clear($key = null) {
		if ($key == null) {
			$this->_vars = array();
		} else {
			if (is_array($key)) {
				foreach($key as $index => $value)
					if (in_array($value, $this->_vars))
						unset($this->_vars[$index]);
			} else {
				if (in_array($key, $this->_vars))
					unset($this->_vars[$index]);
			}
		}
	}

	function clear_config($key = null) {
		if ($key == null) {
			$this->_conf = array();
		} else {
			if (is_array($key)) {
				foreach($key as $index => $value)
					if (in_array($value, $this->_conf))
						unset($this->_conf[$index]);
			} else {
				if (in_array($key, $this->_conf))
					unset($this->_conf[$key]);
			}
		}
	}

	function &get_vars($key = null) {
		if ($key == null) {
			return $this->_vars;
		} else {
			if (isset($this->_vars[$key]))
				return $this->_vars[$key];
			else
				return null;
		}
	}

	function &get_config_vars($key = null) {
		if ($key == null) {
			return $this->_confs;
		} else {
			if (isset($this->_confs[$key]))
				return $this->_confs[$key];
			else
				return null;
		}
	}
	
	function clear_compiled($file = null) {
		$this->_destroy_dir($file, null, $this->_get_dir($this->compile_dir));
	}

	function clear_cached($file = null, $cache_id = null) {
		if (!$this->cache)
			return;
		$this->_destroy_dir($file, $cache_id, $this->_get_dir($this->cache_dir));
	}

	function is_cached($file, $cache_id = null) {
		if (!$this->force_compile && $this->cache && $this->_is_cached($file, $cache_id)) {
			return true;
		} else {
			return false;
		}
	}

	function register_modifier($modifier, $implementation) {
		$this->_plugins['modifier'][$modifier] = $implementation;
	}

	function unregister_modifier($modifier) {
		if (isset($this->_plugins['modifier'][$modifier]))
			unset($this->_plugins['modifier'][$modifier]);
	}

	function register_function($function, $implementation) {
		$this->_plugins['function'][$function] = $implementation;
	}

	function unregister_function($function) {
		if (isset($this->_plugins['function'][$function]))
			unset($this->_plugins['function'][$function]);
	}

	function register_block($function, $implementation) {
		$this->_plugins['block'][$function] = $implementation;
	}

	function unregister_block($function) {
		if (isset($this->_plugins['block'][$function]))
			unset($this->_plugins['block'][$function]);
	}

	function template_exists($file) {
		if (file_exists($this->_get_dir($this->template_dir).$file)) {
			return true;
		} else {
			return false;
		}
	}

	function display($file, $cache_id = null) {
		$this->fetch($file, $cache_id, true);
	}

	function fetch($file, $cache_id = null, $display = false) {
		$this->_cache_id = $cache_id;
		$this->template_dir = $this->_get_dir($this->template_dir);
		$this->compile_dir = $this->_get_dir($this->compile_dir);
		if ($this->cache)
			$this->_cache_dir = $this->_build_dir($this->cache_dir, $this->_cache_id);
		$name = md5($this->template_dir.$file).'.php';

		// don't display any errors
		$this->_error_level = error_reporting(error_reporting() & ~E_NOTICE);

		if (!$this->force_compile && $this->cache && $this->_is_cached($file, $cache_id)) {
			ob_start();
			include($this->_cache_dir.$name);
			$output = ob_get_contents();
			ob_end_clean();
			$output = substr($output, strpos($output, "\n") + 1);
		} else {
			$output = $this->_fetch_compile($file, $cache_id);
			if ($this->cache) {
				$f = fopen($this->_cache_dir.$name, "w");
				fwrite($f, serialize($this->_cache_info) . "\n$output");
				fclose($f);
			}
		}

		if (strpos($output, $this->_sl_md5) !== false) {
			preg_match_all('!' . $this->_sl_md5 . '{_run_insert (.*)}' . $this->_sl_md5 . '!U',$output,$_match);
			foreach($_match[1] as $value) {
				$arguments = unserialize($value);
				$output = str_replace($this->_sl_md5 . '{_run_insert ' . $value . '}' . $this->_sl_md5, call_user_func_array('insert_' . $arguments['name'], array((array)$arguments, $this)), $output);
			}
		}

		// return error reporting to normal
		error_reporting($this->_error_level);

		if ($display) {
			echo $output;
		} else {
			return $output;
		}
	}

	function config_load($file, $section_name = null, $var_name = null) {
		$this->template_dir = $this->_get_dir($this->template_dir);
		$this->config_dir = $this->_get_dir($this->config_dir);
		$this->compile_dir = $this->_get_dir($this->compile_dir);
		$name = md5($this->template_dir.$file.$section_name.$var_name).'.php';

		if ($this->cache) {
			array_push($this->_cache_info['config'], $file);
		}

		if (!$this->force_compile && file_exists($this->compile_dir.'c_'.$name) && (filemtime($this->compile_dir.'c_'.$name) > filemtime($this->config_dir.$file))) {
			include($this->compile_dir.'c_'.$name);
			return true;
		}

		if (!is_object($this->_config_obj)) {
			require_once("config.class.php");
			$this->_config_obj = new config;
			$this->_config_obj->overwrite = $this->config_overwrite;
			$this->_config_obj->booleanize = $this->config_booleanize;
			$this->_config_obj->fix_new_lines = $this->config_fix_new_lines;
			$this->_config_obj->read_hidden = $this->config_read_hidden;
		}
		if (!($_result = $this->_config_obj->config_load($this->config_dir.$file, $section_name, $var_name))) {
			return false;
		}

		if (!empty($var_name) || !empty($section_name)) {
			$output = "\$this->_confs = " . var_export($_result, true) . ";";
		} else {
			// must shift of the bottom level of the array to get rid of the section labels
			$_temp = array();
			foreach($_result as $value)
				$_temp = array_merge($_temp, $value);
			$output = "\$this->_confs = " . var_export($_temp, true) . ";";
		}

		$f = fopen($this->compile_dir.'c_'.$name, "w");
		fwrite($f, '<?php ' . $output . ' ?>');
		fclose($f);
		eval($output);
		return true;
	}

	function _is_cached($file, $cache_id) {
		$this->_cache_dir = $this->_get_dir($this->cache_dir, $cache_id);
		$this->config_dir = $this->_get_dir($this->config_dir);
		$this->template_dir = $this->_get_dir($this->template_dir);
		$name = md5($this->template_dir.$file).'.php';

		if (file_exists($this->_cache_dir.$name) && (((time() - filemtime($this->_cache_dir.$name)) < $this->cache_lifetime) || $this->cache_lifetime == -1) && (filemtime($this->_cache_dir.$name) > filemtime($this->template_dir.$file))) {
			$fh = fopen($this->_cache_dir.$name, "r");
			if (!feof($fh) && ($line = fgets($fh, filesize($this->_cache_dir.$name)))) {
				$includes = unserialize($line);
				if (isset($includes['template']))
					foreach($includes['template'] as $value)
						if (!(file_exists($this->template_dir.$value) && (filemtime($this->_cache_dir.$name) > filemtime($this->template_dir.$value))))
							return false;
				if (isset($includes['config']))
					foreach($includes['config'] as $value)
						if (!(file_exists($this->config_dir.$value) && (filemtime($this->_cache_dir.$name) > filemtime($this->config_dir.$value))))
							return false;
			}
			fclose($fh);
		} else {
			return false;
		}
		return true;
	}

	function _fetch_as_is($file) {
		if (file_exists($file)) {
			$f = fopen($file, "r");
			$size = filesize($file);
			if ($size > 0) {
				$file_contents = fread($f, filesize($file));
			}
			fclose($f);
			return $file_contents;
		} else {
			$this->trigger_error("file '$file' does not exist", E_USER_ERROR);
		}
	}

	function _fetch_compile($file) {
		$file = $file.".".$this->tpl_ending;
		$this->template_dir = $this->_get_dir($this->template_dir);
		$name = md5($this->template_dir.$file).'.php';

		if ($this->cache) {
			array_push($this->_cache_info['template'], $file);
		}

		if (!$this->force_compile && file_exists($this->compile_dir.'c_'.$name) && (filemtime($this->compile_dir.'c_'.$name) > filemtime($this->template_dir.$file))) {
			ob_start();
			include($this->compile_dir.'c_'.$name);
			$output = ob_get_contents();
			ob_end_clean();
			error_reporting($this->_error_level);
			return $output;
		}

		if ($this->template_exists($file)) {
			$f = fopen($this->template_dir.$file, "r");
			$size = filesize($this->template_dir.$file);
			if ($size > 0) {
				$file_contents = fread($f, filesize($this->template_dir.$file));
			} else {
				$file_contents = "";
			}
			$this->_file = $file;
			fclose($f);
		} else {
			$this->trigger_error("template '$file' does not exist", E_USER_ERROR);
		}

		if (!is_object($this->_compile_obj)) {
			require_once("compiler.class.php");
			$this->_compile_obj = new compiler;
		}
		$this->_compile_obj->left_tag = $this->left_tag;
		$this->_compile_obj->right_tag = $this->right_tag;
		$this->_compile_obj->plugin_dir = &$this->plugin_dir;
		$this->_compile_obj->template_dir = &$this->template_dir;
		$this->_compile_obj->_vars = &$this->_vars;
		$this->_compile_obj->_confs = &$this->_confs;
		$this->_compile_obj->_plugins = &$this->_plugins;
		$this->_compile_obj->_linenum = &$this->_linenum;
		$this->_compile_obj->_file = &$this->_file;
		$output = $this->_compile_obj->_compile_file($file_contents);

		$f = fopen($this->compile_dir.'c_'.$name, "w");
		fwrite($f, $output);
		fclose($f);

		ob_start();
		eval(' ?>' . $output . '<?php ');
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	function _run_modifier() {
		$arguments = func_get_args();
		list($variable, $modifier, $_map_array) = array_splice($arguments, 0, 3);
		array_unshift($arguments, $variable);
		if ($_map_array && is_array($variable))
			foreach($variable as $key => $value)
				$variable[$key] = call_user_func_array($this->_plugins["modifier"][$modifier], $arguments);
		else
			$variable = call_user_func_array($this->_plugins["modifier"][$modifier], $arguments);
		return $variable;
	}

	function _run_insert($arguments) {
		if ($this->cache) {
			return $this->_sl_md5 . '{_run_insert ' . serialize((array)$arguments) . '}' . $this->_sl_md5;
		} else {
			if (!function_exists('insert_' . $arguments['name']))
				$this->trigger_error("function 'insert_" . $arguments['name'] . "' does not exist in 'insert'", E_USER_ERROR);
			if (isset($arguments['assign']))
				$this->assign($arguments['assign'], call_user_func_array('insert_' . $arguments['name'], array((array)$arguments, $this)));
			else
				return call_user_func_array('insert_' . $arguments['name'], array((array)$arguments, $this));
		}
	}

	function _get_dir($dir, $id = null) {
		if (empty($dir))
			$dir = '.';
		if (substr($dir, -1) != DIRECTORY_SEPARATOR)
			$dir .= DIRECTORY_SEPARATOR;
		if (!empty($id)) {
			$_args = explode('|', $id);
			if (count($_args) == 1 && empty($_args[0]))
				return $dir;
			foreach($_args as $value)
				$dir .= $value.DIRECTORY_SEPARATOR;
		}
		return $dir;
	}

	function _build_dir($dir, $id) {
		$_args = explode('|', $id);
		if (count($_args) == 1 && empty($_args[0]))
			return $this->_get_dir($dir);
		$_result = $this->_get_dir($dir);
		foreach($_args as $value) {
			$_result .= $value.DIRECTORY_SEPARATOR;
			if (!is_dir($_result)) @mkdir($_result, 0777);
		}
		return $_result;
	}

	function _destroy_dir($file, $id, $dir) {
		if ($file == null && $id == null) {
			if (is_dir($dir))
				if($d = opendir($dir))
					while(($f = readdir($d)) !== false)
						if ($f != '.' && $f != '..')
							$this->_rm_dir($dir.$f.DIRECTORY_SEPARATOR);
		} else {
			if ($id == null) {
				$this->template_dir = $this->_get_dir($this->template_dir);
				@unlink($dir.md5($this->template_dir.$file).'.php');
			} else {
				$_args = "";
				foreach(explode('|', $id) as $value)
					$_args .= $value.DIRECTORY_SEPARATOR;
				$this->_rm_dir($dir.DIRECTORY_SEPARATOR.$_args);
			}
		}
	}

	function _rm_dir($dir) {
		if (is_file(substr($dir, 0, -1))) {
			@unlink(substr($dir, 0, -1));
			return;
		}
		if ($d = opendir($dir)) {
			while(($f = readdir($d)) !== false) {
				if ($f != '.' && $f != '..') {
					$this->_rm_dir($dir.$f.DIRECTORY_SEPARATOR);
				}
			}
			@rmdir($dir.$f);
		}
	}

	function _escape_chars($string) {
		// taken directly from Smarty at http://smarty.php.net/
		if(!is_array($string)) {
			$string = preg_replace('!&(#?\w+);!', '%%%SMARTY_START%%%\\1%%%SMARTY_END%%%', $string);
			$string = htmlspecialchars($string);
			$string = str_replace(array('%%%SMARTY_START%%%','%%%SMARTY_END%%%'), array('&',';'), $string);
		}
		return $string;
	}

	function trigger_error($error_msg, $error_type = E_USER_ERROR, $file = null, $line = null) {
		if(isset($file) && isset($line))
			$info = ' ('.basename($file).", line $line)";
		else
			$info = null;
		trigger_error('TPL: [in ' . $this->_file . ' line ' . $this->_linenum . "]: syntax error: $error_msg$info", $error_type);
	}
}
?>