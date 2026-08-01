<?php

function standard_widgets_init() {
	register_sidebar(
		array('name'          => esc_html__( 'Custom Button', 'base-theme' ),
			'id'            => 'widget-1',
			'description'   => esc_html__( 'Add widgets here to appear in your site footer.', 'base-theme' ),
			'before_widget' => '<div class="widget-wrapper">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="widget-title">',
			'after_title'   => '</span>',)
	);
	register_sidebar(
		array('name'          => esc_html__( 'Footer Column 2', 'base-theme' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here to appear in your site footer.', 'base-theme' ),
			'before_widget' => '<div class="widget-wrapper">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="widget-title">',
			'after_title'   => '</span>',)
	);
	register_sidebar(
		array('name'          => esc_html__( 'Footer Column 3', 'base-theme' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here to appear in your site footer.', 'base-theme' ),
			'before_widget' => '<div class="widget-wrapper">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="widget-title">',
			'after_title'   => '</span>',)
	);
	register_sidebar(
		array('name'          => esc_html__( 'Footer Column 4', 'base-theme' ),
			'id'            => 'footer-4',
			'description'   => esc_html__( 'Add widgets here to appear in your site footer.', 'base-theme' ),
			'before_widget' => '<div class="widget-wrapper">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="widget-title">',
			'after_title'   => '</span>',)
	);
}
add_action( 'widgets_init', 'standard_widgets_init' );