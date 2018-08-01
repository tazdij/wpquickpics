<?php

class HvstBltnHeadingComponent extends HvstBltnComponent {
	
	public function __construct() {
		parent::__construct();
		
		$this->registerSettingField('Heading Type', array(
						'type' => 'dropdown', 
						'options' => array(
							'Heading 1',
							'Heading 2',
							'Heading 3',
							'Heading 4',
							'Heading 5')), 
						'Heading 1');
						
		$this->registerSettingField('Font Color', array(
						'type' => 'dropdown',
						'options' => array(
							'Primary',
							'Secondary',
							'Trinary')),
						'Primary');
		
		$this->registerDataField('Heading', 'text', '');
		
	}
	
	
	
}
