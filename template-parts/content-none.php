<?php
/**
 * Template part for displaying a message that posts cannot be found
 */
?>

<section class="no-results not-found container mx-auto px-4 py-12">
    
    <header class="page-header mb-8">
        <h1 class="page-title text-4xl font-heading font-bold text-cyan-400">
            <?php _e('Nothing Found', 'stargazers'); ?>
        </h1>
    </header>
    
    <div class="page-content prose prose-invert prose-slate prose-lg">
        <?php
        if (is_home() && current_user_can('publish_posts')) :
            ?>
            <p><?php printf(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'stargazers'), esc_url(admin_url('post-new.php'))); ?></p>
        <?php elseif (is_search()) : ?>
            <p><?php _e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'stargazers'); ?></p>
            <?php get_search_form(); ?>
        <?php else : ?>
            <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'stargazers'); ?></p>
            <?php get_search_form(); ?>
        <?php endif; ?>
    </div>
    
</section>
