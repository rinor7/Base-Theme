<?php
$section = get_sub_field('group_counter') ?: [];
if (empty($section['disable_section'])):
    $items = $section['items'] ?? [];
    if (!empty($items)):
        $count = count($items);
        $col_class = $count === 3 ? 'col-lg-4 col-sm-4' : 'col-lg-3 col-sm-3';

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
        $number_style_attr = $build_heading_style_attr($section['number_color'] ?? '', $section['number_color_custom'] ?? '');
        $label_style_attr = $build_heading_style_attr($section['label_color'] ?? '', $section['label_color_custom'] ?? '');

        $build_background_style = function ($type, $custom_color, $gradient) use ($font_color_map) {
            if ($type === 'gradient') {
                $gradient = trim($gradient);
                return $gradient !== '' ? 'background:' . $gradient . ';' : '';
            }
            if ($type === 'custom') {
                return !empty($custom_color) ? 'background-color:' . $custom_color . ';' : '';
            }
            if (!empty($type) && isset($font_color_map[$type])) {
                return 'background-color:' . $font_color_map[$type] . ';';
            }
            return '';
        };

        $padding_desktop = $section['padding_desktop'] ?? '';
        $padding_mobile  = $section['padding_mobile'] ?? '';
        $section_style = $build_background_style($section['background_color'] ?? '', $section['background_color_custom'] ?? '', $section['background_gradient'] ?? '');
        if ($padding_desktop !== '') {
            $section_style .= '--section-padding-desktop:' . intval($padding_desktop) . 'px;';
        }
        if ($padding_mobile !== '') {
            $section_style .= '--section-padding-mobile:' . intval($padding_mobile) . 'px;';
        }
        $section_style_attr = $section_style ? ' style="' . esc_attr($section_style) . '"' : '';

        $section_classes = 'counter-repeater counter-repeater--items-' . $count;
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
        <div class="row">
            <?php foreach ($items as $item):
                $target    = $item['target'] ?? '';
                $label     = $item['label'] ?? '';
                $show_plus = !empty($item['show_plus']);
                $suffix    = $show_plus ? '+' : '';
                if ($target === '' && $label === '') continue;
            ?>
                <div class="box <?php echo esc_attr($col_class); ?>">
                    <div class="box__wrap">
                        <div class="countdown" data-target="<?php echo esc_attr($target); ?>" data-suffix="<?php echo esc_attr($suffix); ?>"<?php echo $number_style_attr; ?>></div>
                        <p<?php echo $label_style_attr; ?>><?php echo esc_html($label); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<script>
(function () {
    function initCountdowns() {
        var countdowns = document.querySelectorAll('.counter-repeater .countdown');

        countdowns.forEach(function (element) {
            if (element.dataset.initialized === 'true') return;
            element.dataset.initialized = 'true';

            var target = parseInt(element.getAttribute('data-target'), 10);
            var suffix = element.getAttribute('data-suffix') || '';
            if (isNaN(target) || target <= 0) {
                element.textContent = (element.getAttribute('data-target') || '') + suffix;
                return;
            }

            var current = 0;
            var intervalId = setInterval(function () {
                current++;
                element.textContent = current + suffix;
                if (current === target) {
                    clearInterval(intervalId);
                }
            }, 20);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCountdowns);
    } else {
        initCountdowns();
    }
})();
</script>
<?php endif; endif; ?>
