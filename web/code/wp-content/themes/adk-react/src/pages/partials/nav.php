<?php // Navigation //

  function themeLogo() {
    $theme_logo_URL = 'http://placehold.it/50x50';

    if ($theme_logo_URL) {
      echo '<img src="'.$theme_logo_URL.'" alt="Logo Image">';
    }
    else {
      echo '<h1>Dockerized WP</h1>';
    }
  }

?>

<header class="c-header navigation" role="banner">
  <div class="o-container">
    <a href="<?php echo site_url(); ?>" class="c-logo">
      <div class="c-logo__image">
        <?php themeLogo(); ?>
      </div>
    </a>
nav
    <nav class="c-nav">
      <button class="c-nav__btn" id="navMenuBtn" aria-expanded="false" aria-controls="js-navigation-menu">
        <span class="c-nav__burger"><span class="u-visually-hidden">Menu</span></span>
      </button>
      <?php
        wp_nav_menu( array(
            'theme_location'	 => 'header-menu',
            'container'			   => 'div',
            'container_class'	 => 'c-nav__menu-container',
            'menu_class'		   => 'c-nav__menu',
            'menu_id'          => 'js-navigation-menu'
          )
        );
      ?>
    </nav>
  </div>
</header>
