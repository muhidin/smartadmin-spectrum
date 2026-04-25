<?php
/**
 * The template for displaying all pages
 *
 * @package SmartAdmin_Spectrum
 */

get_header(); ?>

<main id="primary-content" class="<?php echo esc_attr( get_theme_mod( 'smartadmin_spectrum_layout_container', 'container' ) ); ?> site-main" style="margin-top: 40px; margin-bottom: 40px;">
    <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-thumbnail-float">
                    <?php the_post_thumbnail( 'medium', array( 'class' => 'featured-image-float', 'style' => 'float: left; margin-right: 20px; margin-bottom: 10px; max-width: 300px; height: auto; border-radius: 8px;' ) ); ?>
                </div>
            <?php endif; ?>

            <div class="entry-content">
                <?php 
                the_content(); 
                
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'smartadmin-spectrum' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>