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