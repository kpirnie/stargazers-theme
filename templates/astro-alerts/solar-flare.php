<?php
/**
 * Solar Flare Alerts Template
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
foreach( $data -> posts as $flare ) {

    // setup the data to be displayed
    $title = esc_html( $flare -> post_title );
    $flare_data = ( array ) maybe_unserialize( $flare -> post_content );

    $fbegin = esc_html( date( 'r', strtotime( $flare_data['beginTime'] ) ) );
    $fend = esc_html( date( 'r', strtotime( $flare_data['endTime'] ) ) );
    $fpeak = esc_html( date( 'r', strtotime( $flare_data['peakTime'] ) ) );
    $fclass = esc_html( $flare_data['classType'] );
    $fsource = esc_html( $flare_data['sourceLocation'] );
    $fregion = esc_html( $flare_data['activeRegionNum'] );
    
    // build instruments
    $finstruments = [];
    $finstruments[] = '<ul class="list-disc list-inside pl-4">';
    foreach( $flare_data['instruments'] as $inst ) {
        $name = esc_html( $inst['displayName'] );
        $finstruments[] = "<li>$name</li>";
    }
    $finstruments[] = '</ul>';
    $finstruments = implode( '', $finstruments );

    $flink = esc_url( $flare_data['link'] );

    // unique ID for accordion
    $accordion_id = 'accordion-' . $flare -> ID;

    // create the card
    $out[] = <<<HTML
    <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
        <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
            <h3 class="text-xl mt-3 font-bold text-cyan-400">$title</h3>
        </div>
        <div class="p-6">
            <ul class="space-y-2 text-slate-300 mb-4">
                <li><strong class="text-slate-200">Begin:</strong> $fbegin</li>
                <li><strong class="text-slate-200">End:</strong> $fend</li>
                <li><strong class="text-slate-200">Peak:</strong> $fpeak</li>
                <li><strong class="text-slate-200">Class:</strong> $fclass</li>
                <li><strong class="text-slate-200">Source:</strong> $fsource</li>
                <li><strong class="text-slate-200">Region:</strong> $fregion</li>
            </ul>
            <div class="border border-slate-700 rounded-lg overflow-hidden">
                <button 
                    class="w-full px-4 py-3 bg-slate-900 text-cyan-400 font-semibold text-left flex justify-between items-center hover:bg-slate-800 transition-colors"
                    data-accordion-trigger="$accordion_id">
                    <span>Instruments</span>
                    <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="$accordion_id" class="hidden px-4 py-3 bg-slate-800 text-slate-300">
                    $finstruments
                </div>
            </div>
            <a class="inline-block mt-6 px-6 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition-colors float-right" href="$flink" target="_blank">More Info</a>
            <div class="clear-both"></div>
        </div>
    </div>
    HTML;

}

// end the output
$out[] = '</div>';

// if we're showing the paging links, and it's either bottom or both
if( $show_paging && in_array( $paging_location, ['bottom', 'both'] ) ) {
    $out[] = SGU_Static::cpt_pagination( $max_pages, $paged );
}

// return the output
echo implode( '', $out );