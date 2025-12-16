<?php
/**
 * CME Alerts Template
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
foreach( $data -> posts as $cme ) {

    // setup all the data we'll need for display
    $cme_data = maybe_unserialize( $cme -> post_content );
    $title = esc_html( $cme -> post_title );
    $catalog = esc_html( $cme_data -> catalog );
    $start = esc_html( date( 'r', strtotime( $cme_data -> start ) ) );
    $source = esc_html( $cme_data -> source );
    $region = esc_html( $cme_data -> region );
    $note = esc_html( $cme_data -> note );
    
    // build instruments
    $instruments = [];
    $instruments[] = '<ul class="list-disc list-inside pl-4">';
    foreach( $cme_data -> instruments as $inst ) {
        $name = esc_html( $inst['displayName'] );
        $instruments[] = "<li>$name</li>";
    }
    $instruments[] = '</ul>';
    $instruments = implode( '', $instruments );

    // build analysis
    $lat = number_format( $cme_data -> analyses[0]['latitude'], 4 );
    $lon = number_format( $cme_data -> analyses[0]['longitude'], 4 );
    $half_width = number_format( $cme_data -> analyses[0]['halfAngle'], 4 );
    $speed = number_format( $cme_data -> analyses[0]['speed'], 4 );
    $type = esc_html( $cme_data -> analyses[0]['type'] );
    $a_note = esc_html( $cme_data -> analyses[0]['note'] );
    
    $analysis = <<<HTML
    <ul class="space-y-1">
        <li><strong class="text-slate-200">Latitude:</strong> $lat</li>
        <li><strong class="text-slate-200">Longitude:</strong> $lon</li>
        <li><strong class="text-slate-200">Half Width:</strong> $half_width</li>
        <li><strong class="text-slate-200">Speed:</strong> $speed</li>
        <li><strong class="text-slate-200">Type:</strong> $type</li>
        <li><strong class="text-slate-200">Note:</strong> $a_note</li>
    </ul>
    HTML;

    $link = esc_url( $cme_data -> link );

    // unique IDs for accordions
    $instruments_id = 'instruments-' . $cme -> ID;
    $analysis_id = 'analysis-' . $cme -> ID;

    // create the card
    $out[] = <<<HTML
    <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
        <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
            <h3 class="text-xl mt-3 font-bold text-cyan-400">$title</h3>
        </div>
        <div class="p-6">
            <ul class="space-y-2 text-slate-300 mb-4">
                <li><strong class="text-slate-200">Catalog:</strong> $catalog</li>
                <li><strong class="text-slate-200">Start:</strong> $start</li>
                <li><strong class="text-slate-200">Source:</strong> $source</li>
                <li><strong class="text-slate-200">Region:</strong> $region</li>
                <li><strong class="text-slate-200">Note:</strong> $note</li>
            </ul>
            
            <div class="space-y-2">
                <div class="border border-slate-700 rounded-lg overflow-hidden">
                    <button 
                        class="w-full px-4 py-3 bg-slate-900 text-cyan-400 font-semibold text-left flex justify-between items-center hover:bg-slate-800 transition-colors"
                        data-accordion-trigger="$instruments_id"
                    >
                        <span>Instruments</span>
                        <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="$instruments_id" class="hidden px-4 py-3 bg-slate-800 text-slate-300">
                        $instruments
                    </div>
                </div>
                
                <div class="border border-slate-700 rounded-lg overflow-hidden">
                    <button 
                        class="w-full px-4 py-3 bg-slate-900 text-cyan-400 font-semibold text-left flex justify-between items-center hover:bg-slate-800 transition-colors"
                        data-accordion-trigger="$analysis_id"
                    >
                        <span>Analysis</span>
                        <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="$analysis_id" class="hidden px-4 py-3 bg-slate-800 text-slate-300">
                        $analysis
                    </div>
                </div>
            </div>
            
            <a class="inline-block mt-6 px-6 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition-colors float-right" href="$link" target="_blank">More Info</a>
            <div class="clear-both"></div>
        </div>
    </div>
    HTML;

}

// close the output
$out[] = '</div>';

// if we're showing the paging links, and it's either bottom or both
if( $show_paging && in_array( $paging_location, ['bottom', 'both'] ) ) {
    $out[] = SGU_Static::cpt_pagination( $max_pages, $paged );
}

// return the output
echo implode( '', $out );
