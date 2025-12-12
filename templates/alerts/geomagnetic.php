<?php
/**
 * GeoMagnetic Alerts Template
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// open the output
$out = [];

// if we're showing the paging links, and it's either top or both
if( $show_paging && in_array( $paging_location, ['top', 'both'] ) ) {
    $out[] = SGU_Static::cpt_pagination( $max_pages, $paged );
}

$out[] = '<div class="grid grid-cols-1 md:grid-cols-2 gap-6">';

// loop the results
foreach( $data -> posts as $geomag ) {

    // setup the data to return
    $title = esc_html( $geomag -> post_title );
    $date = esc_html( date( 'F j, Y g:i A', strtotime( $geomag -> post_date ) ) );
    $content = esc_html( maybe_unserialize( $geomag -> post_content ) );

    // return the content
    $out[] = <<<HTML
    <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
        <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
            <h3 class="text-xl font-heading font-bold text-cyan-400">$title</h3>
            <p class="text-sm text-slate-400 mt-1">$date</p>
        </div>
        <div class="p-6">
            <pre class="text-slate-300 whitespace-pre-wrap font-mono text-sm overflow-x-auto">$content</pre>
        </div>
    </div>
    HTML;

}

$out[] = '</div>';

// if we're showing the paging links, and it's either bottom or both
if( $show_paging && in_array( $paging_location, ['bottom', 'both'] ) ) {
    $out[] = SGU_Static::cpt_pagination( $max_pages, $paged );
}

// return the output
echo implode( '', $out );