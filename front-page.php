<?php
/**
 * The template for displaying the front page
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while (have_posts()) :
        the_post();
        
        get_template_part('template-parts/content/home');
        
    endwhile;
    ?>
</main>

<?php
get_footer();
