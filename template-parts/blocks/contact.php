<?php
/**
 * Block: Contact
 * Fields: heading_lines, subtext, pill_text, email,
 *         facebook_url, instagram_url, linkedin_url,
 *         form_id, form_title, form_subtitle
 */

$subtext      = get_sub_field( 'subtext' );
$pill_text    = get_sub_field( 'pill_text' ) ?: 'Get in touch';
$email        = get_sub_field( 'email' );
$fb_url       = get_sub_field( 'facebook_url' );
$ig_url       = get_sub_field( 'instagram_url' );
$li_url       = get_sub_field( 'linkedin_url' );
$form_id      = get_sub_field( 'form_id' ) ?: 1;
$form_title   = get_sub_field( 'form_title' ) ?: 'Send a message';
$form_subtitle = get_sub_field( 'form_subtitle' ) ?: "Fill out the form and we'll be in touch shortly.";

$socials = [
    'Facebook' => [
        'url'  => $fb_url,
        'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
    ],
    'Instagram' => [
        'url'  => $ig_url,
        'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
    ],
    'LinkedIn' => [
        'url'  => $li_url,
        'icon' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
    ],
];
?>
<section class="hero" id="contact">
  <div class="container">
    <div class="row">

      <div class="col-12 col-lg-7 hero-content">

        <?php if ( $pill_text ) : ?>
          <div class="hero-pill">
            <span class="hero-pill-dot"></span>
            <?php echo esc_html( $pill_text ); ?>
          </div>
        <?php endif; ?>

        <?php whitbyweb_render_heading( 'heading_lines', 'h1', 'hero-h1' ); ?>

        <?php if ( $subtext ) : ?>
          <p class="hero-sub"><?php echo esc_html( $subtext ); ?></p>
        <?php endif; ?>

        <div class="contact-info">
          <?php if ( $email ) : ?>
            <div class="contact-block">
              <div class="contact-label">Email</div>
              <a href="mailto:<?php echo esc_attr( $email ); ?>" class="contact-email">
                <?php echo esc_html( $email ); ?>
              </a>
            </div>
          <?php endif; ?>

          <?php
          $active_socials = array_filter( $socials, fn( $s ) => ! empty( $s['url'] ) );
          if ( $active_socials ) :
          ?>
            <div class="contact-block">
              <div class="contact-label">Follow</div>
              <div class="contact-socials">
                <?php foreach ( $active_socials as $name => $social ) : ?>
                  <a href="<?php echo esc_url( $social['url'] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $name ); ?>" class="contact-social">
                    <?php echo $social['icon']; // phpcs:ignore ?>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>
        </div>

      </div>

      <div class="col-12 col-lg-5 hero-form-wrap">
        <div class="hero-form">
          <div class="form-title"><?php echo esc_html( $form_title ); ?></div>
          <div class="form-subtitle mb-4"><?php echo esc_html( $form_subtitle ); ?></div>
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
