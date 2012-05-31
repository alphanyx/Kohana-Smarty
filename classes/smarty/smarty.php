<?php

namespace Modules;

use \Kohana_Exception,
	\Kohana;


class Smarty {
	private static $_smarty = false;
	
	private $_file;
	private $_data = array();
	private static $extension = false;

	public function __set($key, $value = NULL)
	{
		if (is_array($key))
		{
			foreach ($key as $name => $value)
			{
				$this->_data[$name] = $value;
			}
		}
		else
		{
			$this->_data[$key] = $value;
		}

		return $this;
	}

	public function __get($key) {
		if (array_key_exists($key, $this->_data))
		{
			return $this->_data[$key];
		} else {
			throw new Kohana_Exception('View variable is not set: :var',
				array(':var' => $key));
		}
	}

	public static function set_extension($extension) {
		self::$extension = $extension;
	}

	public function set_filename($file)
	{
		if($path = Kohana::find_file('views', $file, self::$extension)) {
			$this->_file = $path;
			return $this->_file;
		}
		return;
	}
	
	public function render($file = false, $data = array()) {
		$smarty = self::instance();

		if ($file !== FALSE) {
			$file = $this->set_filename($file);
		}

		if (gettype($data) == 'array' && !count($data) && count($this->_data)) {
			$data = $this->_data;
		}
		
		// Assign vars to smarty
		foreach ($data as $key => $value) {
			$smarty->assign($key, $value);
		}

		return $smarty->fetch($file);
	}
	
	private static function instance() {
		if(self::$_smarty) return self::$_smarty;
		
		$config = Kohana::$config->load('smarty')->as_array();

		// include smarty
		try {
			require_once ($config['smarty_classpath']);
		} catch (Exception $e) {
			throw new Kohana_Exception('Could not load Smarty class file');
		}

		self::$extension = $config['smarty_extension'];
		
		// New Smarty instance
		$smarty = new \Smarty;
		
		
		// Search for template and plugin dirs
		$tpl_dirs = array();
		$plugin_dirs = array();
		
		if(file_exists(APPPATH . 'smarty_plugins')) $plugin_dirs[] = APPPATH . 'smarty_plugins'; 
		if(file_exists(APPPATH . 'views')) $tpl_dirs[] = APPPATH . 'views'; 
		
		foreach (Kohana::modules() as $module) {
			$plugin_path = $module . 'smarty_plugins' . DIRECTORY_SEPARATOR;
			if (file_exists($plugin_path)) {
				$plugin_dirs[] = $plugin_path;
			}

			$template_path = $module . 'views' . DIRECTORY_SEPARATOR;
			if (file_exists($template_path)) {
				$tpl_dirs[] = $template_path;
			}
		}

		$options = $config['smarty_config'];

		// Set template and plugin dirs
		$smarty->setTemplateDir(array_merge($tpl_dirs, $options['template_dir']));
		$smarty->plugins_dir = array_merge($plugin_dirs, (array) $options['plugin_dir']);
		unset($options['template_dir'], $options['plugin_dir']);

		// Set config form configfile and options 
		foreach ( $options as $key => $value ) {
			$smarty->$key = $value;
		}
		
		// Check if folders are writeable
		if ( !is_writeable($smarty->compile_dir) ) throw new Kohana_Exception('Smarty compile_dir is not writable');
		if ( !is_writeable($smarty->cache_dir) ) throw new Kohana_Exception('Smarty cache_dir is not writable');
		
		return self::$_smarty = $smarty;
	}
}