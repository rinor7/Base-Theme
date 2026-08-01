<?php
$section = get_sub_field('group_posts_grid') ?: [];

if (empty($section['disable_section'])):
    $post_type      = !empty($section['post_type']) ? $section['post_type'] : 'post';
    $posts_per_page = isset($section['posts_per_page']) && $section['posts_per_page'] !== '' ? (int)$section['posts_per_page'] : 6;
    $excerpt_length = isset($section['excerpt_length']) && $section['excerpt_length'] !== '' ? (int)$section['excerpt_length'] : 20;

    $font_color_map = array(
        'primary'   => 'var(--primary-color)',
        'secondary' => 'var(--secondary-color)',
        'font'      => 'var(--font-color)',
        'white'     => 'var(--white)',
        'black'     => 'var(--black)',
    );
    $build_heading_style_attr = function ($color_key, $custom_color) use ($font_color_map) {
        if ($color_key === 'custom') {
            if (!empty($custom_color)) {
                return ' style="color:' . esc_attr($custom_color) . ';"';
            }
            return '';
        }
        if (!empty($color_key) && isset($font_color_map[$color_key])) {
            return ' style="color:' . esc_attr($font_color_map[$color_key]) . ';"';
        }
        return '';
    };
    $title_style_attr = $build_heading_style_attr($section['title_color'] ?? '', $section['title_color_custom'] ?? '');
    $subtitle_style_attr = $build_heading_style_attr($section['subtitle_color'] ?? '', $section['subtitle_color_custom'] ?? '');
    $post_title_style_attr = $build_heading_style_attr($section['post_title_color'] ?? '', $section['post_title_color_custom'] ?? '');
    $post_content_style_attr = $build_heading_style_attr($section['post_content_color'] ?? '', $section['post_content_color_custom'] ?? '');

    $bg_color = $section['background_color'] ?? '';
    $padding_desktop = $section['padding_desktop'] ?? '';
    $padding_mobile  = $section['padding_mobile'] ?? '';
    $section_style = '';
    if (!empty($bg_color)) {
        $section_style .= '--section-bg-color:' . $bg_color . ';';
    }
    if ($padding_desktop !== '') {
        $section_style .= '--section-padding-desktop:' . intval($padding_desktop) . 'px;';
    }
    if ($padding_mobile !== '') {
        $section_style .= '--section-padding-mobile:' . intval($padding_mobile) . 'px;';
    }
    $gap_desktop = $section['items_gap_desktop'] ?? '';
    $gap_mobile  = $section['items_gap_mobile'] ?? '';
    if ($gap_desktop !== '') {
        $section_style .= '--posts-grid-gap-desktop:' . intval($gap_desktop) . 'px;';
    }
    if ($gap_mobile !== '') {
        $section_style .= '--posts-grid-gap-mobile:' . intval($gap_mobile) . 'px;';
    }
    $image_height_desktop = $section['image_height_desktop'] ?? '';
    $image_height_mobile  = $section['image_height_mobile'] ?? '';
    if ($image_height_desktop !== '') {
        $section_style .= '--posts-grid-image-height-desktop:' . intval($image_height_desktop) . 'px;';
    }
    if ($image_height_mobile !== '') {
        $section_style .= '--posts-grid-image-height-mobile:' . intval($image_height_mobile) . 'px;';
    }
    $image_border_radius = $section['image_border_radius'] ?? '';
    if ($image_border_radius !== '') {
        $section_style .= '--posts-grid-image-border-radius:' . intval($image_border_radius) . 'px;';
    }
    $section_style_attr = $section_style ? ' style="' . esc_attr($section_style) . '"' : '';

    $enable_slider = !empty($section['enable_slider']);
    $show_arrows   = $enable_slider && !empty($section['show_arrows']);
    $slider_gap_desktop = $gap_desktop !== '' ? intval($gap_desktop) : 16;
    $slider_gap_mobile  = $gap_mobile !== '' ? intval($gap_mobile) : 16;
    $image_fit = ($section['image_fit'] ?? 'cover') === 'contain' ? 'contain' : 'cover';

    $instance_index = get_next_instance_index('posts-grid');
    $section_classes = 'posts-grid posts-grid-index-' . $instance_index . ' image-fit-' . $image_fit;
    if ($enable_slider) {
        $section_classes .= ' posts-grid--slider';
    }
    $custom_class = trim($section['custom_class'] ?? '');
    if ($custom_class !== '') {
        $section_classes .= ' ' . sanitize_text_field($custom_class);
    }

    $title_section    = $section['title_section'] ?? '';
    $subtitle_section = $section['subtitle_section'] ?? '';
    $margin_desktop   = !empty($section['margin_bottom_desktop'])
        ? (int)$section['margin_bottom_desktop'] . 'px'
        : '6px';
    $margin_mobile    = !empty($section['margin_bottom_mobile'])
        ? (int)$section['margin_bottom_mobile'] . 'px'
        : $margin_desktop;

    $header_style = '--mb-desktop:' . $margin_desktop . ';--mb-mobile:' . $margin_mobile . ';';
    if (!empty($section['header_row_gap_desktop'])) {
        $header_style .= '--header-gap-desktop:' . intval($section['header_row_gap_desktop']) . 'px;';
    }
    if (!empty($section['header_row_gap_mobile'])) {
        $header_style .= '--header-gap-mobile:' . intval($section['header_row_gap_mobile']) . 'px;';
    }

    $loop = new WP_Query(array(
        'post_type'      => $post_type,
        'posts_per_page' => $posts_per_page,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));

    if ($loop->have_posts()):
        $col_class = $loop->post_count == 6 ? 'col-lg-4' : 'col-lg-3';

        $render_card = function ($extra_class = '') use ($post_title_style_attr, $post_content_style_attr, $excerpt_length) {
            $thumbnail_alt = '';
            if (has_post_thumbnail()) {
                $thumbnail_id = get_post_thumbnail_id();
                $thumbnail_alt = trim(get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true));
                if ($thumbnail_alt === '') {
                    $thumbnail_alt = get_the_title();
                }
            }
            $card_class = trim('box__wrapper ' . $extra_class);
            ?>
            <a class="<?php echo esc_attr($card_class); ?>" href="<?php echo esc_url(get_permalink()); ?>">
                <?php if (has_post_thumbnail()): ?>
                    <div class="img">
                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'medium_large')); ?>" alt="<?php echo esc_attr($thumbnail_alt); ?>" loading="lazy">
                    </div>
                <?php endif; ?>
                <h2<?php echo $post_title_style_attr; ?>><?php echo esc_html(get_the_title()); ?></h2>
                <div class="post-content"<?php echo $post_content_style_attr; ?>><?php echo esc_html(wp_trim_words(get_the_excerpt(), $excerpt_length, '...')); ?></div>
            </a>
            <?php
        };
?>
<section class="<?php echo esc_attr($section_classes); ?>"<?php echo $section_style_attr; ?>>
    <div class="container">
        <?php if ($title_section || $subtitle_section): ?>
            <div class="section-header" style="<?php echo esc_attr($header_style); ?>">
                <?php if ($title_section): ?>
                    <div class="section-header-title"<?php echo $title_style_attr; ?>><?php echo wp_kses_post(strip_outer_p_tags($title_section)); ?></div>
                <?php endif; ?>
                <?php if ($subtitle_section): ?>
                    <div class="section-header-subtitle"<?php echo $subtitle_style_attr; ?>><?php echo wp_kses_post(strip_outer_p_tags($subtitle_section)); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if ($enable_slider): ?>
            <div class="posts-grid__slider-outer<?php echo $show_arrows ? ' has-arrows' : ''; ?>">
                <div class="posts-grid__slider swiper" data-gap-desktop="<?php echo esc_attr($slider_gap_desktop); ?>" data-gap-mobile="<?php echo esc_attr($slider_gap_mobile); ?>">
                    <div class="swiper-wrapper">
                        <?php while ($loop->have_posts()): $loop->the_post(); ?>
                            <div class="swiper-slide">
                                <?php $render_card(); ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="swiper-scrollbar"></div>
                </div>
                <?php if ($show_arrows): ?>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="row">
                <?php while ($loop->have_posts()): $loop->the_post(); ?>
                    <?php $render_card($col_class); ?>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</section>
<?php endif; endif; ?>
