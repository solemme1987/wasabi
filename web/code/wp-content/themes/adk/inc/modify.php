<?php
/*
|--------------------------------------------------------------------
| Modify default WP behavior
|--------------------------------------------------------------------
*/

/**
* Disable guten-blocks
*/

add_filter( 'allowed_block_types', 'adk_allowed_block_types' );
function adk_allowed_block_types( $allowed_blocks ) {
  return array(
    'core/image',
    'core/paragraph',
    'core/heading',
    'core/list'
  );
}

/**
* Disable Gutenberg editor globally
*/
add_filter('use_block_editor_for_post', '__return_false');


/**
* Denied access to local user if we are not in localhost
*/
function block_local_user ($user, $email, $password) {
  if (!isset($user->errors)) {
    $is_dev = strpos(site_url(), 'localhost');
    $username = get_the_author_meta( 'user_login', $user->ID );
    if (!$is_dev && $username == 'localuser') {
      $error = new WP_Error();
      $error->add('access_expired', __('Unknown username. Check again or try your email address.'));
      return $error;
    }
  }

  return $user;

}

add_filter('authenticate', 'block_local_user', 20 ,3);