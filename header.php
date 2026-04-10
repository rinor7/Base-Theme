<?php
/**
 * @package Base Theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <!-- Change this to "noindex, nofollow" when you go live -->
    <meta name="robots" content="noindex, nofollow"> 

    <!-- Profile link for XFN (XHTML Friends Network), used for linking to profiles -->
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <!-- Apple touch icon (for iOS devices) -->
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/apple-touch-icon.png">

    <!-- Preloading font for performance improvement -->
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/Montserrat-Regular.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/fonts/Montserrat-Bold.woff2" as="font" type="font/woff2" crossorigin>

    <?php wp_head(); ?>
</head>

<body <?php $filename = basename(__FILE__, '.php'); body_class( array( wp_is_mobile() ? 'wp-is-mobile' : 'wp-is-desktop', get_field('sticky', 'option') ? 'header-sticky' : '', $filename ) ); ?>>
    <div id="page" class="site">

        <!-- Header Righside Menu -->
        <header id="header-site" class="site-header rightside-menu-header <?php 
            if (is_front_page()) echo 'frontpage-header'; 
            elseif (is_single()) echo 'single-header'; 
            elseif (is_404()) echo '404-header'; 
            else echo 'default-header'; 
            ?>">
            <div class="headerbar" id="headerbar">
                <div class="container">
                    <div class="menu-here">
                        <nav class="navbar navbar-expand-lg navbar-light navbar-center">

                            

                                <?php if (has_custom_logo()) : ?>
                                    <?php the_custom_logo(); ?>
                                <?php else : ?>
                                    <a aria-label="logo" class="logo_header" href="<?php echo esc_url(home_url('/')); ?>">
                                        <?php bloginfo('name'); ?>
                                    </a>
                                <?php endif; ?>


                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <div class="menu-m">
                                    <span class="menu-global menu-top"></span>
                                    <span class="menu-global menu-middle"></span>
                                    <span class="menu-global menu-bottom"></span>
                                </div>
                            </button>

                            <?php wp_nav_menu(
                                array(
                                'theme_location'    => 'menu-1',
                                'menu_id'        => 'primary-menu',
                                'menu_class'        => 'navbar-nav',
                                'container_class'  => 'collapse navbar-collapse main-nav-toggle right-canvas-menu',
                                'container_id'    => 'navbarNav',
                                )
                                ); 
                            ?>

                            <div class="right-widget d-none-mobile">
                                <?php if(is_active_sidebar('widget-6') ) { ?>
                                <ul>
                                    <?php dynamic_sidebar('widget-6');?>
                                </ul>
                                <?php } ?>
                            </div>


                        </nav>
                    </div>
                </div>
            </div>
        </header>