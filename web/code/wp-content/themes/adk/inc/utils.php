<?php
/*
|--------------------------------------------------------------------
| Utility Functions
|--------------------------------------------------------------------
*/

// Better Debugging
function printr($var) {
  echo '<pre>'; print_r($var); echo '</pre>';
};

// Helper funciton to exclude tracking codes from staging sites
$url            = site_url();
$staging_sites  = array ('localhost', 'adkalpha');

function strpos_array($haystack, $needle, $offset=0) {
  if(!is_array($needle)) $needle = array($needle);

  foreach($needle as $query) {
    if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
  }
  return false;
}



/**
 * A function to get an array of config files given a folder name in the assets directory.
 *
 * @param string $path The path to the folder in the inc directory
 * @return array An array of config files.
 */
function _get_config_files( $path ) {

  /* Initialize return variable. */
  $configs = [ ];

  /* Determine if the requested path exists. */
  $basepath = __DIR__ . '/' . $path;

  if ( ! is_dir( $basepath ) ) {
    return $configs;
  }

  /* Loop through configs and add them. */
  $items = scandir( $basepath );
  foreach ( $items as $item ) {
    $filepath = $basepath . '/' . $item;

    /* Ensure this is a file and not a directory. */
    if ( ! is_file( $filepath ) ) {
      continue;
    }

    /* Ensure this is a JSON file. */
    if ( strtolower( substr( $filepath, - 5 ) ) !== '.json' ) {
      continue;
    }

    /* Try to get file contents. */
    $config = file_get_contents( $filepath );
    if ( empty( $config ) ) {
      continue;
    }

    /* Try to decode the JSON. */
    $config = json_decode( $config, true );
    if ( empty( $config ) ) {
      continue;
    }

    /* Add the config to the return array. */
    $configs[ substr( $item, 0, - 5 ) ] = $config;
  }

  return $configs;
}

/**
 * A function to register page specific js files
 *
 * @param string $pagename The name of the page file
 */
function register_page_script ($pagename) {
  global $wp_scripts;

  $pageJS = asset_file_name($pagename . '.js');
  $path = get_template_directory_uri() . '/dist' . $pageJS;

  if(file_exists(get_stylesheet_directory() . '/dist' . $pageJS)) {
    wp_register_script( $pagename . '-js', $path, '', '', true );
    $wp_scripts->page_script = $pagename . '-js';
  }
}

/**
 * Gets the file name with hash tag from manifest json file
 *
 * @param  string  $filename
 * @return string
 */
function asset_file_name($filename) {
  $manifest_path = get_stylesheet_directory() . '/dist/manifest.json';

  if (file_exists($manifest_path)) {
    $manifest = json_decode(file_get_contents($manifest_path), TRUE);
  } else {
    $manifest = [];
  }

  if (array_key_exists($filename, $manifest)) {
      return $manifest[$filename];
  }

  return $filename;
}

/**
 * A function to generate random alphanumeric strings
 *
 */
function random_id() {
  $permitted_chars = 'abcdefghijklmnopqrstuvwxyz';

  return substr(str_shuffle($permitted_chars), 0, 10);
}

/**
 * Get a template component
 *
 * @param string $component_slug The template name
 */
function get_theme_component( $component_slug ) {
  if ($component_slug !== "") {
    global $base;
    get_template_part( "$base/pages/components/$component_slug" );
  }
}


/**
 * Output ACF link field
 *
 * @param object $link a link ACF field
 * @param string $class classes to apply to the a tag
 */
function btn_link($link, $class ) {
  $attributes = '';

  if($link['url'] !== '') :
    $attributes .= '<a href="'. $link['url'] . '" class="' . $class;
  else :
    return '';
  endif ;

  if($link['target'] !== '') :
    $attributes .= '" target="'. $link['target'] . '" >';
  else :
    $attributes .= '" >';
  endif ;

  if($link['title'] !== '') :
    $attributes .= $link['title'];
  endif ;

  $attributes .= '</a>';

  return $attributes;
}
