<?php
/**
 * The template for displaying all single posts
 *
 * @package SmartAdmin_Spectrum
 */

get_header(); ?>

<main id="primary-content" class="<?php echo esc_attr( get_theme_mod( 'smartadmin_spectrum_layout_container', 'container' ) ); ?> site-main single-post-container">
    <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                <div class="entry-meta">
                    <span class="posted-on"><?php echo get_the_date(); ?></span> | 
                    <span class="byline"><?php the_author(); ?></span>
                </div>
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

            <footer class="entry-footer" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                <?php the_tags( '<span class="tags-links">' . esc_html__( 'Tags: ', 'smartadmin-spectrum' ), ', ', '</span>' ); ?>
            </footer>
        </article>

        <div class="post-navigation-wrapper" style="margin: 40px 0;">
            <?php the_post_navigation( array(
                'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'smartadmin-spectrum' ) . '</span> <span class="nav-title">%title</span>',
                'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'smartadmin-spectrum' ) . '</span> <span class="nav-title">%title</span>',
            ) ); ?>
        </div>

        <?php 
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
        ?>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>