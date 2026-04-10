<?php $section = get_field('group_banner'); if (empty($section['disable_section'])): ?>
<section class="banner__section banner-one__section"
    style="background-image: url(<?php echo ( get_field('group_banner')['image'] );?>);" aria-label="Banner">
    <div class="container">
        <div class="row">
            <div class="lefts col-lg-6">
                <h1><?php echo ( get_field('group_banner')['title'] );?></h1>
            </div>
            <div class="rights col-lg-6">
            </div>
        </div>
    </div>
</section>
<?php endif; ?>