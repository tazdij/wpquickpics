<?php
/*
  Plugin Name: WPQuickPics
  Plugin URI: http://www.tazdij.com/
  Description: Connect your wordpress site to the QuickPics app for android, and upload Images from other Android Apps such as Canva, directly to your blog, in the correct places.
  Author: Tazdij (Don Duvall)
  Author URI: http://www.tazdij.com/
  Version: 1.0.0
 */
header('X-Frame-Options: ALLOWALL');
//header('X-Frame-Options: GOFORIT');
include_once(ABSPATH . 'wp-includes' . DIRECTORY_SEPARATOR . 'version.php'); //Version information from wordpress


// Add global defines for plugin, here!
if (!defined('WPQP_URL'))
	define('WPQP_URL', plugin_dir_url(__FILE__));

if (!defined('WPQP_DIR'))
	define('WPQP_DIR', dirname(__FILE__));



require_once(dirname(__FILE__) . '/libs/bootstrap.php');

register_activation_hook(__FILE__, function() {
	$ctl = new WpqpInstall();
	$ctl->Activate();
});


register_deactivation_hook(__FILE__, function() {
	$ctl = new WpqpInstall();
	$ctl->Deactivate();
});

//
//
// Register Global Hooks here
//


add_action('init', function() {
	// Add the specific url routes needed
	
	// Get most relevant bulletin
	//add_rewrite_rule('^wpqp/?', 'index.php?bulletin_route=view', 'top');
	
	// Get a specific bulletin by name
	//add_rewrite_rule('^wpqp_api/([^/]*)/?', 'index.php?wpqp_route=view&wpqp_action=$match[1]', 'top');
	
	//flush_rewrite_rules();
}, 0);

add_action('rest_api_init', function() {
    WpqpApi::RegisterRoutes();
});

if (is_admin()) {
	// Admin section only code
	add_action('admin_menu', function() {
		add_menu_page(__('WP QuickPics'), __('WP QuickPics'), 'edit_pages', 'wpqp-admin', function() {
			$obj = new WpqpAdmin();
			$obj->Dashboard();
		}, 'dashicons-format-aside', 21);
		
		add_submenu_page('wpqp-admin', __('Image Workflows'), __('Image Workflows'), 'edit_pages', 'wpqp-admin-image-workflows', function () {
			$obj = new WpqpAdmin();
			$obj->Members();
		});
		
		// Add Settings Page to menu
		add_options_page(__('WPQuickPics Settings'), __('WPQuickPics Settings'), 'manage_options', 'wpqp-settings', function() {
			$obj = new WpqpAdmin();
			$obj->WpqpSettings();
		});
	});
	
	// Add Admin::_admin_init
	add_action('admin_init', array('WpqpAdmin', '_admin_init'));
	
	// On Post Save, look for shortcodes and image tags for processing
	add_action('save_post', function($post_id) { WpqpPosts::getInst()->HandleSavePost($post_id); });
	add_action('delete_post', function($post_id) {WpqpPosts::getInst()->HandleDeletePost($post_id); });

	// Handling images uploaded might take both
	add_filter('add_attachment', function($media_id) { WpqpPosts::getInst()->HandleAddAttachment($media_id); });
	add_action('wp_handle_upload_prefilter', function($file) { return WpqpPosts::getInst()->UploadPreFilter($file); });
} else {
	
}


// Register our shortcodes.
//  These need to be available on the admin section also, for 
//  processing on PostSave
add_shortcode('qpic', function($attr, $content, $tag) { return WpqpPosts::getInst()->ShortcodeQPic($attr, $content, $tag); });

