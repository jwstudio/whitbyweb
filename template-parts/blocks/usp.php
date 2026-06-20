<?php
/**
 * Block: Unique Selling Points
 * Fields: eyebrow, heading_lines, lead, columns (2|3), items (repeater: title, sub)
 */

$eyebrow = get_sub_field( 'eyebrow' );
$lead    = get_sub_field( 'lead' );
$columns = get_sub_field( 'columns' ) ?: '3';
$items   = get_sub_field( 'items' );

$check_icon = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
?>
<section class="usp-section">
  <div class="container">

    <?php if ( $eyebrow || have_rows( 'heading_lines' ) || $lead ) : ?>
      <div class="row usp-header">
        <div class="col-12 col-lg-7">
          <?php if ( $eyebrow ) : ?>
            <div class="eyebrow" style="margin-bottom:16px;"><?php echo esc_html( $eyebrow ); ?></div>
          <?php endif; ?>
          <?php whitbyweb_render_heading( 'heading_lines', 'h2', 'section-heading' ); ?>
          <?php if ( $lead ) : ?>
            <p class="text-lead"><?php echo esc_html( $lead ); ?></p>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

    <?php if ( $items ) : ?>
      <ul class="usp-grid usp-grid--cols-<?php echo esc_attr( $columns ); ?>">
        <?php foreach ( $items as $item ) : ?>
          <li class="onepage-feature">
            <div class="onepage-feature__icon"><?php echo $check_icon; // phpcs:ignore ?></div>
            <div>
              <div class="onepage-feature__title"><?php echo esc_html( $item['title'] ); ?></div>
              <?php if ( ! empty( $item['sub'] ) ) : ?>
                <div class="onepage-feature__sub"><?php echo esc_html( $item['sub'] ); ?></div>
              <?php endif; ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

  </div>
</section>
