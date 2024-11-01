<?php
/**
 * Thumbnail Before Content
 *
 * Plugin Name:       Thumbnail Before Content
 * Plugin URI:        https://adamainsworth.co.uk/plugins/
 * Description:		  Automatically inserts the post thumbnail (featured image) before the post content
 * Version:           1.0.0
 * Author:            Adam Ainsworth
 * Author URI:        https://adamainsworth.co.uk/
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       thumbnail-before-content
 * Domain Path:       /languages
 * Requires at least: 3.0.1
 * Tested up to:      5.8.1
 */

 // redirect if some comes directly
if ( ! defined( 'WPINC' ) && ! defined( 'ABSPATH' ) ) {
	header('Location: /'); die;
}

// check that we're not defined somewhere else
if ( ! class_exists( 'Thumbnail_Before_Content' ) ) {
	class Thumbnail_Before_Content {
		private function __construct() {}

		public static function activate() {
	        if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			// any activation code here
		}

		public static function deactivate() {
	        if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			// any deactivation code here
		}

		public static function uninstall() {
	        if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}

			if ( __FILE__ !== WP_UNINSTALL_PLUGIN ) {
				return;
			}
			 
			$option_name = 'prefix_options';
			delete_option($option_name);
			delete_site_option($option_name);
		}

		public static function init() {
			add_filter( 'the_content', [__CLASS__, 'thumbnail_before_content']);
		}

		public static function thumbnail_before_content($content) {
			global $post;
			$new_content = '<p>' . get_the_post_thumbnail( $post -> ID, 'full' ) . '</p>';
	
			return $new_content . $content;
		}
	}

	register_activation_hook( __FILE__, [ 'Thumbnail_Before_Content', 'activate' ] );
	register_deactivation_hook( __FILE__, [ 'Thumbnail_Before_Content', 'deactivate' ] );
	register_uninstall_hook( __FILE__, [ 'Thumbnail_Before_Content', 'uninstall' ] );
	add_action( 'plugins_loaded', [ 'Thumbnail_Before_Content', 'init' ] );
}
