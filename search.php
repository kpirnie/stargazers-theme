<?php
/**
 * The template for displaying search results pages
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

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
        
        <?php get_template_part('template-parts/navigation/archive', 'pagination'); ?>

        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Main Content -->
                <div class="md:col-span-2">
                    
                    <div class="space-y-6">
                        <?php
                        while (have_posts()) :
                            the_post();
                            get_template_part('template-parts/content/post');
                        endwhile;
                        ?>
                    </div>
                    
                </div>

                <!-- Sidebar -->
                <div class="md:col-span-1">
                    <?php get_template_part('template-parts/blog', 'sidebar'); ?>
                </div>

            </div>
        </div>

        <?php get_template_part('template-parts/navigation/archive', 'pagination'); ?>

        <?php
    else :
        
        get_template_part('template-parts/content/none');
        
    endif;
    ?>
    
</main>

<?php
get_footer();
