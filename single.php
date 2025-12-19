<?php
/**
 * The template for displaying single posts
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while (have_posts()) :
        the_post();
        
        get_template_part('template-parts/content/post');
        
        // Post navigation
        get_template_part( 'template-parts/navigation/single', 'pagination' );
        
    endwhile;
    ?>
</main>

<?php
get_footer();
