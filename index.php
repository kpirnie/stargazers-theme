<?php
/**
 * The main template file
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

get_header();
?>

<main id="primary" class="site-main">
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            
            if (is_singular()) {
                get_template_part('template-parts/content/page');
            } else {
                get_template_part('template-parts/content/post');
            }
            
        }
        
        if (!is_singular()) {
            get_template_part('template-parts/navigation/archive', 'pagination');
        }
        
    } else {
        get_template_part('template-parts/content/none');
    }
    ?>
</main>

<?php
get_footer();