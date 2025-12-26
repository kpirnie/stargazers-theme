<?php
/**
 * Archive APOD Template
 * 
 * @package US Stargazers Plugin
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

get_header( );

// get the year filter
$year_filter = isset( $_GET['apod_year'] ) ? ['year' => intval( $_GET['apod_year'] )] : [];
$search = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';

$space_data = new SGU_Space_Data_Get( );
$paged = SGU_Static::safe_get_paged_var( ) ?: 1;
$apods = $space_data -> get_apods( $paged, 10, $year_filter, $search );

if( ! $apods || empty( $apods->posts ) ) {
    echo '<div class="container mx-auto px-4 py-12"><p class="text-slate-400">No astronomy photos found.</p></div>';
    get_footer( );
    return;
}

$max_pages = $apods->max_num_pages ?: 1;

?>

<main id="primary" class="site-main">
    
    <header class="bg-slate-900 border-b border-slate-800">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-4xl font-heading font-bold text-cyan-400">
                Astronomy Photo of the Day
                    <?php if( $year_filter ) : ?>
                    <span class="text-slate-500 text-2xl ml-2">(<?php echo $year_filter['year']; ?>)</span>
                    <?php endif; ?>
                    <?php if( $search ) : ?>
                    <span class="text-slate-500 text-2xl ml-2">: "<?php echo esc_html( $search ); ?>"</span>
                    <?php endif; ?>
            </h1>
        </div>
    </header>

    <?php echo SGU_Static::cpt_pagination( $max_pages, $paged ); ?>

    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Main Content -->
            <div class="md:col-span-2">
                                
                <div class="space-y-6">
                    <?php foreach( $apods->posts as $apod ) :
                        $id = $apod->ID;
                        $title = esc_html( $apod->post_title );
                        $excerpt = wp_trim_words( $apod->post_content, 50 );
                        $date = get_the_date( 'F j, Y', $apod );
                        $link = esc_url( get_permalink( $id ) );
                        $post_meta = ( object ) ( get_post_meta( $id ) ?: [] );
                        
                        $media = ( function() use( $id, $post_meta ) {
                            $_local = $post_meta -> sgu_apod_local_media[0];
                            $_type = $post_meta -> sgu_apod_local_media_type[0];
                            if( $_type == 'image' && $_local ) {
                                $_img_id = SGU_Static::get_attachment_id( $_local );
                                return wp_get_attachment_image_url( $_img_id, 'thumbnail' ) ?: $_local;
                            }
                            return $post_meta -> sgu_apod_original_media[0];
                        })();
                    ?>
                    <article class="bg-slate-800 border border-slate-700 p-4 flex gap-4">
                        <div class="w-24 h-24 flex-shrink-0">
                            <?php if( $media ) : ?>
                            <a href="<?php echo $link; ?>">
                                <img src="<?php echo esc_url( $media ); ?>" alt="<?php echo $title; ?>" class="w-full h-full object-cover">
                            </a>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h2 class="text-lg font-heading font-bold text-cyan-400 mb-1">
                                <a href="<?php echo $link; ?>" class="hover:text-cyan-300">
                                    <?php echo $title; ?>
                                </a>
                            </h2>
                            <p class="text-slate-400 text-sm"><?php echo $excerpt; ?></p>
                            <p class="text-xs text-right text-slate-500 mt-2"><?php echo $date; ?></p>
                            <a href="<?php the_permalink($id); ?>" class="inline-flex items-center gap-2 text-sm text-cyan-400 hover:text-cyan-300 transition-colors">
                                Read More
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </article>
                    <?php endforeach; ?>
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

    <?php echo SGU_Static::cpt_pagination( $max_pages, $paged ); ?>

</main>

<?php get_footer(); ?>