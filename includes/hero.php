<?php
// Automatic hero for Posts/CPTs, their archives, and taxonomy term archives — driven entirely by
// Theme Settings > Hero Banners (see theme-options/general-functions.php for the resolution logic).
// Pages use a separate mechanism (the flexible content Hero module + base_theme_render_automatic_page_hero()).

if (is_tax() || is_category() || is_tag()) {
    $term = get_queried_object();
    $page_title = $term->name;
    $hero = base_theme_get_automatic_taxonomy_hero($term);

} elseif (is_home()) {
    $page_title = get_the_title(get_option('page_for_posts'));
    $hero = base_theme_get_automatic_archive_hero('post');

} elseif (is_post_type_archive()) {
    $post_type = get_post_type();
    $post_type_object = get_post_type_object($post_type);
    $page_title = $post_type_object ? $post_type_object->labels->singular_name : '';
    $hero = base_theme_get_automatic_archive_hero($post_type);

} elseif (is_singular()) {
    $page_title = get_the_title();
    $hero = base_theme_get_automatic_post_hero();

} else {
    $page_title = '';
    $hero = null;
}

if ($hero) {
    base_theme_render_hero_section($hero, $page_title);
}
