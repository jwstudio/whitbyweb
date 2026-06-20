<?php
/**
 * Block: Hero
 * Fields: pill_text, heading_lines (repeater), lead, buttons (repeater),
 *         form_id, form_title, form_subtitle
 */

$pill_text    = get_sub_field( 'pill_text' );
$lead         = get_sub_field( 'lead' );
$form_id      = get_sub_field( 'form_id' ) ?: 1;
$form_title   = get_sub_field( 'form_title' ) ?: 'Get a free quote';
$form_subtitle = get_sub_field( 'form_subtitle' ) ?: 'Tell us about your project. We reply within 24 hours.';
?>
<section class="hero">
  <div class="container">
    <div class="row">

      <div class="col-12 col-lg-7 section-content">

        <?php if ( $pill_text ) : ?>
          <div class="pill">
            <span class="pill-dot"></span>
            <?php echo esc_html( $pill_text ); ?>
          </div>
        <?php endif; ?>

        <?php whitbyweb_render_heading( 'heading_lines', 'h1', 'display-heading' ); ?>

        <?php if ( $lead ) : ?>
          <p class="text-lead"><?php echo esc_html( $lead ); ?></p>
        <?php endif; ?>

        <?php whitbyweb_render_buttons( 'buttons' ); ?>

      </div>

      <div class="col-12 col-lg-5 form-wrap">
        <div class="form-card">
          <div class="form-card__title"><?php echo esc_html( $form_title ); ?></div>
          <div class="form-card__subtitle mb-4"><?php echo esc_html( $form_subtitle ); ?></div>
          <?php
          if ( function_exists( 'FrmFormsController::get_form_shortcode' ) ) {
              echo FrmFormsController::get_form_shortcode( [ 'id' => (int) $form_id ] );
          } else {
              echo do_shortcode( '[formidable id=' . (int) $form_id . ']' );
          }
          ?>
        </div>
      </div>

    </div>
  </div>
</section>
