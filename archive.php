<?php
/**
 * The template for displaying archive pages
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

get_header();
?>

<main id="primary" class="site-main">
    
    <?php if (have_posts()) : ?>
        
        <header class="bg-slate-900 border-b border-slate-800">
            <div class="container mx-auto px-4 py-6">
                <?php
                the_archive_title('<h1 class="text-4xl font-heading font-bold text-cyan-400">', '</h1>');
                the_archive_description('<div class="text-slate-400 mt-2">', '</div>');
                ?>
            </div>
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
        
    <?php else : ?>
        
        <div class="container mx-auto px-4 py-12">
            <?php get_template_part('template-parts/content/none'); ?>
        </div>
        
    <?php endif; ?>
    
</main>

<?php
get_footer();