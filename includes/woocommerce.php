<?php
/**
 * WooCommerce related hooks/filters
 * Date Created: November 24, 2022
 * */
 

// rendering extra fields on product page
function wcforce_woocommerce_show_fields(){
	
	global $product;
	// fields found
	$extra_fields = wcforce_get_extra_fields_for_product_page($product);
	if( !$extra_fields ) return '';
	
	// wcforce_eo_print($extra_fields);
	
    echo '<script>window.wcforce_saved_fields=\''.json_encode($extra_fields).'\';</script>';
    
	echo apply_filters('wcforce_render_root', '<div id="wcforce-rendering"></div>');
	
	// bootsratp react-app
    $react_css = '//nmedia82.github.io/wcmore-extra-options/static/css/main.036895ef.css';
	$react_js  = '//nmedia82.github.io/wcmore-extra-options/static/js/main.34a53af4.js';
	wp_enqueue_style('wcforce-eo-admin-css', $react_css);
    wp_enqueue_script('wcforce-eo-react-js', $react_js, [], WCFORCE_EO_VERSION, true );
    
    $js_vars = ['api_url' => get_rest_url(null, 'wcforce/v1')];
    
    // wp_enqueue_script('wcforce-eo-admin-js', WCFORCE_EO_URL.'/assets/js/admin.js', [], WCFORCE_EO_VERSION, true );
    wp_enqueue_script('wcforce-eo-react-methods', WCFORCE_EO_URL.'/assets/js/react.methods.js', [], WCFORCE_EO_VERSION, true );
    wp_localize_script('wcforce-eo-react-methods', 'wcforce_vars', $js_vars);

}
 

// Adding extra fields to cart
function wcforce_woocommerce_add_cart_item_data($cart, $product_id) {
    
    $wcforce_data = isset($_POST['wcforce_cart_data']) ? $_POST['wcforce_cart_data'] : "";
    
    wcforce_eo_print( json_decode( stripslashes($wcforce_data), true ) ); exit;
	
	if( ! isset($_POST['ppom']) ) return $cart;
	
	$ppom		= new PPOM_Meta( $product_id );
	if( ! $ppom->ppom_settings ) return $cart;
	
	// ADDED WC BUNDLES COMPATIBILITY
	if ( function_exists('wc_pb_is_bundled_cart_item') && wc_pb_is_bundled_cart_item( $cart )) {
		return $cart;
	}
	
	// PPOM also saving cropped images under this filter.
	$ppom_posted_fields = apply_filters('ppom_add_cart_item_data', $_POST['ppom'], $_POST);
	$cart['ppom'] = $ppom_posted_fields;
	
	return $cart;
}