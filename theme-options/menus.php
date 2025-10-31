<?php 

function menu_setup() {
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Main Header Menu', 'base-theme' ),
			'menu-2' => esc_html__( 'Footer Menu', 'base-theme' ),
			'menu-3' => esc_html__( 'Announcement Menu', 'base-theme' ),
			'menu-4' => esc_html__( 'Main Left Header Menu ( when centerized logo)', 'base-theme' ),
			'menu-5' => esc_html__( 'Main Right Header Menu ( when centerized logo)', 'base-theme' ),
			'menu-6' => esc_html__( 'Main Left&Right Header Menu ( when centerized logo)', 'base-theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'menu_setup' );