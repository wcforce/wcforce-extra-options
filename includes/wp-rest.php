<?php
/**
 * Rest API Handling
 * 
 * */

if( ! defined('ABSPATH') ) die('Not Allowed.');

add_action( 'rest_api_init', function()
    {
        header( "Access-Control-Allow-Origin: *" );
    }
);



/* == rest api == */
add_action( 'rest_api_init', 'wcforce_eo_rest_api_register'); // endpoint url 
function wcforce_eo_rest_api_register() {
    
    register_rest_route('wcforce/v1', '/save_extra_fields', array(
        'methods' => 'POST',
        'callback' => 'wcforce_save_extra_fields',
        'permission_callback' => '__return_true',
    ));
    
}


function wcforce_save_extra_fields($request){
    
    if( ! $request->sanitize_params() ) {
        wp_send_json_error( ['message'=>$request->get_error_message()] );
    }
    
    $data   = $request->get_params();
    $extra_fields = $data['fields'];
    
    update_option('wcforce_extra_fields', $extra_fields);
    
    wp_send_json($extra_fields);
}

function wcforce_eo_get_order_amount($request) {
    
    $data = $request->get_params();
    
    $order = wc_get_order($data['order_id']);
    
    wp_send_json(['order_total' => $order->get_total()]);
}