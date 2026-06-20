<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <header class="site-header">
    <div class="container">
      <nav class="nav">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo">
          <div class="nav-name">James <span class="second">Whitby</span> <span class="third">Web</span></div>
        </a>
        <ul class="nav-links">
          <li><a href="/contact/" class="nav-cta">Get in touch</a></li>
        </ul>
      </nav>
    </div>
  </header>
<main>