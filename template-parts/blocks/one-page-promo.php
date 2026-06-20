<?php
/**
 * Block: One-Page Promo
 * All content comes from Global Settings options page.
 */

$eyebrow      = get_field( 'opp_eyebrow', 'option' );
$heading_rows = get_field( 'opp_heading_lines', 'option' );
$lead         = get_field( 'opp_lead', 'option' );
$buttons      = get_field( 'opp_buttons', 'option' );
$card_eyebrow = get_field( 'opp_card_eyebrow', 'option' ) ?: "What's included";
$features     = get_field( 'opp_features', 'option' );

$check_icon = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
?>
<section class="one-page">
  <div class="container">
    <div class="row">

      <div class="col-12 col-lg-7 section-content">

        <?php if ( $eyebrow ) : ?>
          <div class="eyebrow" style="margin-bottom:16px;"><?php echo esc_html( $eyebrow ); ?></div>
        <?php endif; ?>

        <?php if ( $heading_rows ) : whitbyweb_render_heading_from_rows( $heading_rows, 'h2', 'section-heading' ); endif; ?>

        <?php if ( $lead ) : ?>
          <p class="text-lead"><?php echo esc_html( $lead ); ?></p>
        <?php endif; ?>

        <?php if ( $buttons ) : whitbyweb_render_buttons_from_rows( $buttons ); endif; ?>

      </div>

      <div class="col-12 col-lg-5">
        <div class="onepage-card">
          <div class="onepage-card__header">
            <span class="eyebrow"><?php echo esc_html( $card_eyebrow ); ?></span>
          </div>
          <?php if ( $features ) : ?>
            <ul class="onepage-features">
              <?php foreach ( $features as $feature ) : ?>
                <li class="onepage-feature">
                  <div class="onepage-feature__icon"><?php echo $check_icon; // phpcs:ignore ?></div>
                  <div>
                    <div class="onepage-feature__title"><?php echo esc_html( $feature['title'] ); ?></div>
                    <?php if ( ! empty( $feature['sub'] ) ) : ?>
                      <div class="onepage-feature__sub"><?php echo esc_html( $feature['sub'] ); ?></div>
                    <?php endif; ?>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</section>
