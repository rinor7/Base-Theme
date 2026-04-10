<?php 

function menu_setup() {
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Praimary Menu', 'base-theme' ),
			'menu-2' => esc_html__( 'Footer Menu', 'base-theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'menu_setup' );