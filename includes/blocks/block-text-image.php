<!-- if its needed background without container 
add image-no-container-right class on parent div two-side__section-text-image-->
<?php $section = get_field('two-side-text-image-group'); if (empty($section['disable_section'])): ?>
<section class="two-side__section-text-image image-no-container-right" aria-label="Section Text-Image">
    <div class="container">
        <div class="row">
            <div class="lefts col-lg-6">
                <h2><?php echo ( get_field('two-side-text-image-group')['titleh1'] );?></h2>
                <h3><?php echo ( get_field('two-side-text-image-group')['titleh2'] );?></h3>
                <h4><?php echo ( get_field('two-side-text-image-group')['titleh3'] );?></h4>
                <div class="buttons">
                    <div class="default-btn">
                        <a href="<?php echo ( get_field('two-side-text-image-group')['link1'] );?>"
                            class="link-btn"><?php echo ( get_field('two-side-text-image-group')['name1'] );?></a>
                    </div>
                    <div class="default-btn two-btns">
                        <a href="<?php echo ( get_field('two-side-text-image-group')['link2'] );?>"
                            class="link-btn"><?php echo ( get_field('two-side-text-image-group')['name2'] );?></a>
                        <a href="<?php echo ( get_field('two-side-text-image-group')['link3'] );?>"
                            class="link-btn"><?php echo ( get_field('two-side-text-image-group')['name3'] );?></a>
                    </div>
                </div>
            </div>
            <div class="rights col-lg-6">
                <div class="img">
                    <img src="<?php echo ( get_field('two-side-text-image-group')['image'] );?>" alt="Background"
                        loading=“lazy”>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>