<?php
/**
 * The main template file
 *
 * @package SmartAdmin_Spectrum
 */

get_header(); ?>

<main id="primary" class="site-main container">
    <section class="hero">
        <h1><?php esc_html_e( 'Digital Office Specialist', 'smartadmin-spectrum' ); ?></h1>
        <p>
            <?php esc_html_e( 'Membangun kompetensi profesional di era digital bersama', 'smartadmin-spectrum' ); ?> 
            <strong><?php esc_html_e( 'Muhidin Saimin', 'smartadmin-spectrum' ); ?></strong>.
        </p>
        <a href="#materi" class="btn-cta"><?php esc_html_e( 'Mulai Belajar', 'smartadmin-spectrum' ); ?></a>
    </section>

    <div id="materi" class="post-grid">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
                    
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'medium', array( 'alt' => the_title_attribute( array( 'echo' => false ) ) ) ); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <header class="entry-header">
                        <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
                    </header>

                    <div class="entry-excerpt">
                        <?php the_excerpt(); ?>
                    </div>

                    <footer class="entry-footer">
                        <a href="<?php the_permalink(); ?>" class="read-more">
                            <?php esc_html_e( 'Baca Selengkapnya &raquo;', 'smartadmin-spectrum' ); ?>
                        </a>
                    </footer>
                </article>
            <?php endwhile; ?>

            <div class="pagination">
                <?php the_posts_navigation(); ?>
            </div>

        <?php else : ?>
            <p><?php esc_html_e( 'Maaf, belum ada materi yang tersedia saat ini.', 'smartadmin-spectrum' ); ?></p>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>