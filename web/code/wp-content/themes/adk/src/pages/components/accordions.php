<?php // Accordions Component

  global $is_page_builder;

  if( $is_page_builder ) {
    $accordions_top_content = get_sub_field( 'accordions_top_content' );
  } else {
    extract(get_fields());
  }

  $accordion = 1;

  if( have_rows( 'accordions') ) :

?>

<section class="c-accordion">
  <div class="o-container">
    <div class="o-grid o-grid--center">
      <div class="o-grid__col u-7/12@md">
        <?php echo $accordions_top_content; ?>
        <div id="accordionGroup-" class="js-accordion" data-active="0" data-single="1">

          <ul class="c-accordion__controls">
            <?php while( have_rows( 'accordions' ) ) : the_row();
              $title = get_sub_field( 'title' );
              $content = get_sub_field( 'content' );

              if( $title || $content ) : ?>

                <li>
                  <?php if( $title ) : ?>
                    <button class="c-accordion__button" aria-controls="content-<?php echo $accordion; ?>" aria-expanded="false" id="accordion-control-<?php echo $accordion; ?>">
                      <span class="c-accordion__title c-heading"><?php echo $title; ?></span>
                    </button>
                  <?php endif;
                  if( $content ) : ?>
                    <div aria-hidden="true" id="content-<?php echo $accordion; ?>" class="c-wysiwyg u-mh u-mvx3">
                      <?php echo $content; ?>
                    </div>
                  <?php endif; ?>
                </li>

              <?php endif;
              $accordion++;
              endwhile; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<?php endif; ?>