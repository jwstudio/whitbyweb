<?php
/**
 * Block: Services
 * Fields: eyebrow, heading_lines, lead, service_cards (repeater),
 *         cta_eyebrow, heading_lines (cta), cta_body, buttons, cta_photo
 */

$eyebrow    = get_sub_field( 'eyebrow' );
$lead       = get_sub_field( 'lead' );
$cta_eyebrow = get_sub_field( 'cta_eyebrow' );
$cta_body   = get_sub_field( 'cta_body' );
$cta_photo  = get_sub_field( 'cta_photo' );

$btn_arrow = '<span class="btn-arrow"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>';
?>
<section class="services">
  <div class="container">

    <div class="row services-header">
      <div class="col-12 col-lg-6">
        <?php if ( $eyebrow ) : ?>
          <div class="eyebrow" style="margin-bottom:16px;"><?php echo esc_html( $eyebrow ); ?></div>
        <?php endif; ?>
        <?php whitbyweb_render_heading( 'heading_lines', 'h2', 'section-heading' ); ?>
      </div>
      <?php if ( $lead ) : ?>
        <div class="col-12 col-lg-6 services-header__sub">
          <p class="text-lead" style="margin-bottom:0;"><?php echo esc_html( $lead ); ?></p>
        </div>
      <?php endif; ?>
    </div>

    <div class="services-grid">

      <div class="services-grid__cards">
        <?php if ( have_rows( 'service_cards' ) ) : ?>
          <?php while ( have_rows( 'service_cards' ) ) : the_row(); ?>
            <?php
            $icon        = get_sub_field( 'icon' );
            $icon_custom = get_sub_field( 'icon_custom' );
            $title       = get_sub_field( 'title' );
            $body        = get_sub_field( 'body' );
            $tags_raw    = get_sub_field( 'tags' );
            $tags        = $tags_raw ? array_map( 'trim', explode( ',', $tags_raw ) ) : [];
            $icon_html   = $icon === 'custom' ? wp_kses_post( $icon_custom ) : whitbyweb_service_icon( $icon );
            ?>
            <div class="service-card card card--hoverable">
              <?php if ( $icon_html ) : ?>
                <div class="service-card__icon"><?php echo $icon_html; // phpcs:ignore ?></div>
              <?php endif; ?>
              <div class="service-card__title"><?php echo esc_html( $title ); ?></div>
              <p class="service-card__body"><?php echo esc_html( $body ); ?></p>
              <?php if ( $tags ) : ?>
                <div class="service-card__tags">
                  <?php foreach ( $tags as $tag ) : ?>
                    <span class="service-tag"><?php echo esc_html( $tag ); ?></span>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>

      <div class="service-cta-card card">
        <?php if ( $cta_photo ) : ?>
          <div class="service-cta-card__photo">
            <img
              src="<?php echo esc_url( $cta_photo['url'] ); ?>"
              alt="<?php echo esc_attr( $cta_photo['alt'] ); ?>"
              class="service-cta-card__img"
              width="<?php echo (int) $cta_photo['width']; ?>"
              height="<?php echo (int) $cta_photo['height']; ?>"
              loading="lazy"
            />
          </div>
        <?php endif; ?>
        <div class="service-cta-card__content">
          <?php if ( $cta_eyebrow ) : ?>
            <div class="eyebrow" style="margin-bottom:12px;"><?php echo esc_html( $cta_eyebrow ); ?></div>
          <?php endif; ?>
          <?php whitbyweb_render_heading( 'heading_lines', 'h3', 'service-cta-card__heading' ); ?>
          <?php if ( $cta_body ) : ?>
            <p class="service-cta-card__body"><?php echo esc_html( $cta_body ); ?></p>
          <?php endif; ?>
          <?php whitbyweb_render_buttons( 'buttons' ); ?>
        </div>
      </div>

    </div>
  </div>
</section>
