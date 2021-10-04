<?php // Text Blcok Component

  global $is_page_builder;

  if( $is_page_builder ) {
    $text_block_content = get_sub_field( 'text_block_content' );
  } else {
    $text_block_content = get_field( 'text_block_content' );
  }

  if( $text_block_content !== '' ) :

?>

<section class="c-text-block">
  <div class="o-container">

  <div class="c-text-block__content">
    <div class="c-wysiwyg c-wysiwyg--text-block">
      <?php echo $text_block_content; ?>
    </div>
  </div>
  </div>
</section>

<?php endif; ?>
