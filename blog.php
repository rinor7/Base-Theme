<?php //Template Name: Blog
global $header_type; // required to access global variable
include("includes/headers/{$header_type}.php"); 
?>

<main id="primary" class="site-blog">

    <?php include("includes/blocks/hero.php"); ?>
    
    <?php include("includes/blocks/blogs.php"); ?>

</main>

<?php include("includes/footers/default.php"); ?>