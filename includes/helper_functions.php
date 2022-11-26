<?php
/**
 * Helper Function
 * Date Created: Oct 1, 2022
 * */
 

function wcforce_eo_print($info){
    echo '<pre>';
    print_r($info);
    echo '</pre>';
}

function wcforce_eo_load_file($file_name, $vars=null) {
         
   if( is_array($vars))
    extract( $vars );
    
   $file_path =  WCFORCE_EO_PATH . '/templates/'.$file_name;
   if( file_exists($file_path))
   	include ($file_path);
   else
   	die('File not found'.$file_path);
}

// return extra fields attached with product
function wcforce_get_extra_fields_for_product_page($product) {
    
    //TODO: get extra fields by product id or categories
    
    $fields = get_option('wcforce_extra_fields');
    return $fields ? $fields : false;
}