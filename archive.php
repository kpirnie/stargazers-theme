<?php
/**
 * The template for displaying archive pages
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

get_header();
?>

<main id="primary" class="site-main">
    
    <?php if (have_posts()) : ?>
        
        <header class="page-header container mx-auto px-4 py-12 mb-8">
            <?php
            the_archive_title('<h1 class="page-title text-4xl md:text-5xl font-heading font-bold text-cyan-400 mb-4">', '</h1>');
            the_archive_description('<div class="archive-description text-lg text-slate-400">', '</div>');
            ?>
        </header>
        
        <?php
        while (have_posts()) :
            the_post();
            get_template_part('template-parts/content', 'post');
        endwhile;
        
        get_template_part('template-parts/pagination');
        
    else :
        
        get_template_part('template-parts/content', 'none');
        
    endif;
    ?>
    
</main>

<?php
get_footer();
