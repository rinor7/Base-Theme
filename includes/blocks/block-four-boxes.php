<?php if (!get_field('four_box-default')['disable_section'] ?? false): ?>
<section class="four__boxes" aria-label="Section with Four Boxes">
    <div class="container">
        <?php render_section_header('four_box-default'); ?>
        <div class="row">
            <div class="box col-lg-3 col-sm-3">
                <div class="box__wrap">
                    <div class="img">
                        <img src="<?php echo ( get_field('four_box-default')['box1img'] );?>" alt="Image"
                            loading=“lazy”>
                    </div>
                    <h2><?php echo ( get_field('four_box-default')['title1'] );?></h2>
                    <p><?php echo ( get_field('four_box-default')['sub1'] );?></p>
                </div>
            </div>
            <div class="box col-lg-3 col-sm-3">
                <div class="box__wrap">
                    <div class="img">
                        <img src="<?php echo ( get_field('four_box-default')['box2img'] );?>" alt="Image"
                            loading=“lazy”>
                    </div>
                    <h2><?php echo ( get_field('four_box-default')['title2'] );?></h2>
                    <p><?php echo ( get_field('four_box-default')['sub2'] );?></p>
                </div>
            </div>
            <div class="box col-lg-3 col-sm-3">
                <div class="box__wrap">
                    <div class="img">
                        <img src="<?php echo ( get_field('four_box-default')['box3img'] );?>" alt="Image"
                            loading=“lazy”>
                    </div>
                    <h2><?php echo ( get_field('four_box-default')['title3'] );?></h2>
                    <p><?php echo ( get_field('four_box-default')['sub3'] );?></p>
                </div>
            </div>
            <div class="box col-lg-3 col-sm-3">
                <div class="box__wrap">
                    <div class="img">
                        <img src="<?php echo ( get_field('four_box-default')['box4img'] );?>" alt="Image"
                            loading=“lazy”>
                    </div>
                    <h2><?php echo ( get_field('four_box-default')['title4'] );?></h2>
                    <p><?php echo ( get_field('four_box-default')['sub4'] );?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>