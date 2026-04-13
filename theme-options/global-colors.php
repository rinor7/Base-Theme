<?php

function my_theme_color_settings($wp_customize) {

    // SECTION (optional, you can reuse 'colors' too)
    $wp_customize->add_section('theme_colors_section', [
        'title' => 'Theme Colors',
        'priority' => 30,
    ]);

    // PRIMARY COLOR
    $wp_customize->add_setting('primary_color', [
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            [
                'label' => 'Primary Color',
                'section' => 'theme_colors_section',
            ]
        )
    );

    // SECONDARY COLOR
    $wp_customize->add_setting('secondary_color', [
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'secondary_color',
            [
                'label' => 'Secondary Color',
                'section' => 'theme_colors_section',
            ]
        )
    );

}
add_action('customize_register', 'my_theme_color_settings');

function my_theme_dynamic_colors() {

    $primary = get_theme_mod('primary_color');
    $secondary = get_theme_mod('secondary_color');

    $css = ':root {';

    if (!empty($primary)) {
        $css .= '--primary-color:' . esc_attr($primary) . ';';
    }

    if (!empty($secondary)) {
        $css .= '--secondary-color:' . esc_attr($secondary) . ';';
    }

    $css .= '}';

    echo '<style>' . $css . '</style>';
}

add_action('wp_head', 'my_theme_dynamic_colors');