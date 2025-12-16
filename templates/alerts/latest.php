<?php
/**
 * Latest Alerts Template
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// hold the output
$out = [];

// begin the html output
$out[] = <<<HTML
<h2 class="text-3xl font-heading font-bold text-cyan-400 mb-6 border-b-2 border-cyan-500 pb-2">$title</h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
HTML;

// make sure we actually have alerts to display
if( $latest_alerts ) {

    // loop them
    foreach( $latest_alerts as $cpt => $post_obj ) {

        // make sure we have a post object
        if( ! $post_obj ) {
            continue;
        }

        // hold the post object
        $alert = reset( $post_obj );

        // grab all our variables necessary for display
        $section_title = esc_html( SGU_Static::get_cpt_display_name( $cpt ) );
        $alert_title = esc_html( $alert -> post_title );

        // open the card
        $out[] = <<<HTML
        <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
            <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                <h3 class="text-xl mt-3 font-bold text-cyan-400">$section_title</h3>
            </div>
            <div class="p-6">
                <h4 class="text-lg font-semibold text-slate-200 mb-4">$alert_title</h4>
        HTML;

        $content = $alert -> post_content;
        $data = maybe_unserialize( $content );

        $out[] = match( $cpt ) {
            'sgu_geo_alerts' => ( function( ) use ( $content ) {
                $trimd_content = wp_trim_words( $content, 30 );
                return <<<HTML
                    <p class="text-slate-300 mb-4">$trimd_content</p>
                    <a class="inline-block px-6 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition-colors" href="/astronomy-information/latest-alerts/geomagnetic-storm-forecast/">Read More</a>
                HTML;
            } )( ),

            'sgu_sf_alerts' => ( function( ) use ( $data ) {
                $bdate = esc_html( date( 'm/d/Y H:i:s', strtotime( $data -> begin ) ) );
                $edate = esc_html( date( 'm/d/Y H:i:s', strtotime( $data -> end ) ) );
                $cl = esc_html( $data -> class );
                return <<<HTML
                <ul class="space-y-2 text-slate-300 mb-4">
                    <li><strong class="text-slate-200">Begins:</strong> $bdate</li>
                    <li><strong class="text-slate-200">Ends:</strong> $edate</li>
                    <li><strong class="text-slate-200">Class:</strong> $cl</li>
                </ul>
                <a class="inline-block px-6 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition-colors" href="/astronomy-information/latest-alerts/solar-flare-alerts/">Read More</a>
                HTML;
            } )( ),

            'sgu_cme_alerts' => ( function( ) use ( $data ) {
                $sdate = esc_html( date( 'm/d/Y H:i:s', strtotime( $data -> start ) ) );
                $catalog = esc_html( $data -> catalog );
                $source = esc_html( $data -> source );
                return <<<HTML
                    <ul class="space-y-2 text-slate-300 mb-4">
                        <li><strong class="text-slate-200">Start:</strong> $sdate</li>
                        <li><strong class="text-slate-200">Catalog:</strong> $catalog</li>
                        <li><strong class="text-slate-200">Source:</strong> $source</li>
                    </ul>
                    <a class="inline-block px-6 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition-colors" href="/astronomy-information/latest-alerts/coronal-mass-ejection-alerts/">Read More</a>
                HTML;
            } )( ),

            'sgu_sw_alerts' => ( function( ) use ( $data ) {
                $message = wp_trim_words( $data -> message, 30 );
                return <<<HTML
                <p class="text-slate-300 mb-4">$message</p>
                <a class="inline-block px-6 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition-colors" href="/astronomy-information/latest-alerts/space-weather-alerts/">Read More</a>
                HTML;
            } )( ),

            default => '',
        };

        // close up the card
        $out[] = <<<HTML
            </div>
        </div>
        HTML;

    }

}

// end the html output
$out[] = <<<HTML
</div>
HTML;

// return the output
echo implode( '', $out );
