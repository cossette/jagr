<?php
function getLanguageFields($fields, $jagr){
	// Prepare languages
	foreach($jagr['form']['languages'] as $k => $v){
		$languages[Inflector::slug($v)] = array(
			'label' => $v,
			'fields' => array()
		);
	}
	
	$languages['default'] = array(
		'label' => 'Général',
		'fields' => array()
	);
	
	// Map fields
	foreach($fields as $field){
		$grouped = false;
		foreach($jagr['form']['languages'] as $k => $v){
			$slug = Inflector::slug($v);
			if(preg_match("/".$k."/", $field)){
				$languages[$slug]['fields'][] = $field;
				$grouped = true;
				break 1;
			}
		}
		
		if(!$grouped) $languages['default']['fields'][] = $field;
	}
	
	// Remove empty groups
	foreach($languages as $k => $v){
		if(empty($v['fields'])) unset($languages[$k]);
	}
	
	return $languages;
}