<?php

define('THIS_DIR',dirname(__FILE__).'/');

function PHP52_legacy_autoloader($class) {
	$classpath = str_replace('_','/',$class);
	
	if (file_exists(THIS_DIR.$classpath.'.php')) {
		include THIS_DIR.$classpath.'.php';
		return true;
	}
	
	return false;
}
spl_autoload_register('PHP52_legacy_autoloader');
