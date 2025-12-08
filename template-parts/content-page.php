<?php
/**
 * Template part for displaying page content
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('container mx-auto px-4 py-12'); ?>>
    
    <header class="entry-header mb-8">
        <?php the_title('<h1 class="entry-title text-4xl md:text-5xl font-heading font-bold text-cyan-400 mb-4">', '</h1>'); ?>
    </header>
    
    <?php if (has_post_thumbnail()) : ?>
        <div class="entry-thumbnail mb-8 rounded-lg overflow-hidden border border-slate-700">
            <?php the_post_thumbnail('large', array('class' => 'w-full h-auto parallax')); ?>
        </div>
    <?php endif; ?>
    
    <div class="entry-content prose prose-invert prose-slate prose-lg max-w-none">
        <?php
        the_content();
        
        wp_link_pages(array(
            'before' => '<div class="page-links mt-8 text-slate-400">' . __('Pages:', 'stargazers'),
            'after'  => '</div>',
        ));
        ?>
    </div>
    
</article>
