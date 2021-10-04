<?php

/*
|--------------------------------------------------------------------
|  Assembles a page with head, body & footer
|--------------------------------------------------------------------
*/

$base           = "dist"; // change to "src" if you want to enqueue files from '/src' directory
$theme_dir      = get_template_directory() . "/" . $base;
$theme_dir_uri  = get_template_directory_uri() . "/" . $base;

function assemble_template($pagename) {
  global $theme_dir;
  global $theme_dir_uri;

  if ( function_exists('register_page_script') ) {
    register_page_script($pagename);
  }

  if (!file_exists("$theme_dir/pages/$pagename.php")) {
    echo "template file not found, was looking for: ".$pagename;
    $pagename = "status404";
  }

  include "$theme_dir/pages/partials/header.php";
  include "$theme_dir/pages/partials/nav.php";
  include "$theme_dir/pages/$pagename.php";
  include "$theme_dir/pages/partials/footer.php";
}
