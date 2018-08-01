<?php

class WpqpWorkflowModel extends WpqpModel {

    public static function create_sql_list() {
        global $wpdb;
        return array(
            "CREATE TABLE `{$wpdb->prefix}wpqp_workflows` (
                `ID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `identifier` VARCHAR(255) NOT NULL, 
                `name` VARCHAR(255) NOT NULL,
                `notes` TEXT DEFAULT NULL,
                INDEX `IDX_{$wpdb->prefix}wpqp_workflows` (`identifier`)
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;",
            "CREATE TABLE `{$wpdb->prefix}wpqp_workflow_process` (
                `ID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `workflow_id` BIGINT UNSIGNED NOT NULL,
                `IDX` INTEGER UNSIGNED NOT NULL, 
                `function` VARCHAR(255) NOT NULL,
                `params` TEXT DEFAULT NULL,
                INDEX `IDX_{$wpdb->prefix}wpqp_workflow_process` (`workflow_id`, `IDX`)
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
        );
    }
    
    public function __construct() {
        parent::__construct();
    }

    public function getIdentity() {
        return 'workflow_model';
    }

    public function get_workflows() {
        $workflows = $this->db->get_results("SELECT * FROM {$this->db->prefix}wpqp_workflows");

        // Get all of the processes for the workflows
        foreach ($workflows as $wf) {
            $procs = $this->db->get_results("SELECT * FROM {$this->db->prefix}wpqp_workflow_process WHERE ");
        }

        return $workflows;
    }

    public function create_workflow($name, $identifier, $processes=array()) {
        //TODO: Insert Workflow record

        //TODO: For each Process, insert WorkflowProcess record
    }
}