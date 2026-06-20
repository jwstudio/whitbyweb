<?php get_header(); ?>

<main id="main" class="site-main">

    <?php
    if ( have_rows( 'page_builder' ) ) :
        while ( have_rows( 'page_builder' ) ) : the_row();

            $layout = get_row_layout();

            if ( $layout === 'hero' ) :
                get_template_part( 'template-parts/blocks/hero' );
            endif;

        endwhile;
    endif;
    ?>

</main>

<?php get_footer(); ?>
