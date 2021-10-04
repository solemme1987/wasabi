<?php
/**
 * Page Builder component
 */
global $is_page_builder;

if ( function_exists('have_rows') ) {
  if ( have_rows( 'page_builder' ) ) {
    $is_page_builder = true;
    while ( have_rows( 'page_builder' ) ) {
      the_row();
      get_theme_component( get_row_layout() );
    }
  }
}