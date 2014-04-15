<?php
	// Controllers & models
	$app_folder = '../../../../app/';

	$exclude = array(
		'App', 'Admin', 'Elements', 'Emails', 'Errors', 'Helper', 'Layouts', 'Pages', 'Scaffolds', 'Tests'
	); 
	
	$controllers_dir = $app_folder . 'Controller';
	$controllers_tests_dir = $app_folder . 'Test/Case/Controller';
	$models_dir = $app_folder . 'Model';
	$models_tests_dir = $app_folder . 'Test/Case/Model';
	$fixture_dir = $app_folder . 'Test/Fixture';
	
	delete_files($controllers_dir);
	delete_files($controllers_tests_dir);
	delete_files($models_dir);
	delete_files($models_tests_dir);
	delete_files($fixture_dir);
	
	// Views
	$views_dir = $app_folder . 'View';
	delete_views($views_dir);
	
	function delete_files($dir) {
		global $exclude;
		
		$files = array_slice(scandir($dir), 2);
		
		foreach($files as $file) {
			// Exclude non PHP files
			if (!preg_match('/php$/', $file)) continue;
			// Exclude these keywords
			if (preg_match('/^(' . implode('|', $exclude) . ')/', $file)) continue;
			
			$path = "{$dir}/{$file}";
			
			unlink($path);
			
			echo "Deleted file {$path} \n";
		}
	}
	
	function delete_views($dir) {
		global $exclude;
		
		$views = array_slice(scandir($dir), 2);
		
		foreach($views as $view) {
			// Exclude these keywords
			if (preg_match('/^(' . implode('|', $exclude) . ')/', $view)) continue;
			
			$path = "{$dir}/{$view}";
			
			rrmdir($path);
			
			echo "Deleted view {$path} \n";
		}
	}
	
	// Recursively remove a directory
	function rrmdir($dir) {
		foreach(glob($dir . '/*') as $file) {
			if(is_dir($file))
				rrmdir($file);
			else
				unlink($file);
		}
		rmdir($dir);
	}