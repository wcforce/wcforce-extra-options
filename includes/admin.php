<?php
/**
 * WP Admin Related Stuff
 * Created Date: November 2, 2022
 * Created By: Ben Rider
 * */
 
class WCForce_EO_Admin {
    
    function __construct(){
        
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }
    
 
   function admin_menu() {
        
        $parent = 'woocommerce';
        $hook = add_submenu_page(
            $parent,
             __('WCForce - Create Extra Options for WooCommerce Products', 'wcforce-eo'),
             __('WCForce-ExtraOptions', 'wcforce-eo') ,
            'manage_options',
            'wcforce-extraoptions',
            array(
                $this,
                'extra_options_page'
            ),
            35
        );
        
        // script will be only loaded for this current settings page, not all the pages.
        add_action( 'load-'. $hook, [$this, 'load_scripts'] );
    }
    
    function load_scripts() {
        
        $extra_fields = get_option('wcforce_extra_fields');
        // wcforce_eo_print($extra_fields);
        echo '<script>window.wcforce_saved_fields=\''.json_encode($extra_fields).'\';</script>';
        wp_enqueue_media();
        
        $react_js  = '//nmedia82.github.io/wcmore-extra-options/static/js/main.34a53af4.js';
        $react_css = '//nmedia82.github.io/wcmore-extra-options/static/css/main.036895ef.css';
        
        wp_enqueue_style('wcforce-eo-admin-css', $react_css);
        wp_enqueue_script('wcforce-eo-react-js', $react_js, [], WCFORCE_EO_VERSION, true );
        
        $js_vars = ['api_url' => get_rest_url(null, 'wcforce/v1')];
        
        wp_enqueue_script('wcforce-eo-admin-js', WCFORCE_EO_URL.'/assets/js/admin.js', [], WCFORCE_EO_VERSION, true );
        wp_enqueue_script('wcforce-eo-react-methods', WCFORCE_EO_URL.'/assets/js/react.methods.js', [], WCFORCE_EO_VERSION, true );
        wp_localize_script('wcforce-eo-react-methods', 'wcforce_vars', $js_vars);
    }
    
    
    function extra_options_page() {
        
        add_thickbox();
                
        ob_start();
        wcforce_eo_load_file('extra-options.php', []);
        echo ob_get_clean();
    }
    
    function wcforce_call_wp(){
        
        wp_send_json($_POST);
    }
}

new WCForce_EO_Admin;