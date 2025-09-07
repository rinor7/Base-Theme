<?php
/* Template Name: Home */
global $header_type; // required to access global variable
include("includes/headers/{$header_type}.php");
?>

<main id="primary" class="site-main">

<?php get_template_part('includes/blocks/block-banner-all', null, array()); ?>

<?php get_template_part('includes/blocks/block-four-boxes-counter', null, array()); ?>

<?php get_template_part('includes/blocks/block-four-boxes', null, array()); ?>

<?php get_template_part('includes/blocks/pt-boxes-noswiper', null, array()); ?>

<?php get_template_part('includes/blocks/pt-boxes-swiper', null, array()); ?>

<?php get_template_part('includes/blocks/quick-section', null, array()); ?>

<?php get_template_part('includes/blocks/block-image-text', null, array()); ?>

<?php get_template_part('includes/blocks/block-text-image', null, array()); ?>

</main>

<?php include("includes/footers/default.php");  ?>