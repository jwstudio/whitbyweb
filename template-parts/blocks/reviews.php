<?php
/**
 * Block: Reviews
 * Fields: eyebrow, rating_text, limit, show_all_link, all_url
 * Auto-queries: testimonial CPT ordered by menu_order
 */

$eyebrow       = get_sub_field( 'eyebrow' ) ?: 'Client Testimonials';
$rating_text   = get_sub_field( 'rating_text' ) ?: '5.0 stars from all reviews';
$limit         = (int) ( get_sub_field( 'limit' ) ?: -1 );
$show_all_link = get_sub_field( 'show_all_link' );
$all_url       = get_sub_field( 'all_url' ) ?: '/reviews/';

$query = new WP_Query( [
    'post_type'      => 'testimonial',
    'posts_per_page' => $limit < 1 ? -1 : $limit,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'no_found_rows'  => true,
] );

if ( ! $query->have_posts() ) {
    return;
}

$star_svg    = '<svg width="16" height="16" viewBox="0 0 24 24" fill="#f292c4"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
$star_svg_sm = '<svg width="15" height="15" viewBox="0 0 24 24" fill="#a0a0a0"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
$btn_arrow   = '<span class="btn-arrow"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>';

$avatar_colors = [
    [ 'bg' => 'rgba(242,146,196,0.08)', 'text' => '#f292c4' ],
    [ 'bg' => 'rgba(146,213,242,0.08)', 'text' => '#92d5f2' ],
];
?>
<section class="reviews">
  <div class="container">

    <div class="row reviews-header">
      <div class="col">
        <div class="eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
      </div>
      <div class="col" style="text-align:right">
        <div class="star-rating">
          <div class="star-rating__icons">
            <?php echo str_repeat( $star_svg, 5 ); ?>
          </div>
          <span class="star-rating__text"><?php echo esc_html( $rating_text ); ?></span>
        </div>
      </div>
    </div>

    <div class="row">
      <?php
      $i = 0;
      while ( $query->have_posts() ) :
          $query->the_post();
          $name     = get_the_title();
          $review   = get_field( 'review' );
          $company  = get_field( 'company' );
          $color    = $avatar_colors[ $i % 2 ];
          $initials = implode( '', array_map( fn( $w ) => strtoupper( $w[0] ), explode( ' ', $name ) ) );
          ?>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card card--hoverable">

              <div class="star-row">
                <?php echo str_repeat( $star_svg_sm, 5 ); ?>
              </div>

              <p class="card-quote">"<?php echo esc_html( $review ); ?>"</p>

              <div class="author">
                <div class="avatar" style="background:<?php echo esc_attr( $color['bg'] ); ?>;color:<?php echo esc_attr( $color['text'] ); ?>">
                  <?php echo esc_html( $initials ); ?>
                </div>
                <div>
                  <div class="author-name"><?php echo esc_html( $name ); ?></div>
                  <div class="author-meta"><?php echo esc_html( $company ); ?></div>
                </div>
              </div>

            </div>
          </div>
          <?php
          $i++;
      endwhile;
      wp_reset_postdata();
      ?>
    </div>

    <?php if ( $show_all_link ) : ?>
      <div class="work-footer">
        <a href="<?php echo esc_url( $all_url ); ?>" class="btn btn-secondary">
          See all reviews
          <?php echo $btn_arrow; // phpcs:ignore ?>
        </a>
      </div>
    <?php endif; ?>

  </div>
</section>
