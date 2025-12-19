<?php
/**
 * Template part for displaying pagination
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>

<div class="flex justify-between items-center">
    <?php
    $prev = get_previous_post();
    $next = get_next_post();
    ?>
    <div>
        <?php if( $prev ) : ?>
        <a href="<?php echo get_permalink( $prev ); ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-700 text-slate-200 hover:bg-cyan-600 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            <?php echo esc_html( wp_trim_words( $prev->post_title, 5 ) ); ?>
        </a>
        <?php endif; ?>
    </div>
    <div>
        <?php if( $next ) : ?>
        <a href="<?php echo get_permalink( $next ); ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-700 text-slate-200 hover:bg-cyan-600 hover:text-white transition-colors">
            <?php echo esc_html( wp_trim_words( $next->post_title, 5 ) ); ?>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        <?php endif; ?>
    </div>
</div>