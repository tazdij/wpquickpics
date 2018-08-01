<?php

class WpqpViewNotFoundException extends Exception {}
class WpqpModelNotFoundException extends Exception {}

class WpqpController {
	
	protected $_parent_theme_dir;
	protected $_theme_dir;
	
	public function __construct() {
		$this->_parent_theme_dir = get_template_directory();
		$this->_theme_dir = get_stylesheet_directory();
	}
	
	/**
	 * Check if the theme is nested
	 * 
	 * This function compares the two theme locations, if different
	 * then the theme is a nested theme.
	 */
	protected function isNestedTheme() {
		return ($this->_theme_dir !== $this->_parent_theme_dir);
	}
	
	protected function loadModel($name, $var=null) {

		$name = 'Wpqp' . $name . 'Model';
		// Test if the model exists
		$filepath = WPQP_DIR . '/' . $name . '.php';
		
		if (!class_exists($name)) {
			if (!file_exists($filepath)) {
				throw new ModelNotFoundException();
			}
			
			include_once($filepath);
		}
		$obj = new $name();

		if ($var !== null) {
			$this->$var = $obj;
		} else {
			$ident = $obj->getIdentity();

			if (!isset($this->$ident)) {
				$this->$ident = $obj;
			}
		}
	}
	
	/**
	 * Render the view, and possibly return its output. Accepts an array of variables
	 */
	protected function render($view, $data = null, $return = true) {
		// Load all of three places a View may be places
		$default_filename = WPQP_DIR . '/views/' . trim(trim($view, '.php'), '/') . '.php';
		$parent_theme_filename = $this->_parent_theme_dir . '/views/wpqp/' . trim(trim($view, '.php'), '/') . '.php';
		$theme_filename = $this->_theme_dir . '/views/wpqp/' . trim(trim($view, '.php'), '/') . '.php';
		
		$filename = false;
		
		// Test each of the locations in order for the file's existence
		if (file_exists($theme_filename))
			$filename = $theme_filename;
		elseif (file_exists($parent_theme_filename))
			$filename = $parent_theme_filename;
		else
			$filename = $default_filename;
		
		if (!file_exists($filename))
			throw new ViewNotFoundException();
		
		// Extract K/V Pair array into local variables
		if (is_Array($data))
			extract($data);
		
		// Start output buffer
		ob_start();
		
		// Include the template file
		include($filename);
		
		// Collect the output into a variable, and delete buffer, as to not display it
		$output = ob_get_clean();
		
		// if NOT Return, print output and return true
		if (!$return) {
			print($output);
			return true;
		}
		
		// Return output buffer content
		return $output;
	}
	
}
