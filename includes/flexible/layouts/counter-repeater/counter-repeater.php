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
?>
<section class="counter-repeater counter-repeater--items-<?php echo esc_attr($count); ?>">
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
                        <div class="countdown" data-target="<?php echo esc_attr($target); ?>" data-suffix="<?php echo esc_attr($suffix); ?>"<?php echo $heading_style_attr; ?>></div>
                        <p<?php echo $heading_style_attr; ?>><?php echo esc_html($label); ?></p>
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
