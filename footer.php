<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the body and html tags.
 *
 * @package SmartAdmin_Spectrum
 */

?>

    <footer id="colophon" class="site-footer">
        <div class="container">
            <p>
                &copy; <?php echo date('Y'); ?> 
                <strong><?php echo esc_html__( 'Muhidin Saimin', 'smartadmin-spectrum' ); ?></strong>. 
                <?php echo esc_html__( 'All Rights Reserved.', 'smartadmin-spectrum' ); ?>
            </p>
            <p>
                <small>
                    <?php echo esc_html__( 'Digital Office Specialist', 'smartadmin-spectrum' ); ?> | 
                    <a href="<?php echo esc_url( 'https://muhidin.web.id' ); ?>" target="_blank" rel="noopener">
                        <?php echo esc_html__( 'muhidin.web.id', 'smartadmin-spectrum' ); ?>
                    </a>
                </small>
            </p>
        </div></footer><?php wp_footer(); ?>

</body>
</html>