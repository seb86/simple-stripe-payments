<?php

// If this file is called directly, abort. 
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

add_action( 'admin_enqueue_scripts', 'color_picker_assets' );

function color_picker_assets($hook_suffix) {
	    wp_enqueue_style( 'wp-color-picker' );
	    wp_enqueue_script( 'my-script-handle', plugins_url('../assets/js/custom.js', __FILE__  ), array( 'wp-color-picker' ), false, true );
	    wp_enqueue_style( 'custom-css' , plugins_url('../assets/css/backend-style.css', __FILE__  ) );
}