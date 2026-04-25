<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package SmartAdmin_Spectrum
 */

get_header(); ?>

<main id="primary-content" class="<?php echo esc_attr( get_theme_mod( 'smartadmin_spectrum_layout_container', 'container' ) ); ?> site-main">
    <div class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'smartadmin-spectrum' ); ?></h1>
        </header><!-- .page-header -->

        <div class="page-content">
            <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'smartadmin-spectrum' ); ?></p>

            <?php get_search_form(); ?>

            <?php
            the_widget( 'WP_Widget_Recent_Posts' );
            ?>

            <div class="widget widget_categories">
                <h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'smartadmin-spectrum' ); ?></h2>
                <ul>
                    <?php
                    wp_list_categories( array(
                        'orderby'    => 'count',
                        'order'      => 'DESC',
                        'show_count' => 1,
                        'title_li'   => '',
                        'number'     => 10,
                    ) );
                    ?>
                </ul>
            </div>

            <?php
            /* translators: %1$s: smiley */
            $archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'smartadmin-spectrum' ), convert_smilies( ':)' ) ) . '</p>';
            the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
            ?>

            <?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
        </div><!-- .page-content -->
    </div><!-- .error-404 -->
</main><!-- #primary-content -->

<?php
get_footer();
