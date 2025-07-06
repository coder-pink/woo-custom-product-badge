<?php
/**
 * Plugin Name: Woo Custom Product Badge
 * Description: Adds a custom badge to WooCommerce products.
 * Version: 1.0
 * Author: Pinky
 * Text Domain: woo-custom-product-badge
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Woo_Custom_Product_Badge {

    public function __construct() {
        define( 'WCPB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

        // Load Classes
        require_once WCPB_PLUGIN_DIR . 'includes/class-product-badge-meta-box.php';
        require_once WCPB_PLUGIN_DIR . 'includes/class-product-badge-display.php';

        if ( is_admin() ) {
            require_once WCPB_PLUGIN_DIR . 'includes/class-product-badge-admin-filter.php';
            new WCPB_Product_Badge_Admin_Filter(); 
        }

        require_once WCPB_PLUGIN_DIR . 'includes/class-product-badge-shortcode.php';

      
        new WCPB_Product_Badge_Meta_Box();
        new WCPB_Product_Badge_Display();
        new WCPB_Product_Badge_Shortcode();
    }
}

new Woo_Custom_Product_Badge();
