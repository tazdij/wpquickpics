<?php

class WpqpInstall extends WpqpController {
	
	private $db;
	
	// Controls wheter or not the db will be upgraded or installed
	private $db_version = '0.0.1';
	
	public function __construct() {
		global $wpdb;
		
		parent::__construct();
		
		$this->db = &$wpdb;
	}
	
	public function Install() {
		
	}
	
	public function Activate() {
		$db_version = get_option('wpqp_db_version');
		
		
		// Check if a Database upgrade or install is needed
		if (!$db_version || $db_version !== $this->db_version) {
			
			// Include the upgrade functions
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			$sql_list = array_merge(
				WpqpWorkflowModel::create_sql_list(),
				WpqpInstanceModel::create_sql_list()
			);

			foreach ($sql_list as $sql) {
				dbDelta($sql);
			}
			
			// Run the delta, To upgrade the table (transforms Create into Alter)
			//dbDelta($sql_bltn_bulletin);
			//dbDelta($sql_bltn_blockinstance);
			//dbDelta($sql_bltn_blockinstancemeta);
			
			
			//update_option('hvst_bltn_db_version', $this->db_version);
		}
		
		
		return;
	}
	
	public function Deactivate() {
		// TODO: Determine if anything should be cleaned up later
		
	}
	
	public function Uninstall() {
		
	}
	
}
