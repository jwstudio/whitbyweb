<?php
/**
 * Block: Work / Projects
 * Fields: eyebrow, heading_lines, lead, limit, show_all_link, all_url
 * Category: project_type taxonomy (colour from ACF term field)
 * Auto-queries: project CPT ordered by menu_order
 */

$eyebrow       = get_sub_field( 'eyebrow' );
$lead          = get_sub_field( 'lead' );
$limit         = (int) ( get_sub_field( 'limit' ) ?: -1 );
$show_all_link = get_sub_field( 'show_all_link' );
$all_url       = get_sub_field( 'all_url' ) ?: '/work/';

$query = new WP_Query( [
    'post_type'      => 'project',
    'posts_per_page' => $limit < 1 ? -1 : $limit,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'no_found_rows'  => true,
] );

if ( ! $query->have_posts() ) {
    return;
}

$btn_arrow  = '<span class="btn-arrow"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>';
$check_icon = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#92d5f2" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
?>
<section class="work">
  <div class="container">

    <div class="row work-header">
      <div class="col-12 col-lg-6">
        <?php if ( $eyebrow ) : ?>
          <div class="eyebrow" style="margin-bottom:16px;"><?php echo esc_html( $eyebrow ); ?></div>
        <?php endif; ?>
        <?php whitbyweb_render_heading( 'heading_lines', 'h2', 'section-heading' ); ?>
      </div>
      <?php if ( $lead ) : ?>
        <div class="col-12 col-lg-6 work-header__sub">
          <p class="text-lead" style="margin-bottom:0;"><?php echo esc_html( $lead ); ?></p>
        </div>
      <?php endif; ?>
    </div>

    <?php
    $index = 0;
    while ( $query->have_posts() ) :
        $query->the_post();

        $body        = get_field( 'project_body' );
        $outcomes    = get_field( 'project_outcomes' );
        $browser_url = get_field( 'project_browser_url' );
        $screenshot  = get_field( 'project_screenshot' );
        $placeholder = get_field( 'project_placeholder_color' ) ?: 'blue';

        // Category from taxonomy
        $terms      = get_the_terms( get_the_ID(), 'project_type' );
        $term       = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
        $term_name  = $term ? $term->name : '';
        $term_color = $term ? ( get_field( 'term_color', 'project_type_' . $term->term_id ) ?: '#92d5f2' ) : '#92d5f2';

        $is_reverse = $index % 2 !== 0;
        $mod_class  = $is_reverse ? ' work-project--reverse' : '';
    ?>
    <div class="work-project<?php echo esc_attr( $mod_class ); ?>">
      <div class="row align-items-center">

        <?php
        // ── Visual column ────────────────────────────────────────────────
        $visual_col  = '<div class="col-12 col-lg-7 work-project__visual-col">';
        $visual_col .= '<div class="work-browser">';
        $visual_col .= '<div class="work-browser__bar">';
        $visual_col .= '<span class="work-browser__dot" style="background:#ef4444;"></span>';
        $visual_col .= '<span class="work-browser__dot" style="background:#f59e0b;"></span>';
        $visual_col .= '<span class="work-browser__dot" style="background:#22c55e;"></span>';
        $visual_col .= '<span class="work-browser__url">' . esc_html( $browser_url ) . '</span>';
        $visual_col .= '</div>';

        if ( $screenshot ) {
            $img_src     = esc_url( $screenshot['sizes']['large'] ?? $screenshot['url'] );
            $img_alt     = esc_attr( $screenshot['alt'] ?: get_the_title() );
            $img_loading = $index === 0 ? 'eager' : 'lazy';
            $visual_col .= '<img src="' . $img_src . '" alt="' . $img_alt . '" class="work-browser__screen" loading="' . $img_loading . '">';
        } else {
            $visual_col .= '<div class="work-browser__screen work-browser__screen--placeholder work-browser__screen--' . esc_attr( $placeholder ) . '">';
            $visual_col .= '<div class="work-placeholder__inner"><div class="work-placeholder__label">Screenshot coming soon</div></div>';
            $visual_col .= '</div>';
        }

        $visual_col .= '</div></div>';

        // ── Content column ───────────────────────────────────────────────
        $content_col = '<div class="col-12 col-lg-5 work-project__content">';

        // Category tag (from taxonomy)
        if ( $term_name ) {
            $content_col .= '<div class="work-project__tag">';
            $content_col .= '<span class="work-project__tag-dot" style="background:' . esc_attr( $term_color ) . ';"></span>';
            $content_col .= esc_html( $term_name );
            $content_col .= '</div>';
        }

        // Heading (post title)
        $content_col .= '<h3 class="work-project__heading">' . esc_html( get_the_title() ) . '</h3>';

        // Body
        if ( $body ) {
            $content_col .= '<p class="work-project__body">' . esc_html( $body ) . '</p>';
        }

        // Outcomes — always blue ticks
        if ( $outcomes ) {
            $content_col .= '<ul class="work-outcomes">';
            foreach ( $outcomes as $outcome ) {
                $content_col .= '<li class="work-outcome">';
                $content_col .= '<span class="work-outcome__check">' . $check_icon . '</span>';
                $content_col .= esc_html( $outcome['text'] );
                $content_col .= '</li>';
            }
            $content_col .= '</ul>';
        }

        // Button — always links to project post
        $content_col .= '<a href="' . esc_url( get_the_permalink() ) . '" class="btn btn-secondary">View project' . $btn_arrow . '</a>';

        $content_col .= '</div>';

        // Swap column order for alternating projects
        if ( $is_reverse ) {
            echo $content_col; // phpcs:ignore
            echo $visual_col;  // phpcs:ignore
        } else {
            echo $visual_col;  // phpcs:ignore
            echo $content_col; // phpcs:ignore
        }
        ?>

      </div>
    </div>
    <?php
        $index++;
    endwhile;
    wp_reset_postdata();
    ?>

    <?php if ( $show_all_link ) : ?>
      <div class="work-footer">
        <a href="<?php echo esc_url( $all_url ); ?>" class="btn btn-secondary">
          See all projects
          <?php echo $btn_arrow; // phpcs:ignore ?>
        </a>
      </div>
    <?php endif; ?>

  </div>
</section>
