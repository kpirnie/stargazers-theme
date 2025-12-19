<?php
/**
 * CPT Sidebar
 * 
 * @package US Stargazers Plugin
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>

<div class="sticky top-[10rem] space-y-6">
    
    <div class="bg-slate-800 border border-slate-700 p-4">
        <h3 class="text-lg font-heading font-bold text-cyan-400 mb-4 pb-2 border-b border-slate-700">Search</h3>
        <form action="<?php echo esc_url( get_post_type_archive_link( 'sgu_apod' ) ); ?>" method="get">
            <input type="hidden" name="post_type" value="sgu_apod">
            <div class="flex gap-2">
                <input type="search" name="s" placeholder="Search..." class="flex-1 px-3 py-2 bg-slate-900 border border-slate-700 text-slate-200 text-sm">
                <button type="submit" class="px-3 py-2 bg-cyan-600 text-white hover:bg-cyan-500 transition-colors" title="Search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'sgu_apod' ) ); ?>" class="px-3 py-2 bg-slate-700 text-slate-200 hover:bg-slate-600 transition-colors" title="Reset">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>
        </form>
    </div>

    <div class="bg-slate-800 border border-slate-700 p-4">
        <h3 class="text-lg font-heading font-bold text-cyan-400 mb-4 pb-2 border-b border-slate-700">Browse by Year</h3>
        <?php
        global $wpdb;
        $years = $wpdb->get_col("
            SELECT DISTINCT YEAR(post_date) as year 
            FROM {$wpdb->posts} 
            WHERE post_type = 'sgu_apod' AND post_status = 'publish' 
            ORDER BY year DESC
        ");
        ?>
        <div class="flex flex-wrap gap-2">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'sgu_apod' ) ); ?>" class="px-2 py-1 bg-slate-900 border border-slate-700 text-slate-300 text-sm hover:bg-cyan-600 hover:text-white">RESET</a>
            <?php foreach( $years as $y ) : ?>
            <a href="<?php echo esc_url( add_query_arg( 'apod_year', $y, get_post_type_archive_link( 'sgu_apod' ) ) ); ?>" class="px-2 py-1 bg-slate-900 border border-slate-700 text-slate-300 text-sm hover:bg-cyan-600 hover:text-white"><?php echo $y; ?></a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="bg-slate-800 border border-slate-700 p-4">
        <h3 class="text-lg font-heading font-bold text-cyan-400 mb-4 pb-2 border-b border-slate-700">About APOD</h3>
        <p class="text-slate-400 text-sm">NASA's Astronomy Picture of the Day features a different image of our universe each day since June 1995.</p>
        <a href="https://apod.nasa.gov/" target="_blank" class="inline-block mt-3 text-cyan-400 text-sm hover:text-cyan-300">Visit NASA APOD &rarr;</a>
    </div>

</div>
