<?php
/**
 * Rest API Handling
 * 
 * */

if( ! defined('ABSPATH') ) die('Not Allowed.');


class WCFORCE_WP_REST {
	
	private static $ins = null;
	
	public static function __instance()
	{
		// create a new object if it doesn't exist.
		is_null(self::$ins) && self::$ins = new self;
		return self::$ins;
	}
	
	public function __construct() {
		
		add_action( 'rest_api_init', function()
            {
                header( "Access-Control-Allow-Origin: *" );
            }
        );
		
		add_action( 'rest_api_init', [$this, 'init_api'] ); // endpoint url
		// cart and order meta data
		add_filter ( 'woocommerce_get_item_data', [$this, 'add_item_meta'], 10, 2 );
	}
	
	
	function init_api() {
        
        register_rest_route('wcforce/v1', '/save_extra_fields', array(
            'methods' => 'POST',
            'callback' => [$this, 'save_extra_fields'],
            'permission_callback' => '__return_true',
        ));
        
    }
    
    
    function save_extra_fields($request){
    
        if( ! $request->sanitize_params() ) {
            wp_send_json_error( ['message'=>$request->get_error_message()] );
        }
        $data   = $request->get_params();
        
        $field_obj = new WCForce_Field();
        
        $response = $field_obj->add_field($data['title'],$data['meta']);
        
        wp_send_json_success($response);
        
        $extra_fields = $data['fields'];
        
        update_option('wcforce_extra_fields', $extra_fields);
        
        wp_send_json($extra_fields);
    }
}

function init_wcforce_wp_rest(){
	return WCFORCE_WP_REST::__instance();
}