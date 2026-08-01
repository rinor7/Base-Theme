<?php
/**
 * @package Base Theme
 */
$footer_color_map = array(
    'primary'   => 'var(--primary-color)',
    'secondary' => 'var(--secondary-color)',
    'font'      => 'var(--font-color)',
    'white'     => 'var(--white)',
    'black'     => 'var(--black)',
);
$footer_bg_type = get_field('footer_background_color', 'option') ?: '';
$footer_bg_custom = get_field('footer_background_color_custom', 'option') ?: '';
$footer_bg_gradient = get_field('footer_background_gradient', 'option') ?: '';
$footer_style = '';
if ($footer_bg_type === 'gradient') {
    $footer_bg_gradient = trim($footer_bg_gradient);
    if ($footer_bg_gradient !== '') {
        $footer_style = 'background:' . $footer_bg_gradient . ';';
    }
} elseif ($footer_bg_type === 'custom') {
    if (!empty($footer_bg_custom)) {
        $footer_style = 'background-color:' . $footer_bg_custom . ';';
    }
} elseif (!empty($footer_bg_type) && isset($footer_color_map[$footer_bg_type])) {
    $footer_style = 'background-color:' . $footer_color_map[$footer_bg_type] . ';';
}
$footer_style_attr = $footer_style ? ' style="' . esc_attr($footer_style) . '"' : '';
?>

<footer id="footer-site" class="site-footer"<?php echo $footer_style_attr; ?>>
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