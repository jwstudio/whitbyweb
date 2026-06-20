<?php
/**
 * Block: Work / Projects
 * Fields: eyebrow, heading_lines, lead, limit, show_all_link, all_url
 * Auto-queries: project CPT ordered by menu_order
 */

$eyebrow       = get_sub_field( 'eyebrow' );
$lead          = get_sub_field( 'lead' );
$limit         = (int) ( get_sub_field( 'limit' ) ?: -1 );
$show_all_link = get_sub_field( 'show_all_link' );
$all_url       = get_sub_field( 'all_url' ) ?: '/work/';

$query = new WP_Query( [
    'post_type'      => 'project',
    'posts_per_page' => $limit ?: -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
    'no_found_rows'  => true,
] );

if ( ! $query->have_posts() ) {
    return;
}

$btn_arrow = '<span class="btn-arrow"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>';

$check_icon = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';

$outcome_colors = [
    'green' => [ 'stroke' => '#86c541', 'bg' => 'rgba(134,197,65,0.1)',  'border' => 'rgba(134,197,65,0.2)' ],
    'blue'  => [ 'stroke' => '#92d5f2', 'bg' => 'rgba(146,213,242,0.08)', 'border' => 'rgba(146,213,242,0.15)' ],
    'pink'  => [ 'stroke' => '#f292c4', 'bg' => 'rgba(242,146,196,0.08)', 'border' => 'rgba(242,146,196,0.15)' ],
];
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

        $category      = get_field( 'project_category' );
        $tag_color     = get_field( 'project_tag_color' ) ?: '#86c541';
        $problem_label = get_field( 'project_problem_label' ) ?: 'The problem';
        $body          = get_field( 'project_body' );
        $outcomes      = get_field( 'project_outcomes' );
        $project_url   = get_field( 'project_url' );
        $browser_url   = get_field( 'project_browser_url' );
        $screenshot    = get_field( 'project_screenshot' );
        $placeholder   = get_field( 'project_placeholder_color' ) ?: 'green';

        $is_reverse = $index % 2 !== 0;
        $mod_class  = $is_reverse ? ' work-project--reverse' : '';
    ?>
    <div class="work-project<?php echo esc_attr( $mod_class ); ?>">
      <div class="row align-items-center">

        <?php
        $visual_col = '<div class="col-12 col-lg-7 work-project__visual-col">
          <div class="work-browser">
            <div class="work-browser__bar">
              <span class="work-browser__dot" style="background:#ef4444;"></span>
              <span class="work-browser__dot" style="background:#f59e0b;"></span>
              <span class="work-browser__dot" style="background:#22c55e;"></span>
              <span class="work-browser__url">' . esc_html( $browser_url ) . '</span>
            </div>';

        if ( $screenshot ) {
            $visual_col .= '<img
                src="' . esc_url( $screenshot['url'] ) . '"
                alt="' . esc_attr( $screenshot['alt'] ?: get_the_title() ) . '"
                class="work-browser__screen"
                width="' . (int) $screenshot['width'] . '"
                height="' . (int) $screenshot['height'] . '"
                loading="' . ( $index === 0 ? 'eager' : 'lazy' ) . '"
              />';
        } else {
            $visual_col .= '<div class="work-browser__screen work-browser__screen--placeholder work-browser__screen--' . esc_attr( $placeholder ) . '">
                <div class="work-placeholder__inner">
                  <div class="work-placeholder__label">Screenshot coming soon</div>
                </div>
              </div>';
        }

        $visual_col .= '</div></div>';

        $content_col = '<div class="col-12 col-lg-5 work-project__content">';

        if ( $category ) {
            $content_col .= '<div class="work-project__tag">
                <span class="work-project__tag-dot" style="background:' . esc_attr( $tag_color ) . ';"></span>
                ' . esc_html( $category ) . '
              </div>';
        }

        $content_col .= '<p class="work-project__problem">' . esc_html( $problem_label ) . '</p>';
        $content_col .= '<h3 class="work-project__heading">' . esc_html( get_the_title() ) . '</h3>';

        if ( $body ) {
            $content_col .= '<p class="work-project__body">' . esc_html( $body ) . '</p>';
        }

        if ( $outcomes ) {
            $content_col .= '<ul class="work-outcomes">';
            foreach ( $outcomes as $outcome ) {
                $color_set = $outcome_colors[ $outcome['color'] ] ?? $outcome_colors['green'];
                $svg       = str_replace( '<svg', '<svg stroke="' . esc_attr( $color_set['stroke'] ) . '"', $check_icon );
                $content_col .= '<li class="work-outcome">
                    <span class="work-outcome__check" style="background:' . esc_attr( $color_set['bg'] ) . ';border:1px solid ' . esc_attr( $color_set['border'] ) . ';">'
                        . $svg .
                    '</span>
                    ' . esc_html( $outcome['text'] ) . '
                  </li>';
            }
            $content_col .= '</ul>';
        }

        if ( $project_url ) {
            $content_col .= '<a href="' . esc_url( $project_url ) . '" class="btn btn-secondary">See the project' . $btn_arrow . '</a>';
        }

        $content_col .= '</div>';

        // Output columns — reverse layout swaps visual/content order
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
