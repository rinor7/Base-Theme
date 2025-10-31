<?php 
global $header_type; // required to access global variable

// Ensure textdomain is loaded for 404 page
if (!is_textdomain_loaded('base-theme')) {
    load_theme_textdomain('base-theme', get_template_directory() . '/languages');
}

include("includes/headers/{$header_type}.php");
?>

<main id="primary" class="site-404">
    <div class="fof">
        <h1><?php _e( 'Error 404', 'base-theme'); ?></h1>
    </div>
</main><!-- #main -->