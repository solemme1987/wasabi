<?php
/**
 * Enqueue all styles and scripts
 *
 * Learn more about enqueue_script: {@link https://codex.wordpress.org/Function_Reference/wp_enqueue_script}
 * Learn more about enqueue_style: {@link https://codex.wordpress.org/Function_Reference/wp_enqueue_style }
 */

/** Enqueue scripts and styles */
function base_scripts() {
  global $wp_scripts;

	if (!is_admin()) {

    //Enqueue main style.css
    $styleCSS = asset_file_name('global.css');

    wp_enqueue_style( 'style', get_template_directory_uri() . '/dist' . $styleCSS, null, null );

    // wp_enqueue_script('jquery');

    // enqueue page specific script
    if(isset($wp_scripts->page_script)) {
      wp_enqueue_script($wp_scripts->page_script);
    }

    //Enqueue global js
    $vendorJS = asset_file_name('vendor.js');
    $globalJS = asset_file_name('global.js');
    wp_enqueue_script( 'vendor', get_template_directory_uri() . '/dist' . $vendorJS, array());
    wp_enqueue_script( 'global', get_template_directory_uri() . '/dist' . $globalJS, array('vendor'));

	}
}
add_action( 'wp_enqueue_scripts', 'base_scripts' );
