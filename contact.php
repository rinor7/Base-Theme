<?php
/* Template Name: Contact */
global $header_type; // required to access global variable
include("includes/headers/{$header_type}.php");
?>

<main id="primary" class="site-main site-contact">

<?php include("includes/blocks/hero.php"); ?>

<div class="container">
    <?php the_content(); ?>
</div>

</main>

<?php include("includes/footers/default.php");  ?>