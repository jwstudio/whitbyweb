<?php
/**
 * Block: One-Page Promo
 * Fields: eyebrow, heading_lines, lead, buttons, card_eyebrow, features (repeater)
 */

$eyebrow      = get_sub_field( 'eyebrow' );
$lead         = get_sub_field( 'lead' );
$card_eyebrow = get_sub_field( 'card_eyebrow' ) ?: "What's included";

$check_icon = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
?>
<section class="one-page">
  <div class="container">
    <div class="row">

      <div class="col-12 col-lg-7 section-content">
        <?php if ( $eyebrow ) : ?>
          <div class="eyebrow" style="margin-bottom:16px;"><?php echo esc_html( $eyebrow ); ?></div>
        <?php endif; ?>
        <?php whitbyweb_render_heading( 'heading_lines', 'h2', 'section-heading' ); ?>
        <?php if ( $lead ) : ?>
          <p class="text-lead"><?php echo esc_html( $lead ); ?></p>
        <?php endif; ?>
        <?php whitbyweb_render_buttons( 'buttons' ); ?>
      </div>

      <div class="col-12 col-lg-5">
        <div class="onepage-card">
          <div class="onepage-card__header">
            <span class="eyebrow"><?php echo esc_html( $card_eyebrow ); ?></span>
          </div>
          <?php if ( have_rows( 'features' ) ) : ?>
            <ul class="onepage-features">
              <?php while ( have_rows( 'features' ) ) : the_row(); ?>
                <?php
                $title = get_sub_field( 'title' );
                $sub   = get_sub_field( 'sub' );
                ?>
                <li class="onepage-feature">
                  <div class="onepage-feature__icon"><?php echo $check_icon; // phpcs:ignore ?></div>
                  <div>
                    <div class="onepage-feature__title"><?php echo esc_html( $title ); ?></div>
                    <?php if ( $sub ) : ?>
                      <div class="onepage-feature__sub"><?php echo esc_html( $sub ); ?></div>
                    <?php endif; ?>
                  </div>
                </li>
              <?php endwhile; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</section>
