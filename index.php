<?php

/**
 * The main template file
 *
 * @package SmartAdmin_Spectrum
 */

get_header(); ?>

<main id="primary-content" class="site-main <?php echo esc_attr( get_theme_mod( 'smartadmin_spectrum_layout_container', 'container' ) ); ?>">
    <?php
    // Slider - Check if enabled
    $slider_enabled = get_theme_mod( 'smartadmin_spectrum_hero_slider_enabled', '1' ); // Default as string '1'
    $slider_style = get_theme_mod( 'smartadmin_spectrum_slider_style', 'fade' );
    $grid_columns = get_theme_mod( 'smartadmin_spectrum_grid_columns', '3' );
    $slides = array();
    
    // Debug: tampilkan status slider
    // echo '<!-- Slider enabled: ' . $slider_enabled . ' -->';
    
    if ( $slider_enabled === '1' || $slider_enabled === true ) {
        $template_dir = get_template_directory_uri();
        for ( $i = 1; $i <= 5; $i++ ) {
            $img = get_theme_mod( 'smartadmin_spectrum_hero_slide_' . $i );
            // Use default if empty
            if ( empty( $img ) ) {
                $img = $template_dir . '/images/slider' . $i . '.jpg';
            }
            $slides[] = $img;
        }
    }
    $slide_count = count( $slides );
    
    // Debug: tampilkan jumlah slide
    // echo '<!-- Slide count: ' . $slide_count . ' -->';
    ?>

    <?php if ( $slide_count > 0 ) : ?>
        <section class="swiper hero-slider slider-<?php echo esc_attr( $slider_style ); ?>" id="hero-slider" style="height: 400px;">
            <div class="swiper-wrapper">
                <?php foreach ( $slides as $index => $image_url ) : ?>
                    <div class="swiper-slide" style="background-image: url('<?php echo esc_url( $image_url ); ?>'); background-size: cover; background-position: center;">
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </section>
    <?php endif; ?>

    <div id="materi" class="post-grid grid-<?php echo esc_attr( $grid_columns ); ?>-cols">
        <?php if ( have_posts() ) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium', array('alt' => the_title_attribute(array('echo' => false)))); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <header class="entry-header">
                        <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>
                    </header>

                    <div class="entry-excerpt">
                        <?php the_excerpt(); ?>
                    </div>

                    <footer class="entry-footer">
                        <a href="<?php the_permalink(); ?>" class="read-more">
                            <?php esc_html_e('Baca Selengkapnya &raquo;', 'smartadmin-spectrum'); ?>
                        </a>
                    </footer>
                </article>
            <?php endwhile; ?>

            <div class="pagination">
                <?php the_posts_navigation(); ?>
            </div>

        <?php else : ?>
            <p><?php esc_html_e('Sorry, no content is available at this time.', 'smartadmin-spectrum'); ?></p>
        <?php endif; ?>
    </div>

</main>

<?php get_footer(); ?>