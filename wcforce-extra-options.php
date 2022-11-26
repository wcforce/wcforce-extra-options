<?php
/**
 * Plugin Name:       WCMORE WooCommerce Product Manager
 * Plugin URI:        https://wcforce.com/
 * Description:       Create extra fields and options for WooCommerce Products quickly.
 * Author:            wcforce
 * Author URI:        https://wcforce.com/
 * License:           GPL v2 or later
 *
 * Text Domain:       wcforce-eo
 */
 
define('WCFORCE_EO_PATH', untrailingslashit(plugin_dir_path( __FILE__ )) );
define('WCFORCE_EO_URL', untrailingslashit(plugin_dir_url( __FILE__ )) );
define('WCFORCE_EO_VERSION', '1.0' );

include_once WCFORCE_EO_PATH.'/includes/helper_functions.php';
include_once WCFORCE_EO_PATH.'/includes/woocommerce.php';
include_once WCFORCE_EO_PATH.'/includes/wp-rest.php';
include_once(WCFORCE_EO_PATH.'/includes/admin.php');

     
function wcforce_eo_init(){
    
    add_action( 'wp_enqueue_scripts', 'wpdocs_my_enqueue_scripts' );
    
    // rendering extra fields
	add_action ( 'woocommerce_before_add_to_cart_button', 'wcforce_woocommerce_show_fields', 15);
    // Adding meta to cart form product page
	add_filter ( 'woocommerce_add_cart_item_data', 'wcforce_woocommerce_add_cart_item_data', 10, 2);
 
}

add_action('woocommerce_init', 'wcforce_eo_init');