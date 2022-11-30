<?php
/**
 * WooCommerce class to handle WC related hooks/filters
 * Date Created: November 24, 2022
 * */
 
class WCFORCE_WooCommerce {
	
	private static $ins = null;
	
	public static function __instance()
	{
		// create a new object if it doesn't exist.
		is_null(self::$ins) && self::$ins = new self;
		return self::$ins;
	}
	
	public function __construct() {
		
		// Rendering extra fields
		add_action ( 'woocommerce_before_add_to_cart_button', [$this, 'show_fields'] );
		// Adding meta to cart form product page
		add_filter ( 'woocommerce_add_cart_item_data', [$this, 'add_cart_item_data'], 10, 2);
		// cart and order meta data
		add_filter ( 'woocommerce_get_item_data', [$this, 'add_item_meta'], 10, 2 );
	}
	
	// rendering extra fields on product page
	function show_fields(){
		
		global $product;
		// fields found
		$extra_fields = wcforce_get_extra_fields_for_product_page($product);
		if( !$extra_fields ) return '';
		
		// bootsratp react-app
	    $react_css = '//nmedia82.github.io/wcmore-extra-options/static/css/main.e5096872.css';
		$react_js  = '//nmedia82.github.io/wcmore-extra-options/static/js/main.d6451359.js';
		wp_enqueue_style('wcforce-eo-admin-css', $react_css);
	    wp_enqueue_script('wcforce-eo-react-js', $react_js, [], WCFORCE_EO_VERSION, true );
	    
	    $js_vars = ['api_url' => get_rest_url(null, 'wcforce/v1')];
	    
	    // wp_enqueue_script('wcforce-eo-admin-js', WCFORCE_EO_URL.'/assets/js/admin.js', [], WCFORCE_EO_VERSION, true );
	    wp_enqueue_script('wcforce-eo-react-methods', WCFORCE_EO_URL.'/assets/js/react.methods.js', [], WCFORCE_EO_VERSION, true );
	    wp_localize_script('wcforce-eo-react-methods', 'wcforce_vars', $js_vars);
		
		// wcforce_eo_print($extra_fields);
		
	    echo '<script>window.wcforce_saved_fields=\''.$extra_fields.'\';</script>';
	    
		echo apply_filters('wcforce_render_root', '<div id="wcforce-rendering"></div>');
		
	}
	 
	
	// Adding extra fields to cart
	function add_cart_item_data($cart, $product_id) {
	    
		if( ! isset($_POST['wcforce_cart_data']) ) return $cart;
		
		// ADDED WC BUNDLES COMPATIBILITY
		if ( function_exists('wc_pb_is_bundled_cart_item') && wc_pb_is_bundled_cart_item( $cart )) {
			return $cart;
		}
		
	    $wcforce_data = json_decode( stripslashes($_POST['wcforce_cart_data']), true );
	    
	    // wcforce_eo_print( $wcforce_data ); exit;
		
		$cart['wcforce_data'] = apply_filters('wcforce_cart_item_data', $wcforce_data);
		
		return $cart;
	}
	
	// Showing in cart/checkout/order
	function add_item_meta($item_meta, $cart_item) {

		if( ! isset($cart_item['wcforce_data']) ) return $item_meta;
		
		// wcforce_eo_print($cart_item['wcforce_data']);
		
		return $item_meta;
		
	}
}

function init_wcforce_woocommerce(){
	return WCFORCE_WooCommerce::__instance();
}