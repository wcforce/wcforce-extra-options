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
include_once WCFORCE_EO_PATH.'/includes/wc.class.php';
include_once WCFORCE_EO_PATH.'/includes/field.class.php';
include_once WCFORCE_EO_PATH.'/includes/wprest.class.php';
include_once(WCFORCE_EO_PATH.'/includes/admin.php');

     
function wcforce_eo_init(){
    
	init_wcforce_wp_rest();
	init_wcforce_woocommerce();
	
// 	add_action('admin_init', 'wcforce_eo_disable_post_revisions');
	
    // add_action( 'wp_enqueue_scripts', 'wcforce_enqueue_scripts', 999 );
    // rendering extra fields
}

function wcforce_eo_disable_post_revisions(){
    remove_post_type_support('wcfoce_eo', 'revisions');
}

function wcforce_enqueue_scripts(){
    
    // bootsratp react-app
    //     $react_css = '//nmedia82.github.io/wcmore-extra-options/static/css/main.036895ef.css';
    // 	$react_js  = '//nmedia82.github.io/wcmore-extra-options/static/js/main.34a53af4.js';

	$react_css = WCFORCE_EO_URL.'/assets/react/static/css/main.036895ef.css';
	$react_js  = WCFORCE_EO_URL.'/assets/react/static/js/main.34a53af4.js';
	wp_enqueue_style('wcforce-eo-admin-css', $react_css);
    wp_enqueue_script('wcforce-eo-react-js', $react_js, ['jquery'], WCFORCE_EO_VERSION, true );
    
    $js_vars = ['api_url' => get_rest_url(null, 'wcforce/v1')];
    
    // wp_enqueue_script('wcforce-eo-admin-js', WCFORCE_EO_URL.'/assets/js/admin.js', [], WCFORCE_EO_VERSION, true );
    wp_enqueue_script('wcforce-eo-react-methods', WCFORCE_EO_URL.'/assets/js/react.methods.js', [], WCFORCE_EO_VERSION, true );
    wp_localize_script('wcforce-eo-react-methods', 'wcforce_vars', $js_vars);
}

add_action('plugins_loaded', 'wcforce_eo_init');