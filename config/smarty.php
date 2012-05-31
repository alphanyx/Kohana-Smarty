<?php

return array
(
	'smarty_extension' => 'html',
	'smarty_classpath' => MODPATH . 'smarty/vendor/Smarty-3.1.8/libs/Smarty.class.php',
	'smarty_config' => array(
		'compile_dir' => Kohana::$cache_dir . '/smarty/compile',
		'cache_dir' => Kohana::$cache_dir . '/smarty/cache',
	
		// Set additional smarty template dirs as array. *views will be added automatically
		'template_dir' => array(),
	
		// Set additional smarty plugin dirs as array. *smarty_plugins will be added automatically
		'plugin_dir' => array(), 

		// useful when developing, override to false in your application's config
		// for a small speed increase
		'compile_check' => true, 
		'caching' => false,
		'debugging' => false,
		'force_compile' => true,
		'error_reporting' => null,
	)
);
