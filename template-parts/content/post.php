<?php
/**
 * Template part for displaying post content
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// Determine if we're in archive/list view
$is_archive = !is_singular();

?>

<article id="post-<?php the_ID(); ?>" <?php post_class($is_archive ? 'bg-slate-800 border border-slate-700 overflow-hidden rounded-lg' : 'container mx-auto px-4 py-8 mb-12 bg-slate-800 rounded-lg border border-slate-700'); ?>>
    
    <?php if ($is_archive) : ?>

        <!-- Archive/List View Layout -->
        <div class="flex gap-4 p-4">
            
            <!-- Featured Image Thumbnail -->
            <?php if (has_post_thumbnail()) : ?>
                <div class="w-48 h-32 flex-shrink-0">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover rounded')); ?>
                    </a>
                </div>
            <?php endif; ?>
            
            <!-- Content -->
            <div class="flex-1 min-w-0">
                <header class="mb-3">
                    <h2 class="text-xl font-heading font-bold text-cyan-400 mb-2">
                        <a href="<?php the_permalink(); ?>" class="hover:text-cyan-300 transition-colors">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    
                    <div class="flex flex-wrap gap-3 text-xs text-slate-400">
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <?php echo get_the_date(); ?>
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <?php echo get_the_author(); ?>
                        </span>
                        <?php if (has_category()) : ?>
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </header>
                
                <div class="text-slate-400 text-sm mb-3">
                    <?php echo wp_trim_words(get_the_excerpt( ), 75); ?>
                </div>
                
                <a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-sm text-cyan-400 hover:text-cyan-300 transition-colors">
                    Read More
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            
        </div>
        
    <?php else : ?>
        <!-- Single Post View Layout -->
        
        <header class="entry-header mb-8">
            <?php the_title('<h1 class="entry-title text-4xl font-heading font-bold text-cyan-400 mb-4">', '</h1>'); ?>
            
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
                
            </div>
        </header>
        
        <?php if (has_post_thumbnail()) : ?>
            <div class="entry-thumbnail mb-8 rounded-lg overflow-hidden border border-slate-700">
                <?php 
                the_post_thumbnail('large', array('class' => 'w-full h-96 object-cover'));
                ?>
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