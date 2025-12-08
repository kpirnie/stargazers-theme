<?php
/**
 * The template for displaying search results pages
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <?php if (have_posts()) : ?>
        
        <header class="page-header container mx-auto px-4 py-12 mb-8">
            <h1 class="page-title text-4xl md:text-5xl font-heading font-bold text-cyan-400 mb-4">
                <?php
                printf(
                    esc_html__('Search Results for: %s', 'stargazers'),
                    '<span class="text-slate-300">' . get_search_query() . '</span>'
                );
                ?>
            </h1>
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
