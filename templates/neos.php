<?php
/**
 * Near Earth Object Archive Template
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// hold the output
$out = [];

// if we're showing the paging links, and it's either top or both
if( $show_paging && in_array( $paging_location, ['top', 'both'] ) ) {
    $out[] = SGU_Static::cpt_pagination( $max_pages, $paged );
}

// open the display grid
$out[] = '<div class="grid grid-cols-1 md:grid-cols-3 gap-6">';

// loop the data
foreach( $data -> posts as $neo ) {

    // setup the data needed
    $content = ( object ) maybe_unserialize( $neo -> post_content );
    $title = esc_html( $neo -> post_title );
    $date = esc_html( date( 'Y-m-d', strtotime( $neo -> post_date ) ) );

    $magnitude = esc_html( $content -> absolute_magnitude_h );
    $mindia = number_format( $content -> estimated_diameter['kilometers']['estimated_diameter_min'], 4 );
    $maxdia = number_format( $content -> estimated_diameter['kilometers']['estimated_diameter_max'], 4 );

    $hazardous = filter_var( $content -> is_potentially_hazardous_asteroid, FILTER_VALIDATE_BOOLEAN );
    $hazard_text = $hazardous ? 'Yes' : 'No';
    $hazard_class = $hazardous ? 'text-red-400' : 'text-green-400';

    $approach_date = esc_html( $content -> close_approach_data[0]['close_approach_date_full'] );

    $approach_distance = number_format( $content -> close_approach_data[0]['miss_distance']['kilometers'], 4 );

    $approach_velocity = number_format( $content -> close_approach_data[0]['relative_velocity']['kilometers_per_second'], 4 );

    $approach_orbiting = esc_html( $content -> close_approach_data[0]['orbiting_body'] );
    $link = esc_url( $content -> nasa_jpl_url );

    // render the card
    $out[] = <<<HTML
    <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
        <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
            <h3 class="text-lg font-heading font-bold text-cyan-400 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {$title}
                <span class="text-sm text-slate-500 font-normal ml-auto">{$date}</span>
            </h3>
        </div>
        <div class="p-6">
            <ul class="space-y-3 text-sm">
                <li class="flex justify-between">
                    <span class="text-slate-400">Magnitude:</span>
                    <span class="text-slate-200 font-medium">{$magnitude}</span>
                </li>
                <li>
                    <span class="text-slate-400">Diameter:</span>
                    <ul class="mt-1 ml-4 space-y-1">
                        <li class="flex justify-between">
                            <span class="text-slate-500">Min:</span>
                            <span class="text-slate-300">{$mindia} km</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-slate-500">Max:</span>
                            <span class="text-slate-300">{$maxdia} km</span>
                        </li>
                    </ul>
                </li>
                <li class="flex justify-between">
                    <span class="text-slate-400">Hazardous:</span>
                    <span class="{$hazard_class} font-medium">{$hazard_text}</span>
                </li>
                <li>
                    <span class="text-slate-400">Approach Data:</span>
                    <ul class="mt-1 ml-4 space-y-1">
                        <li class="flex justify-between">
                            <span class="text-slate-500">Closest At:</span>
                            <span class="text-slate-300">{$approach_date}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-slate-500">Distance:</span>
                            <span class="text-slate-300">{$approach_distance} km</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-slate-500">Velocity:</span>
                            <span class="text-slate-300">{$approach_velocity} km/s</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-slate-500">Orbiting:</span>
                            <span class="text-slate-300">{$approach_orbiting}</span>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="mt-6">
                <a href="{$link}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-700 text-slate-200 rounded-lg hover:bg-cyan-600 hover:text-white transition-colors text-sm" target="_blank" rel="noopener noreferrer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    More Info
                </a>
            </div>
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

// if we're going to show the nasa map
if( $show_map ) {
    $out[] = <<<HTML
    <div class="hidden md:block mt-8">
        <h2 class="text-2xl font-heading font-bold text-cyan-400 mb-4 border-b-2 border-cyan-500 pb-2">NASA Eyes on Asteroids</h2>
        <p class="text-slate-400 mb-4">Fully interactive real-time map of all asteroids and NEO's in our Solar System.</p>
        <div class="rounded-lg overflow-hidden border border-slate-700">
            <iframe src="https://eyes.nasa.gov/apps/asteroids/#/asteroids" class="w-full" style="min-height:750px;"></iframe>
        </div>
    </div>
    HTML;
}

// return the output
echo implode( '', $out );
