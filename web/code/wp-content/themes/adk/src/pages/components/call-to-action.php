<?php // Call to Action Component

  global $is_page_builder;

  if( $is_page_builder ){
    $call_to_action_text   = get_sub_field( 'call_to_action_text' );
    $call_to_action_button = get_sub_field( 'call_to_action_button' );
  } else {
    extract( get_fields() );
  }

  if( $call_to_action_text ) :
?>

<section class="c-cta u-mvsection">
  <div class="o-container">
    <p class="c-cta__text"><?php echo $call_to_action_text; ?></p>
    <?php echo btn_link( $call_to_action_button, 'c-cta__btn c-btn c-btn--lg c-btn--primary'); ?>
  </div>
</section>

<?php endif; ?>
