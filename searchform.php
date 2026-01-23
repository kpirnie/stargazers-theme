<?php
/**
 * Custom search form template
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="flex-grow">
        <span class="screen-reader-text"><?php _e('Search for:', 'stargazers'); ?></span>
        <input type="search" 
               class="search-field rounded" 
               placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'stargazers'); ?>" 
               value="<?php echo get_search_query(); ?>" 
               name="s" />
    </label>
    <button type="submit" class="px-3 rounded py-2 bg-cyan-600 text-white hover:bg-cyan-500 transition-colors" title="Search">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </button>
    <a href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>" class="px-3 rounded py-2 bg-slate-700 text-slate-200 hover:bg-slate-600 transition-colors" title="Reset">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </a>
</form>
