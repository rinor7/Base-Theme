<?php

function site_identity_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	// add_theme_support( 'custom-logo', array(
	// 	'height' => 480,
	// 	'width'  => 720,
	// 	'flex-width'  => true,
	// 	'flex-height' => true,
	// ) );
    // add_theme_support('dark-logo', array(
    //     'height' => 480,
    //     'width'  => 720,
	// 	'flex-width'  => true,
	// 	'flex-height' => true,
    // ));
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'site_identity_setup' );


//Add Dark Logo
// function custom_customize_register_logo($wp_customize) {
//     $wp_customize->add_setting('dark_logo');
//     $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'dark_logo', array(
//         'label'         => __('Logo Dark', 'standard'),
//         'section'       => 'title_tagline',
//         'settings'      => 'dark_logo',
//         'width'         => 720,
//         'height'        => 480,
//     )));
// }
// add_action('customize_register', 'custom_customize_register_logo');