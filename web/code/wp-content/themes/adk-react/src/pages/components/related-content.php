<?php // Related Content Component

  global $is_page_builder, $acf_fields;

  if( $is_page_builder ){
    $related_resources_heading        = get_sub_field( 'related_resources_heading' );
    $related_resources_all_post_link  = get_sub_field( 'related_resources_all_post_link' );
    $related_resources_post_selection = get_sub_field( 'related_resources_post_selection' );
    $related_resources_posts          = get_sub_field( 'related_resources_posts' );
  } else {
    extract( $acf_fields );
  }

  $post_type = get_post_type() || '';
  $category = get_the_category() || array();
  $current_id = '';

  if( is_single() ) {
    $current_id = get_the_ID();
  }

  if( $related_resources_post_selection == 'latest' ) {

    $args = array (
      'post_type'      => $post_type,
      'post_status'    => 'publish',
      'post__not_in'   => array( $current_id ),
      'posts_per_page' => 3,
      'orderby'        => 'date',
      'order'          => 'DESC',
    );

    $query = new WP_Query( $args );

  } else if( $related_resources_post_selection == 'manual' ) {
    $fields = $related_resources_posts;
  } else if( $related_resources_post_selection == 'related by category' ) {

    // $category =  $terms[0]->slug;

    $args = array (
      'post_type'      => $post_type,
      'post_status'    => 'publish',
      'post__not_in'   => array( $current_id ),
      'posts_per_page' => 3,
      'orderby'        => 'rand',
      'tax_query'      => array(
        array(
          'taxonomy' => 'category',
          'field' => 'slug',
          'terms' => $category[0],
        )
      ),
    );

    $query = new WP_Query( $args );
  }

  if( $related_resources_heading || $related_resources_all_post_link ) {

?>

  <section class="u-mvstd">
    <div class="o-container">

      <div class="o-grid o-grid--center">
        <div class="o-grid__col u-10/12@md">
          <div class="o-grid">

            <div class="o-grid__col u-12/12 u-mb">
              <div class="c-resources__filter">
                <h1 class="c-heading c-heading--l4"><?php echo $related_resources_heading; ?></h1>
                <?php echo btn_link( $related_resources_all_post_link, 'c-link c-link--lg c-link--primary u-hidden u-inline-block@sm' ); ?>
              </div>
            </div>
          </div>
          <div class="o-grid">

            <?php
            if ( $related_resources_post_selection == 'manual' ) {
              if ( $fields ) {
                foreach( $fields as $post ){
                  setup_postdata( $post );
                  $post_ID = get_the_ID();
                  $terms = get_the_terms( $post_ID, 'category' );
                  $tax = $terms[0]->name;
                  $thumbnail_id = get_post_thumbnail_id( $post_ID );
                  $alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true ); ?>

                  <div class="c-resource__entry o-grid__col u-4/12@sm u-mbx2sm">
                    <a href="<?php echo get_the_permalink(); ?>" class="c-post__entry">
                      <div class="c-resources__thumb u-bgimg u-mbx2 u-shadow-2" style="background-image: url(<?php echo get_the_post_thumbnail_url( null, 'post-thumbnail' ); ?>)" role="img" aria-label="<?php echo $alt; ?>"></div>
                      <div class="c-link c-link--sm u-color-grey-3 u-mbx"><?php echo $tax; ?></div>
                      <div class="c-heading c-heading--l6"><?php echo get_the_title(); ?></div>
                    </a>
                  </div>
            <?php
                  wp_reset_postdata();
                }
              }
            }
            if ( $related_resources_post_selection == 'latest' || $related_resources_post_selection =='related by category' ) {
              if( $query->have_posts() ) {
                while( $query->have_posts() ) {
                  $post_ID = get_the_ID();
                  $thumbnail_id = get_post_thumbnail_id( $post_ID );
                  $alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
                  $query->the_post();
                ?>

                  <div class="c-resources__entry o-grid__col u-4/12@sm u-mbx2sm">
                    <a href="<?php echo get_the_permalink(); ?>" class="c-post__entry">
                      <div class="c-resources__thumb u-bgimg u-mbx2 u-shadow-2" style="background-image: url(<?php echo get_the_post_thumbnail_url( null, 'post-thumbnail' ); ?>)" role="img" aria-label="<?php echo $alt; ?>"></div>
                      <div class="c-link c-link--sm"><?php echo $tax; ?></div>
                      <div class="c-heading c-heading--l6"><?php echo get_the_title(); ?></div>
                    </a>
                  </div>
                <?php }
                }
            } ?>
          </div>
          <?php echo btn_link( $related_resources_all_post_link, 'c-btn c-btn--sm c-btn--secondary u-block u-hidden@sm' ); ?>
        </div>
      </div>
    </div>
  </section>

  <?php
  wp_reset_postdata();
} ?>