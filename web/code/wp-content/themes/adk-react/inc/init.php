<?php

add_action( 'init', '_register_theme_menus' );
add_action( 'init', '_register_taxonomies' );
add_action( 'init', '_register_post_types' );


/**
 * A function to register menus
 *
 * @return void
 */

function _register_theme_menus() {
  register_nav_menu('header-menu',__( 'Header Menu' ));
  register_nav_menu('footer-menu',__( 'Footer Menu' ));
}




/**
 * A function to register custom post types.
 *
 * @return void
 */
function _register_post_types() {

  /* Loop over post types after loading them from config files and register them. */
  $post_types = _get_config_files( 'post-types' );

  foreach ( $post_types as $slug => $type ) {

    /* Define defaults for this post type. */
    $defaults = [
      'labels'      => [
        'name'               => __( $type['labels']['name'] ),
        'singular_name'      => __( $type['labels']['singular_name'] ),
        'menu_name'          => __( $type['labels']['name'] ),
        'all_items'          => __( 'All ' . $type['labels']['name'] ),
        'add_new'            => __( 'Add ' . $type['labels']['singular_name'] ),
        'add_new_item'       => __( 'Add New ' . $type['labels']['singular_name'] ),
        'edit_item'          => __( 'Edit ' . $type['labels']['singular_name'] ),
        'new_item'           => __( 'New ' . $type['labels']['singular_name'] ),
        'view_item'          => __( 'View ' . $type['labels']['singular_name'] ),
        'search_items'       => __( 'Search ' . $type['labels']['singular_name'] ),
        'not_found'          => __( 'No ' . $type['labels']['name'] . ' found' ),
        'not_found_in_trash' => __( 'No ' . $type['labels']['name'] . ' found in Trash' ),
      ],
      'public'      => true,
      'has_archive' => true,
      'supports'    => [
        'title',
        'editor',
        'thumbnail',
        'comments',
        'revisions',
        'excerpt',
        'author',
      ],
    ];

    /* Create args by merging provided configuration with defaults. */
    $type['labels'] = wp_parse_args( $type['labels'], $defaults['labels'] );
    $args           = wp_parse_args( $type, $defaults );

    /* Register the post type. */
    register_post_type( $slug, $args );
  }
}



/**
 * A function to register custom taxonomies.
 *
 * @return void
 */
function _register_taxonomies() {

  /* Loop over taxonomies after loading them from config files and register them. */
  $taxonomies = _get_config_files( 'taxonomies' );
  foreach ( $taxonomies as $slug => $type ) {

    /* Define defaults for this taxonomy. */
    $defaults = [
      'hierarchical'      => true,
      'labels'            => [
        'name'              => __( $type['labels']['name'] ),
        'singular_name'     => __( $type['labels']['singular_name'] ),
        'search_items'      => __( 'Search ' . $type['labels']['name'] ),
        'all_items'         => __( 'All ' . $type['labels']['name'] ),
        'parent_item'       => __( 'Parent ' . $type['labels']['singular_name'] ),
        'parent_item_colon' => __( 'Parent ' . $type['labels']['singular_name'] . ': ' ),
        'edit_item'         => __( 'Edit ' . $type['labels']['singular_name'] ),
        'update_item'       => __( 'Update ' . $type['labels']['singular_name'] ),
        'add_new_item'      => __( 'Add New ' . $type['labels']['singular_name'] ),
        'new_item_name'     => __( 'New ' . $type['labels']['singular_name'] . ' Name' ),
        'menu_name'         => __( $type['labels']['name'] ),
      ],
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => [
        'slug' => $slug,
      ],
    ];

    /* Create args by merging provided configuration with defaults. */
    $type['labels'] = wp_parse_args( $type['labels'], $defaults['labels'] );
    $args           = wp_parse_args( $type, $defaults );

    /* Register the taxonomy. */
    register_taxonomy( $slug, null, $args );
  }
}