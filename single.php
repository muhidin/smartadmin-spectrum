<?php
/**
 * The template for displaying all single posts
 *
 * @package SmartAdmin_Spectrum
 */

get_header(); ?>

<main class="container site-main single-post-container">
    <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                <div class="entry-meta">
                    <?php echo get_the_date(); ?> | <?php the_author(); ?>
                </div>
            </header>

            <div class="entry-content">
                <?php 
                the_content(); 
                
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'smartadmin-spectrum' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>

            <footer class="entry-footer">
                <?php the_tags( '<span class="tags-links">' . esc_html__( 'Tags: ', 'smartadmin-spectrum' ), ', ', '</span>' ); ?>
            </footer>
        </article>

        <?php the_post_navigation(); ?>

        <?php 
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
        ?>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>