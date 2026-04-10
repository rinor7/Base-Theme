<!-- if its needed background without container 
add image-no-container-left class on parent div two-side__section-image-text-->
<?php $section = get_field('two-side-image-text-group'); if (empty($section['disable_section'])): ?>
<section class="two-side__section-image-text" aria-label="Section Image-Text">
    <div class="container">
        <div class="row">
            <div class="lefts col-lg-6">

                <div class="img">
                    <img src="<?php echo ( get_field('two-side-image-text-group')['image'] );?>" alt="Background"
                        loading=“lazy”>
                </div>

            </div>
            <div class="rights col-lg-6">
                <h2><?php echo ( get_field('two-side-image-text-group')['titleh1'] );?></h2>
                <h3><?php echo ( get_field('two-side-image-text-group')['titleh2'] );?></h3>
                <h4><?php echo ( get_field('two-side-image-text-group')['titleh3'] );?></h4>

                <div class="buttons">
                    <div class="default-btn">
                        <a href="<?php echo ( get_field('two-side-image-text-group')['link1'] );?>"
                            class="link-btn"><?php echo ( get_field('two-side-image-text-group')['name1'] );?></a>
                    </div>
                    <div class="default-btn two-btns">
                        <a href="<?php echo ( get_field('two-side-image-text-group')['link2'] );?>"
                            class="link-btn"><?php echo ( get_field('two-side-image-text-group')['name2'] );?></a>
                        <a href="<?php echo ( get_field('two-side-image-text-group')['link3'] );?>"
                            class="link-btn"><?php echo ( get_field('two-side-image-text-group')['name3'] );?></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<?php endif; ?>