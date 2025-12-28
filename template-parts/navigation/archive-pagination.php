<?php
/**
 * Template part for displaying pagination
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

global $wp_query;

$total_pages = $wp_query->max_num_pages;

if ( $total_pages <= 1 ) {
    return;
}

$current_page = max( 1, get_query_var( 'paged' ) );

$pagination = paginate_links( array(
    'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
    'format'    => '?paged=%#%',
    'current'   => $current_page,
    'total'     => $total_pages,
    'mid_size'  => 2,
    'end_size'  => 1,
    'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>',
    'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
    'type'      => 'array',
) );

if ( $pagination ) :
?>
    <nav class="pagination container mx-auto px-4 py-8" role="navigation" aria-label="Pagination">
        <div class="nav-links flex flex-wrap justify-center items-center gap-2">
            
            <?php if ( $current_page > 1 ) : ?>
                <a href="<?php echo esc_url( get_pagenum_link( 1 ) ); ?>" class="px-4 py-2 bg-slate-800 text-slate-200 rounded-lg hover:bg-cyan-600 hover:text-white transition-colors border border-slate-700" title="First Page">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                    </svg>
                </a>
            <?php endif; ?>

            <?php foreach ( $pagination as $page ) :
                if ( strpos( $page, 'current' ) !== false ) {
                    $page = preg_replace(
                        '/class=["\']([^"\']*page-numbers[^"\']*)["\']/',
                        'class="px-4 py-2 bg-cyan-600 text-white rounded-lg border border-cyan-500"',
                        $page
                    );
                } else {
                    $page = preg_replace(
                        '/class=["\']([^"\']*page-numbers[^"\']*)["\']/',
                        'class="px-4 py-2 bg-slate-800 text-slate-200 rounded-lg hover:bg-cyan-600 hover:text-white transition-colors border border-slate-700"',
                        $page
                    );
                }
                echo $page;
            endforeach; ?>

            <?php if ( $current_page < $total_pages ) : ?>
                <a href="<?php echo esc_url( get_pagenum_link( $total_pages ) ); ?>" class="px-4 py-2 bg-slate-800 text-slate-200 rounded-lg hover:bg-cyan-600 hover:text-white transition-colors border border-slate-700" title="Last Page">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                    </svg>
                </a>
            <?php endif; ?>

        </div>
    </nav>
<?php
endif;