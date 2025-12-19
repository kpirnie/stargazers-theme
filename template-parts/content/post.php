<?php
/**
 * Template part for displaying post content
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('container mx-auto px-4 py-8 mb-12 bg-slate-800 rounded-lg border border-slate-700'); ?>>
    
    <?php if (has_post_thumbnail() && !is_singular()) : ?>
        <div class="entry-thumbnail mb-6 rounded-lg overflow-hidden">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('large', array('class' => 'w-full h-auto hover:opacity-90 transition-opacity')); ?>
            </a>
        </div>
    <?php endif; ?>
    
    <header class="entry-header mb-6">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title text-4xl md:text-5xl font-heading font-bold text-cyan-400 mb-4">', '</h1>');
        else :
            the_title('<h2 class="entry-title text-3xl font-heading font-bold text-cyan-400 mb-4"><a href="' . esc_url(get_permalink()) . '" class="hover:text-cyan-300 transition-colors">', '</a></h2>');
        endif;
        ?>
        
        <div class="entry-meta text-sm text-slate-400 flex flex-wrap gap-4">
            <span class="posted-on">
                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <?php echo get_the_date(); ?>
            </span>
            
            <span class="byline">
                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <?php echo get_the_author(); ?>
            </span>
            
            <?php if (has_category()) : ?>
                <span class="categories">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <?php the_category(', '); ?>
                </span>
            <?php endif; ?>
            
            <?php if (comments_open() || get_comments_number()) : ?>
                <span class="comments-link">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <?php comments_popup_link(__('Leave a comment', 'stargazers'), __('1 Comment', 'stargazers'), __('% Comments', 'stargazers')); ?>
                </span>
            <?php endif; ?>
        </div>
    </header>
    
    <?php if (is_singular() && has_post_thumbnail()) : ?>
        <div class="entry-thumbnail mb-8 rounded-lg overflow-hidden border border-slate-700">
            <?php the_post_thumbnail('large', array('class' => 'w-full h-auto')); ?>
        </div>
    <?php endif; ?>
    
    <div class="entry-content prose prose-invert prose-slate prose-lg max-w-none">
        <?php
        if (is_singular()) {
            the_content();
            
            wp_link_pages(array(
                'before' => '<div class="page-links mt-8 text-slate-400">' . __('Pages:', 'stargazers'),
                'after'  => '</div>',
            ));
        } else {
            the_excerpt();
            ?>
            <a href="<?php the_permalink(); ?>" class="inline-block mt-4 px-6 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition-colors">
                <?php _e('Read More', 'stargazers'); ?>
            </a>
            <?php
        }
        ?>
    </div>
    
    <?php if (is_singular()) : ?>
        <footer class="entry-footer mt-8 pt-8 border-t border-slate-700">
            <?php if (has_tag()) : ?>
                <div class="tags-links mb-4">
                    <svg class="inline w-4 h-4 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <?php the_tags('<span class="text-slate-400">', ', ', '</span>'); ?>
                </div>
            <?php endif; ?>
        </footer>
        
    <?php endif; ?>
    
</article>
