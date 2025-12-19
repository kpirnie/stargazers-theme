<?php
/**
 * Single APOD Template
 * 
 * @package US Stargazers Plugin
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

get_header();

$title = esc_html( $post->post_title );
$content = apply_filters( 'the_content', $post->post_content );
$date = get_the_date( 'F j, Y', $post );
$post_meta = ( object ) ( get_post_meta( $post->ID ) ?: [] );
$copyright = $post_meta -> sgu_apod_copyright[0] ?: 'NASA/JPL';
$media_type = $post_meta -> sgu_apod_local_media_type[0];
$local_media = $post_meta -> sgu_apod_local_media[0];
$remote_media = $post_meta -> sgu_apod_original_media[0];

$media_html = '';
if( $media_type == 'image' ) {
    $img = '';
    if( $local_media ) {
        $img_id = SGU_Static::get_attachment_id( $local_media );
        $img = esc_url( wp_get_attachment_image_url( $img_id, 'large' ) );
    } else {
        $img = $remote_media;
    }
    $media_html = '<div class="relative">
        <img src="' . $img . '" alt="' . $title . '" class="w-full h-96 object-cover">
        <button data-src="' . $img . '" class="absolute bottom-8 right-8 p-2 bg-slate-900/80 text-cyan-400 hover:bg-cyan-600 hover:text-white transition-colors border border-slate-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
            </svg>
        </button>
    </div>';
} else {
    $media_html = '<iframe src="' . esc_url( $remote_media ) . '" class="w-full h-96 aspect-video" frameborder="0" allowfullscreen></iframe>';
}

?>

<main id="primary" class="site-main">
    
    <header class="bg-slate-900 border-b border-slate-800">
        <div class="container mx-auto px-4 py-6">
            <h2 class="text-3xl md:text-4xl font-heading font-bold text-cyan-400"><?php echo $title; ?></h2>
        </div>
    </header>
    

    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Main Content -->
            <div class="md:col-span-2">
                
                <article class="bg-slate-800 border border-slate-700 overflow-hidden">
                    <div class="p-4">
                        <?php echo $media_html; ?>
                        <div class="text-sm text-right text-slate-500 mt-4"><?php echo $date; ?> | <?php echo esc_html( $copyright ); ?></div>
                    </div>
                    <div class="p-6 border-t border-slate-700">
                        <div class="prose prose-invert prose-slate max-w-none">
                            <?php echo $content; ?>
                        </div>
                        
                    </div>
                </article>

                <div class="mt-6">
                    <?php 
                        get_template_part( 'template-parts/navigation/single', 'pagination' );
                    ?>
                </div>
                
            </div>

            <!-- Sidebar -->
            <div class="md:col-span-1">
                <?php 
                    get_template_part( 'template-parts/cpt-sidebar' );
                ?>
            </div>

        </div>
    </div>

</main>

<?php get_footer(); ?>