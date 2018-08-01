<?php




function wpqp_autoload($class_name) {
	
	// Gaurd from searching disk on every request for all plugins
	// exits if trying to search a class that isn't ours
	if (substr_compare($class_name, 'Wpqp', 0, 4) !== 0)
		return false;
	
	
	$spl_search_paths = array(
		dirname(dirname(__FILE__)) . '/controllers/',
		dirname(dirname(__FILE__)) . '/models/',
		dirname(dirname(__FILE__)) . '/components/',
		dirname(__FILE__) . '/'
	);
	
    foreach ($spl_search_paths as &$folder_path) {
    	$path = $folder_path . $class_name . '.php';
		
		if (file_exists($path)) {
			include_once($path);
			return true;
		}
	}
	
	//die($out);
	
}

if (function_exists('spl_autoload_register'))
    spl_autoload_register('wpqp_autoload');
else
{
    function __autoload($class_name) {
        wpqp_autoload($class_name);
    }
}