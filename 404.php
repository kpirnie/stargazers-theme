<?php
/**
 * The template for displaying 404 pages (not found)
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

get_header();
?>

<main id="primary" class="site-main">
    
    <section class="error-404 not-found container mx-auto px-4 py-12">
        
        <header class="page-header mb-8 text-center">
            <h1 class="page-title text-6xl md:text-8xl font-heading font-bold text-cyan-400 mb-4">
                404
            </h1>
            <p class="text-2xl text-slate-300">
                <?php _e('Lost in Space', 'stargazers'); ?>
            </p>
        </header>
        
        <div class="page-content max-w-2xl mx-auto text-center">
            <p class="text-lg text-slate-400 mb-8">
                <?php _e('It looks like you\'ve ventured into uncharted territory. The page you\'re looking for doesn\'t exist in this galaxy.', 'stargazers'); ?>
            </p>
            
            <div class="mb-8">
                <?php get_search_form(); ?>
            </div>
            
            <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block px-8 py-3 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition-colors text-lg">
                <?php _e('Return to Home Base', 'stargazers'); ?>
            </a>
        </div>
        
    </section>
    
</main>

<?php
get_footer();
