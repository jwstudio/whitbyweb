<?php get_header(); ?>

<main id="main" class="site-main">
  <?php
  if ( have_rows( 'page_builder' ) ) :
      while ( have_rows( 'page_builder' ) ) : the_row();

          switch ( get_row_layout() ) {
              case 'hero':
                  get_template_part( 'template-parts/blocks/hero' );
                  break;
              case 'reviews':
                  get_template_part( 'template-parts/blocks/reviews' );
                  break;
              case 'services':
                  get_template_part( 'template-parts/blocks/services' );
                  break;
              case 'work':
                  get_template_part( 'template-parts/blocks/work' );
                  break;
              case 'usp':
                  get_template_part( 'template-parts/blocks/usp' );
                  break;
              case 'one_page_promo':
                  get_template_part( 'template-parts/blocks/one-page-promo' );
                  break;
              case 'cta':
                  get_template_part( 'template-parts/blocks/cta' );
                  break;
              case 'contact':
                  get_template_part( 'template-parts/blocks/contact' );
                  break;
          }

      endwhile;
  endif;
  ?>
</main>

<?php get_footer(); ?>
