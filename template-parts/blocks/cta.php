<?php
/**
 * Block: CTA Banner
 * Page-level fields take priority; falls back to Global Settings for any blank fields.
 *
 * Fields: eyebrow, heading_lines, lead, buttons, portrait
 */

// Page-level values
$eyebrow      = get_sub_field( 'eyebrow' );
$heading_rows = get_sub_field( 'heading_lines' );
$lead         = get_sub_field( 'lead' );
$buttons      = get_sub_field( 'buttons' );
$portrait     = get_sub_field( 'portrait' );

// Fall back to Global Settings for anything left blank
if ( ! $eyebrow )      $eyebrow      = get_field( 'cta_eyebrow', 'option' );
if ( ! $heading_rows ) $heading_rows = get_field( 'cta_heading_lines', 'option' );
if ( ! $lead )         $lead         = get_field( 'cta_lead', 'option' );
if ( ! $buttons )      $buttons      = get_field( 'cta_buttons', 'option' );
if ( ! $portrait )     $portrait     = get_field( 'cta_portrait', 'option' );
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

            <?php if ( $heading_rows ) : whitbyweb_render_heading_from_rows( $heading_rows, 'h2', 'section-heading' ); endif; ?>

            <?php if ( $lead ) : ?>
              <p class="text-lead"><?php echo esc_html( $lead ); ?></p>
            <?php endif; ?>

          </div>

          <?php if ( $buttons ) : whitbyweb_render_buttons_from_rows( $buttons ); endif; ?>
        </div>

        <?php if ( $portrait ) : ?>
          <div class="col-12 col-lg-5">
            <div class="cta-portrait">
              <img
                src="<?php echo esc_url( $portrait['url'] ); ?>"
                alt="<?php echo esc_attr( $portrait['alt'] ); ?>"
                class="cta-portrait__img"
                loading="lazy"
              />
            </div>
          </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</section>
