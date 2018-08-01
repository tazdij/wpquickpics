<?php

class HvstBltnFunctionNotDefined extends Exception {}


/**
 * The base class for all components
 * 
 * Components are the blocks which are placed in a bulletin
 * 
 * 
 */
class HvstBltnComponent {
	
	protected $_setting_fields = array();
	protected $_data_fields = array();
	
	public function __construct() {
		
	}
	
	protected function registerSettingField($fieldName, $fieldType, $fieldDefault) {
		if (array_key_exists($fieldName, $this->_setting_fields))
			return false;
		
		$field['name'] = $fieldName;
		$field['type'] = $fieldType;
		$field['default'] = $fieldDefault;
		
		$this->_setting_fields[$fieldName] = $field;
		
		return true;
	}
	
	protected function registerDataField($fieldName, $fieldType, $fieldDefault) {
		if (array_key_exists($fieldName, $this->_data_fields))
			return false;
		
		$field['name'] = $fieldName;
		$field['type'] = $fieldType;
		$field['default'] = $fieldDefault;
		
		$this->_data_fields[$fieldName] = $field;
		
		return true;
	}
	
	public function getSettingFields() {
		return $this->_setting_fields;
	}
	
	public function getDataFields() {
		return $this->_data_fields;
	}
	
	public function getData() {
		
	}
	
	public function getSettings() {
		
	}
	
	
	/**
	 * Should be able to render the block to a string for return
	 */
	public function render() {
		
	}
	
}