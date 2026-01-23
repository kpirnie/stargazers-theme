<?php
/** 
 * Astronomy Photo of the Day 
 * Shortcode Template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package US Stargazers Plugin
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>
<h2 class="text-3xl font-heading font-bold text-cyan-400 mb-6 border-b-2 border-cyan-500 pb-2">
    NASA's Astronomy Photo of the Day
</h2>
<div class="relative h-96 rounded overflow-hidden">
    <?php if( $meta['sgu_apod_local_media_type'][0] == 'image' ) : ?>
        <img src="<?php echo esc_url( $meta['sgu_apod_local_media'][0] ); ?>" class="absolute inset-0 w-full h-full object-cover parallax" data-parallax-speed="0.2" alt="<?php echo esc_attr( $title ); ?>" />
    <?php else: ?>
        <?php echo SGU_Static::render_video_media( $meta['sgu_apod_orignal_media'][0], $title, 'absolute inset-0 w-full h-96 mt-0 object-cover', false ); ?>
    <?php endif; ?>
    <div class="absolute inset-0 bg-gradient-to-r from-transparent to-slate-900/70"></div>
    <div class="absolute inset-0 flex items-center justify-end p-8">
        <div class="w-full md:w-1/2 bg-slate-950/60 backdrop-blur-sm rounded p-6 border border-slate-700">
            <h3 class="text-2xl font-heading font-bold text-slate-200 mb-4">
                <?php echo $title; ?>
            </h3>
            <p class="text-slate-300 mb-4">
                <?php _e( ( wp_trim_words( $content, 15 ) ) ?? '' ); ?>
            </p>
            <p class="text-sm text-slate-400 mb-6">
                Copyright &copy; <?php echo $meta['sgu_apod_copyright'][0]; ?>
            </p>
            <a href="<?php echo get_post_type_archive_link( 'sgu_apod' ); ?>" title="NASA Astronomy Photo of the Day Archive" class="text-sm inline-block px-4 py-2 mx-1 float-right bg-slate-600 hover:bg-slate-500 text-white rounded transition-colors">
                VIEW ALL
            </a>
            <a href="<?php echo esc_url( get_permalink( $id ) ); ?>" title="<?php _e( $title, 'sgup' ); ?>" class="text-sm inline-block px-4 py-2 float-right mx-1 bg-cyan-600 hover:bg-cyan-500 text-white rounded transition-colors">
                VIEW POST
            </a>
        </div>
    </div>
</div>
