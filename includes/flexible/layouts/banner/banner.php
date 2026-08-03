<?php 
$banner = get_sub_field('group_banner') ?: [];
if (empty($banner['disable_section'])): 
    $video_url = $banner['video'] ?? '';
    $image_url = $banner['image'] ?? '';
    $overlay_color = $banner['video_overlay_color'] ?? '#000000a1';
    $bg_overlay_color = $banner['background_overlay_color'] ?? '#000000a1';
    $bg_overlay_gradient = trim($banner['background_overlay_gradient'] ?? '');
    $bg_overlay_style = $bg_overlay_gradient
        ? 'background: ' . $bg_overlay_gradient . ';'
        : 'background-color: ' . $bg_overlay_color . ';';

    // Height, padding and gap are set as CSS custom properties so they respond to
    // the actual viewport (min-md breakpoint) instead of server-side UA sniffing.
    $min_height_desktop = $banner['min_height_desktop'] ?? '';
    $min_height_mobile  = $banner['min_height_mobile'] ?? '';
    $padding_desktop    = $banner['padding_desktop'] ?? '';
    $padding_mobile     = $banner['padding_mobile'] ?? '';

    $instance_index = get_next_instance_index('banner');
    $section_classes = 'banner__section banner__section-index-' . $instance_index;

    $custom_class = trim($banner['custom_class'] ?? '');
    if ($custom_class !== '') {
        $section_classes .= ' ' . sanitize_text_field($custom_class);
    }

    $inline_style = '';
    if ($min_height_desktop !== '') {
        $inline_style .= '--banner-height-desktop:' . intval($min_height_desktop) . 'px;';
    }
    if ($min_height_mobile !== '') {
        $inline_style .= '--banner-height-mobile:' . intval($min_height_mobile) . 'px;';
    }
    if ($padding_desktop !== '') {
        $inline_style .= '--banner-padding-desktop:' . intval($padding_desktop) . 'px;';
    }
    if ($padding_mobile !== '') {
        $inline_style .= '--banner-padding-mobile:' . intval($padding_mobile) . 'px;';
    }
    if (!$video_url && $image_url) {
        $inline_style .= 'background-image:url(' . esc_url($image_url) . ');';
    }
?>
<section class="<?php echo esc_attr($section_classes); ?>"
    <?php if (!empty($inline_style)): ?>style="<?php echo esc_attr($inline_style); ?>"<?php endif; ?>
    aria-label="Banner">

    <?php if ($video_url): ?>
        <div class="video-wrapper">
            <video autoplay muted loop playsinline preload="auto" class="banner-video">
                <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="overlay" style="background-color: <?php echo esc_attr( $overlay_color ); ?>;"></div>
        </div>
    <?php else: ?>
        <div class="image-overlay" style="<?php echo esc_attr($bg_overlay_style); ?>"></div>
    <?php endif; ?>

    <?php
    $content_width   = $banner['content_width'] ?? 'two_columns';
    $right_image_field = $banner['right_image'] ?? null;
    $right_image     = $right_image_field['url'] ?? '';
    $right_image_alt = trim($right_image_field['alt'] ?? '');
    if ($right_image_alt === '') {
        if (!empty($banner['title'])) {
            $right_image_alt = wp_strip_all_tags($banner['title']);
        } elseif (!empty($banner['subtitle'])) {
            $right_image_alt = wp_strip_all_tags($banner['subtitle']);
        }
    }
    $right_image_radius = $banner['right_image_border_radius'] ?? '';
    $right_image_height_desktop = $banner['right_image_height_desktop'] ?? '';
    $right_image_height_mobile  = $banner['right_image_height_mobile'] ?? '';
    $right_image_fit = ($banner['right_image_fit'] ?? 'cover') === 'contain' ? 'contain' : 'cover';
    $right_image_class = 'rights image-fit-' . $right_image_fit;
    $right_image_style = '';
    if ($right_image_radius !== '') {
        $right_image_style .= '--right-image-border-radius:' . intval($right_image_radius) . 'px;';
    }
    if ($right_image_height_desktop !== '') {
        $right_image_style .= '--right-image-height-desktop:' . intval($right_image_height_desktop) . 'px;';
    }
    if ($right_image_height_mobile !== '') {
        $right_image_style .= '--right-image-height-mobile:' . intval($right_image_height_mobile) . 'px;';
    }
    $right_image_style_attr = $right_image_style ? ' style="' . esc_attr($right_image_style) . '"' : '';
    $right_col_class = '';

    switch ($content_width) {
        case 'narrow':
            $col_class = 'col-lg-5';
            $right_col_class = 'col-lg-7';
            break;
        case 'two_columns':
            $col_class = 'col-lg-6';
            $right_col_class = 'col-lg-6';
            break;
        case 'wide':
            $col_class = 'col-lg-7';
            $right_col_class = 'col-lg-5';
            break;
        case 'full_width':
        default:
            $col_class = 'col-lg-12';
            break;
    }

    $has_right_image = $right_col_class && !empty($right_image);
    $reverse_layout  = $has_right_image && !empty($banner['reverse_layout']);
    $row_class       = 'row' . ($reverse_layout ? ' flex-lg-row-reverse' : '');
    ?>
    <div class="container">
        <div class="<?php echo esc_attr($row_class); ?>">
           <?php

            // Desktop alignment only for full width
            $alignment_desktop = $banner['content_alignment'] ?? 'center'; // left | center

            // Mobile alignment always available
            $alignment_mobile  = $banner['content_alignment_mobile'] ?? 'center'; // left | center

            // Build classes
            $alignment_class = '';
            if ($col_class === 'col-lg-12') {
                $alignment_class .= ' align-desktop-' . $alignment_desktop;
            }
            $alignment_class .= ' align-mobile-' . $alignment_mobile;

            $allowed_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p');
            $title_tag = $banner['title_tag'] ?? 'h1';
            $subtitle_tag = $banner['subtitle_tag'] ?? 'p';

            if (!in_array($title_tag, $allowed_tags, true)) {
                $title_tag = 'h1';
            }
            if (!in_array($subtitle_tag, $allowed_tags, true)) {
                $subtitle_tag = 'p';
            }

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
            $title_style_attr = $build_heading_style_attr($banner['title_color'] ?? '', $banner['title_color_custom'] ?? '');
            $subtitle_style_attr = $build_heading_style_attr($banner['subtitle_color'] ?? '', $banner['subtitle_color_custom'] ?? '');

            $row_gap_desktop = $banner['row_gap_desktop'] ?? '';
            $row_gap_mobile  = $banner['row_gap_mobile'] ?? '';
            $lefts_style = '';
            if ($row_gap_desktop !== '') {
                $lefts_style .= '--row-gap-desktop:' . intval($row_gap_desktop) . 'px;';
            }
            if ($row_gap_mobile !== '') {
                $lefts_style .= '--row-gap-mobile:' . intval($row_gap_mobile) . 'px;';
            }
            $lefts_style_attr = $lefts_style ? ' style="' . esc_attr($lefts_style) . '"' : '';
            ?>
            <div class="lefts <?php echo esc_attr($col_class . ' ' . $alignment_class); ?>"<?php echo $lefts_style_attr; ?>>
                <?php if (!empty($banner['title'])): ?>
                    <<?php echo esc_attr($title_tag); ?><?php echo $title_style_attr; ?>><?php echo esc_html($banner['title']); ?></<?php echo esc_attr($title_tag); ?>>
                <?php endif; ?>

                <?php if (!empty($banner['subtitle'])): ?>
                    <<?php echo esc_attr($subtitle_tag); ?><?php echo $subtitle_style_attr; ?>><?php echo esc_html($banner['subtitle']); ?></<?php echo esc_attr($subtitle_tag); ?>>
                <?php endif; ?>

                <?php
                $button_1 = $banner['button_1'] ?? '';
                $button_2 = $banner['button_2'] ?? '';
                $has_btn_1 = is_array($button_1) && !empty($button_1['url']) && !empty($button_1['title']);
                $has_btn_2 = is_array($button_2) && !empty($button_2['url']) && !empty($button_2['title']);
                $button_1_style = ($banner['button_1_style'] ?? 'btn-1') === 'btn-2' ? 'btn-style-2' : 'btn-style-1';
                $button_2_style = ($banner['button_2_style'] ?? 'btn-1') === 'btn-2' ? 'btn-style-2' : 'btn-style-1';
                ?>
                <?php if ($has_btn_1 || $has_btn_2): ?>
                    <div class="buttons">
                        <?php if ($has_btn_1): ?>
                            <div class="default-btn">
                                <a href="<?php echo esc_url($button_1['url']); ?>" class="link-btn <?php echo esc_attr($button_1_style); ?>"<?php if (!empty($button_1['target'])): ?> target="<?php echo esc_attr($button_1['target']); ?>" rel="noopener noreferrer"<?php endif; ?>>
                                    <?php echo esc_html($button_1['title']); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if ($has_btn_2): ?>
                            <div class="default-btn two-btns">
                                <a href="<?php echo esc_url($button_2['url']); ?>" class="link-btn <?php echo esc_attr($button_2_style); ?>"<?php if (!empty($button_2['target'])): ?> target="<?php echo esc_attr($button_2['target']); ?>" rel="noopener noreferrer"<?php endif; ?>>
                                    <?php echo esc_html($button_2['title']); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($has_right_image): ?>
                <div class="<?php echo esc_attr($right_image_class . ' ' . $right_col_class); ?>"<?php echo $right_image_style_attr; ?>>
                    <img src="<?php echo esc_url($right_image); ?>" alt="<?php echo esc_attr($right_image_alt); ?>">
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>