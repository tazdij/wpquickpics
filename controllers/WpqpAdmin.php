<?php

class WpqpAdmin extends WpqpController {
	
	// Static Methods
	
	/**
	 * _admin_init is a static function which may be used in add_action
	 * fo the wp admin_init action
	 */
	public static function _admin_init() {
		// Register the settings group and variable
		register_setting('wpqp_settings_group', 'wpqp_settings');
	}
	
	
	public function __construct() {
		parent::__construct();
	}
	
	public function Dashboard() {
		
		$this->render('Admin/Dashboard', array(), false);
	}

	public function WpqpSettings() {

	}
	
	/**
	 * Only used to create the bulletin and it's meta information
	 */
	public function Members() {

		$this->loadModel('Clients');

		//$this->clients_model->create_client('don@deduvall.com', 'password', 'don', 'duvall');
		$clients = $this->clients_model->get_clients();
		print_r($clients);
		
		// Check if this is a POST
		if (isset($_POST['submit'])) {
			// This is a post of a new Bulletin
			
			
			print('POSTED<br><br><br>POSTED');
			
		}
		
		// Enqueue the needed javascripts & styles
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-droppable');
		wp_enqueue_script('jquery-ui-datepicker');
		
		wp_enqueue_script('hvst-bltn-jquery-ui-timepicker', TZDJ_OLYMPIC_URL . '/assets/js/jquery-ui-timepicker-addon.js');
		//wp_enqueue_style('hvst-bltn-jquery-ui-css', HVST_BULLETIN_URL . '/assets/css/jquery-ui-timepicker-addon.css');
		wp_enqueue_style('hvst-bltn-jquery-ui-css', TZDJ_OLYMPIC_URL . '/assets/css/jquery-ui-style.min.css');
		
		
		$this->render('Admin/Members', array(), false);
	}
	
	public function EditBulletin() {
		// Enqueue the needed javascripts & styles
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-droppable');
	}
	
	
	public function BulletinsSettings() {
		
	}
}
