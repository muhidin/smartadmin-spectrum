<?php
/**
 * The template for displaying search results pages
 *
 * @package SmartAdmin_Spectrum
 */

get_header(); ?>

<main id="primary-content" class="site-main <?php echo esc_attr( get_theme_mod( 'smartadmin_spectrum_layout_container', 'container' ) ); ?>">
    <header class="page-header">
        <h1 class="page-title">
            <?php
            /* translators: %s: search query */
            printf( esc_html__( 'Search Results for: %s', 'smartadmin-spectrum' ), '<span>' . get_search_query() . '</span>' );
            ?>
        </h1>
    </header><!-- .page-header -->

    <div class="search-results">
        <?php if ( have_posts() ) : ?>
            
            <div class="search-info">
                <p>
                    <?php
                    /* translators: 1: number of results, 2: search query */
                    printf( 
                        esc_html( _n( 
                            'Found %1$d result for "%2$s"', 
                            'Found %1$d results for "%2$s"', 
                            (int) $wp_query->found_posts, 
                            'smartadmin-spectrum' 
                        ) ), 
                        number_format_i18n( $wp_query->found_posts ), 
                        get_search_query() 
                    );
                    ?>
                </p>
            </div>

            <div class="post-grid grid-3-cols">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card search-result'); ?>>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', array('alt' => the_title_attribute(array('echo' => false)))); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <header class="entry-header">
                            <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>
                            
                            <div class="entry-meta">
                                <span class="post-type">
                                    <?php esc_html_e('Post Type:', 'smartadmin-spectrum'); ?> 
                                    <strong><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></strong>
                                </span>
                                <?php if (get_post_type() === 'post') : ?>
                                    <span class="post-date">
                                        <?php esc_html_e('Date:', 'smartadmin-spectrum'); ?> 
                                        <strong><?php echo get_the_date(); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </header>

                        <div class="entry-excerpt">
                            <?php the_excerpt(); ?>
                        </div>

                        <?php if (get_post_type() === 'post') : ?>
                            <div class="entry-categories">
                                <span class="categories-label"><?php esc_html_e('Categories:', 'smartadmin-spectrum'); ?></span>
                                <?php the_category(', '); ?>
                            </div>
                        <?php endif; ?>

                        <footer class="entry-footer">
                            <a href="<?php the_permalink(); ?>" class="read-more">
                                <?php esc_html_e('Read More &raquo;', 'smartadmin-spectrum'); ?>
                            </a>
                        </footer>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="pagination">
                <?php the_posts_navigation(); ?>
            </div>

        <?php else : ?>
            
            <div class="no-results">
                <h2><?php esc_html_e('No results found', 'smartadmin-spectrum'); ?></h2>
                <p>
                    <?php
                    /* translators: %s: search query */
                    printf( esc_html__( 'No results found for "%s". Please try another search term.', 'smartadmin-spectrum' ), get_search_query() );
                    ?>
                </p>
                
                <?php get_search_form(); ?>
                
                <div class="search-suggestions">
                    <h3><?php esc_html_e('Search Suggestions:', 'smartadmin-spectrum'); ?></h3>
                    <ul>
                        <li><?php esc_html_e('Check your spelling', 'smartadmin-spectrum'); ?></li>
                        <li><?php esc_html_e('Try more general keywords', 'smartadmin-spectrum'); ?></li>
                        <li><?php esc_html_e('Try different keywords', 'smartadmin-spectrum'); ?></li>
                        <li><?php esc_html_e('Browse our categories', 'smartadmin-spectrum'); ?></li>
                    </ul>
                    
                    <div class="browse-categories">
                        <h4><?php esc_html_e('Browse by Category:', 'smartadmin-spectrum'); ?></h4>
                        <?php
                        wp_list_categories( array(
                            'orderby'    => 'name',
                            'order'      => 'ASC',
                            'show_count' => 1,
                            'title_li'   => '',
                            'number'     => 10,
                        ) );
                        ?>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </div>

</main>

<?php get_footer(); ?>
