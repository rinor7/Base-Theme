<?php
/**
 * @package Base Theme
 */
?>

<footer id="footer-site" class="site-footer">
    <div class="footer-columns">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 footer-columns-1">
                    <?php 
                    $footer_logo = get_theme_mod('footer_logo');
                    if ($footer_logo) {
                        echo '<a href="' . esc_url(home_url('/')) . '" class="footer-logo">';
                        echo '<img src="' . esc_url($footer_logo) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="footer-logo-img">';
                        echo '</a>';
                    } else {
                        the_custom_logo(); // fallback
                    }
                    ?>
                </div>
                <div class="col-lg-3 footer-columns-2">
                    <ul>
                        <?php dynamic_sidebar('footer-2');?>
                    </ul>
                </div>
                <div class="col-lg-3 footer-columns-3">
                    <ul>
                        <?php dynamic_sidebar('footer-3');?>
                    </ul>
                </div>
                <div class="col-lg-3 footer-columns-4">
                    <ul>
                        <?php dynamic_sidebar('footer-4');?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyrights">
        <div class="container">
            <p>&copy;<?php echo date(' Y  ') ;?>All rights Reserved.</p>
        </div>
    </div>
</footer>


</div><!-- #page -->


<?php wp_footer(); ?>
</body>

</html>