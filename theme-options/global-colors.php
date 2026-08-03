<?php

function my_theme_color_settings($wp_customize) {

    // SECTION
    $wp_customize->add_section('theme_colors_section', [
        'title' => 'Theme Colors',
        'priority' => 30,
        'description' => 'These colors are available everywhere on the site as CSS variables — including in any "Custom CSS Class" field. There are also two fixed variables always available: var(--white) and var(--black).',
    ]);

    // PRIMARY COLOR
    $wp_customize->add_setting('primary_color', [
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            [
                'label' => 'Primary Color',
                'description' => 'CSS variable: var(--primary-color)',
                'section' => 'theme_colors_section',
            ]
        )
    );

    // SECONDARY COLOR
    $wp_customize->add_setting('secondary_color', [
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'secondary_color',
            [
                'label' => 'Secondary Color',
                'description' => 'CSS variable: var(--secondary-color)',
                'section' => 'theme_colors_section',
            ]
        )
    );

    // FONT COLOR
    $wp_customize->add_setting('font_color', [
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'font_color',
            [
                'label' => 'Font Color',
                'description' => 'CSS variable: var(--font-color)',
                'section' => 'theme_colors_section',
            ]
        )
    );

}
add_action('customize_register', 'my_theme_color_settings');


function my_theme_dynamic_colors() {

    // Single source of truth for theme color CSS custom properties.
    // Defaults are used when the Customizer setting is empty.
    // NOTE: keep these defaults in sync with the SCSS variables in
    // assets/scss/other/_variables.scss ($primary-color, $secondary-color,
    // $font-color, $white, $black). PHP cannot read SCSS at runtime.
    $colors = array(
        '--primary-color'   => get_theme_mod('primary_color')   ?: 'coral',
        '--secondary-color' => get_theme_mod('secondary_color') ?: '#000',
        '--font-color'      => get_theme_mod('font_color')      ?: '#000',
        '--white'           => '#fff',
        '--black'           => '#000',
    );

    $css = ':root{';
    foreach ($colors as $name => $value) {
        $css .= $name . ':' . esc_attr($value) . ';';
    }
    $css .= '}';

    echo '<style>' . $css . '</style>';
}
add_action('wp_head', 'my_theme_dynamic_colors');