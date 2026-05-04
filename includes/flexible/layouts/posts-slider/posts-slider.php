<?php
$section = get_sub_field('group_posts_slider') ?: [];

if (empty($section['disable_section'])):
    $post_type      = !empty($section['post_type']) ? $section['post_type'] : 'post';
    $posts_per_page = isset($section['posts_per_page']) && $section['posts_per_page'] !== '' ? (int)$section['posts_per_page'] : -1;

    $font_color_map = array(
        'primary'   => 'var(--primary-color)',
        'secondary' => 'var(--secondary-color)',
        'font'      => 'var(--font-color)',
        'white'     => 'var(--white)',
        'black'     => 'var(--black)',
    );
    $font_color_key = $section['font_color'] ?? '';
    $heading_style_attr = '';
    if ($font_color_key === 'custom') {
        $custom_color = $section['font_color_custom'] ?? '';
        if (!empty($custom_color)) {
            $heading_style_attr = ' style="color:' . esc_attr($custom_color) . ';"';
        }
    } elseif (!empty($font_color_key) && isset($font_color_map[$font_color_key])) {
        $heading_style_attr = ' style="color:' . esc_attr($font_color_map[$font_color_key]) . ';"';
    }

    $title_section    = $section['title_section'] ?? '';
    $subtitle_section = $section['subtitle_section'] ?? '';
    $margin_desktop   = !empty($section['margin_bottom_desktop'])
        ? (int)$section['margin_bottom_desktop'] . 'px'
        : '6px';
    $margin_mobile    = !empty($section['margin_bottom_mobile'])
        ? (int)$section['margin_bottom_mobile'] . 'px'
        : $margin_desktop;

    $loop = new WP_Query(array(
        'post_type'      => $post_type,
        'posts_per_page' => $posts_per_page,
        'order'          => 'ASC',
    ));

    if ($loop->have_posts()):
?>
<section class="posts-slider">
    <div class="container">
        <?php if ($title_section || $subtitle_section): ?>
            <div class="section-header" style="--mb-desktop:<?php echo esc_attr($margin_desktop); ?>;--mb-mobile:<?php echo esc_attr($margin_mobile); ?>;">
                <?php if ($title_section): ?>
                    <div class="section-header-title"<?php echo $heading_style_attr; ?>><?php echo wp_kses_post(strip_outer_p_tags($title_section)); ?></div>
                <?php endif; ?>
                <?php if ($subtitle_section): ?>
                    <div class="section-header-subtitle"<?php echo $heading_style_attr; ?>><?php echo wp_kses_post(strip_outer_p_tags($subtitle_section)); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="swiper mySwiper mySwiper-posts-slider">
            <div class="swiper-wrapper">
                <?php while ($loop->have_posts()): $loop->the_post(); ?>
                    <div class="swiper-slide">
                        <div class="slider-wrap">
                            <?php if (has_post_thumbnail()): ?>
                                <div class="img">
                                    <img src="<?php the_post_thumbnail_url(); ?>" alt="" loading="lazy">
                                </div>
                            <?php endif; ?>
                            <h2<?php echo $heading_style_attr; ?>><?php the_title(); ?></h2>
                            <div class="post-content"<?php echo $heading_style_attr; ?>><?php the_content(); ?></div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
</section>
<?php endif; endif; ?>
