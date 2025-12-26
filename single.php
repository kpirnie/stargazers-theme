<?php
/**
 * The template for displaying single posts
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

get_header();
?>

<main id="primary" class="site-main">
    
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Main Content -->
            <div class="md:col-span-2">
                
                <?php
                while (have_posts()) :
                    the_post();
                    
                    get_template_part('template-parts/content/post');
                    
                endwhile;
                ?>

                <!-- Post navigation -->
                <div class="mt-6">
                    <?php get_template_part('template-parts/navigation/single', 'pagination'); ?>
                </div>
                
            </div>

            <!-- Sidebar -->
            <div class="md:col-span-1">
                <?php get_template_part('template-parts/blog', 'sidebar'); ?>
            </div>

        </div>
    </div>
    
</main>

<?php
get_footer();