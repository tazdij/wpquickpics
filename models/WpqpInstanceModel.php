<?php

/*
    The Instance is a specific Instance of a Media placed in a post
    
    All images must be placed as an Instance. This allows for easily tracking which images are used
    in which posts. All Instances are taged to a post id

*/

class WpqpInstanceModel extends WpqpModel {

    public static function create_sql_list() {
        global $wpdb;
        return array(
            "CREATE TABLE `{$wpdb->prefix}wpqp_instances` (
                `ID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `identifier` VARCHAR(255) NOT NULL, 
                `post_id` BIGINT UNSIGNED NOT NULL,
                `workflow_identifier` VARCHAR(255) DEFAULT NULL,
                `media_identifier` VARCHAR(255) DEFAULT NULL,
                INDEX `IDX_{$wpdb->prefix}wpqp_instances` (`identifier`, `post_id`),
                INDEX `IDX_{$wpdb->prefix}wpqp_instances_POSTID` (`post_id`),
                INDEX `IDX_{$wpdb->prefix}wpqp_instances_MEDIA` (`media_identifier`)
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;",
        );
    }
    
    public function __construct() {
        parent::__construct();
    }

    public function getIdentity() {
        return 'instance_model';
    }
    
    public function instance_exists($post_id, $identifier) {
        // Query if the record exists
        $recs = $this->db->get_results(
            "SELECT COUNT(`ID`) AS `TOTAL` FROM {$this->db->prefix}wpqp_instances 
            WHERE `identifier` = '" . esc_sql($identifier) . "'
                AND `post_id` = " . esc_sql((string)$post_id));
        $count = $recs[0]->TOTAL;
        if ($count > 0) {
            return TRUE;
        }
        
        return FALSE;
    }

    public function update_instance($post_id, $identifier, $media=null, $workflow=null) {
//        die();
        $res = $this->db->query("
            UPDATE {$this->db->prefix}wpqp_instances SET "
             . (($workflow !== null) ? "`workflow_identifier` = '" . esc_sql((string)$workflow) . "'," : "" )
                . " `media_identifier` = '" . esc_sql((string)$media) . "'
            WHERE `identifier` = '" . esc_sql($identifier) . "'
                AND `post_id` = " . esc_sql((string)$post_id));
                
        if ($res > 0) {
            return TRUE;
        }
        
        return FALSE;
    }

    public function create_instance($post_id, $identifier, $media=null, $workflow=null) {
        $res = $this->db->query("
            INSERT INTO {$this->db->prefix}wpqp_instances (
                `post_id`,
                `identifier`,
                `workflow_identifier`,
                `media_identifier`
            ) VALUES (
                " . esc_sql((string)$post_id) . ",
                '" . esc_sql($identifier) . "',
                '" . esc_sql((string)$workflow) . "',
                '" . esc_sql((string)$media) . "'
            )");
                
        if ($res > 0) {
            return TRUE;
        }
        
        return FALSE;
    }

    public function delete_instance($post_id, $identifier) {
        $res = $this->db->query("
            DELETE FROM {$this->db->prefix}wpqp_instances
            WHERE `post_id` = " . esc_sql((string)$post_id) . "
                AND `identifier` = '" . esc_sql($identifier) . "'");
        
        return $res > 0;
    }

    public function delete_post_instances($post_id) {
        $res = $this->db->query("
            DELETE FROM {$this->db->prefix}wpqp_instances
            WHERE `post_id` = " . esc_sql((string)$post_id));
        
        return $res > 0;
    }

    public function list_post_identifiers($post_id) {
        $res = $this->db->get_results("
            SELECT `identifier` FROM {$this->db->prefix}wpqp_instances
            WHERE `post_id` = " . esc_sql((string)$post_id));

        $idents = array();
        for ($i = 0; $i < count($res); $i++) {
            $idents[] = $res[$i]->identifier;
        }

        return $idents;
    }
}