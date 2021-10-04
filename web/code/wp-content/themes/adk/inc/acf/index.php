<?php

if ( function_exists('acf_add_local_field_group') ) {

	/**
	 * Set Up JSON Syncing
	 */

	add_filter('acf/settings/save_json', 'base_acf_json_save_point');

	function base_acf_json_save_point( $path ) {

		// update path
		$path = get_stylesheet_directory() . '/inc/acf/json-sync';

		// return
		return $path;
	}

	add_filter('acf/settings/load_json', 'base_acf_json_load_point');

	function base_acf_json_load_point( $paths ) {

		// remove original path (optional)
		unset($paths[0]);

		// append path
		$paths[] = get_stylesheet_directory() . '/inc/acf/json-sync';

		// return
		return $paths;
  }
}

/**
 * ACF - Add options page
 */

// Add options page for AFC
// if ( function_exists('acf_add_options_page') ) {
//   acf_add_options_page();
// }
