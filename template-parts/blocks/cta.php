<?php
/**
 * Block: CTA Banner
 * Fields: eyebrow, heading_lines, lead, buttons, portrait
 */

$eyebrow = get_sub_field( 'eyebrow' );
$lead    = get_sub_field( 'lead' );
$portrait = get_sub_field( 'portrait' );
?>
<section class="cta-section">
  <div class="container">
    <div class="cta-inner">
      <div class="row align-items-center">

        <div class="col-12 col-lg-7">
          <div class="cta-inner__text">
            <?php if ( $eyebrow ) : ?>
              <div class="eyebrow" style="margin-bottom:16px;"><?php echo esc_html( $eyebrow ); ?></div>
            <?php endif; ?>
            <?php whitbyweb_render_heading( 'heading_lines', 'h2', 'section-heading' ); ?>
            <?php if ( $lead ) : ?>
              <p class="text-lead"><?php echo esc_html( $lead ); ?></p>
            <?php endif; ?>
          </div>
          <?php whitbyweb_render_buttons( 'buttons' ); ?>
        </div>

        <?php if ( $portrait ) : ?>
          <div class="col-12 col-lg-5">
            <div class="cta-portrait">
              <img
                src="<?php echo esc_url( $portrait['url'] ); ?>"
                alt="<?php echo esc_attr( $portrait['alt'] ); ?>"
                class="cta-portrait__img"
                width="<?php echo (int) $portrait['width']; ?>"
                height="<?php echo (int) $portrait['height']; ?>"
                loading="lazy"
              />
            </div>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</section>
