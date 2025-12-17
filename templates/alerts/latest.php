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

        // hold the post object - handle both array and single object
        $alert = is_array( $post_obj ) ? reset( $post_obj ) : $post_obj;
        
        // skip if no valid alert
        if( ! $alert || ! is_object( $alert ) ) {
            continue;
        }

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
            // geomagnetic alerts
            'sgu_geo_alerts' => ( function( ) use ( $content ) {
                $trimd_content = wp_trim_words( $content, 30 );
                $permalink = get_permalink( get_page_by_path( 'astronomy-information/latest-alerts/geomagnetic-storm-forecast' ) -> ID ?? 0 );
                return <<<HTML
                    <p class="text-slate-300 mb-4">$trimd_content</p>
                    <!--<img class="brightness-100 dark:brightness-50 object-contain md:object-cover rounded-md" />-->
                    <button data-src="//services.swpc.noaa.gov/images/animations/geospace/velocity/latest.png" class="inline-block px-6 py-2 bg-slate-600 hover:bg-slate-500 text-white rounded-lg transition-colors">Latest Image</button>
                    <a class="inline-block px-6 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition-colors" href="$permalink">Read More</a>
                HTML;
            } )( ),
            // solar flare alerts
            'sgu_sf_alerts' => ( function( ) use ( $data ) {
                $data_obj = is_object( $data ) ? $data : (object) $data;
                $bdate = esc_html( date( 'm/d/Y H:i:s', strtotime( $data_obj -> beginTime ?? '' ) ) );
                $edate = esc_html( date( 'm/d/Y H:i:s', strtotime( $data_obj -> endTime ?? '' ) ) );
                $cl = esc_html( $data_obj -> classType ?? '' );
                $permalink = get_permalink( get_page_by_path( 'astronomy-information/latest-alerts/solar-flare-alerts' ) -> ID ?? 0 );
                return <<<HTML
                <ul class="space-y-2 text-slate-300 mb-4">
                    <li><strong class="text-slate-200">Begins:</strong> $bdate</li>
                    <li><strong class="text-slate-200">Ends:</strong> $edate</li>
                    <li><strong class="text-slate-200">Class:</strong> $cl</li>
                </ul>
                <button data-src="//sdo.gsfc.nasa.gov/assets/img/latest/latest_1024_0171.jpg" class="inline-block px-6 py-2 bg-slate-600 hover:bg-slate-500 text-white rounded-lg transition-colors" href="">Latest Image</button>
                <a class="inline-block px-6 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition-colors" href="$permalink">Read More</a>
                HTML;
            } )( ),
            // coronal mass ejection alerts
            'sgu_cme_alerts' => ( function( ) use ( $data ) {
                $data_obj = is_object( $data ) ? $data : (object) $data;
                $sdate = esc_html( date( 'm/d/Y H:i:s', strtotime( $data_obj -> startTime ?? $data_obj -> start ?? '' ) ) );
                $catalog = esc_html( $data_obj -> catalog ?? '' );
                $source = esc_html( $data_obj -> sourceLocation ?: 'Not Defined' );
                $permalink = get_permalink( get_page_by_path( 'astronomy-information/latest-alerts/coronal-mass-ejection-alerts' ) -> ID ?? 0 );
                return <<<HTML
                    <ul class="space-y-2 text-slate-300 mb-4">
                        <li><strong class="text-slate-200">Start:</strong> $sdate</li>
                        <li><strong class="text-slate-200">Catalog:</strong> $catalog</li>
                        <li><strong class="text-slate-200">Source:</strong> $source</li>
                    </ul>
                    <button data-src="//services.swpc.noaa.gov/experimental/images/animations/lasco-c2/latest.jpg" class="inline-block px-6 py-2 bg-slate-600 hover:bg-slate-500 text-white rounded-lg transition-colors" href="">Latest Image</button>
                    <a class="inline-block px-6 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition-colors" href="$permalink">Read More</a>
                HTML;
            } )( ),
            // space weather alerts
            'sgu_sw_alerts' => ( function( ) use ( $data ) {
                $data_obj = is_object( $data ) ? $data : (object) $data;
                $message = wp_trim_words( $data_obj -> message ?? '', 30 );
                $permalink = get_permalink( get_page_by_path( 'astronomy-information/latest-alerts/space-weather-alerts' ) -> ID ?? 0 );
                return <<<HTML
                <p class="text-slate-300 mb-4">$message</p>
                <button data-src="//services.swpc.noaa.gov/images/swx-overview-large.gif" class="inline-block px-6 py-2 bg-slate-600 hover:bg-slate-500 text-white rounded-lg transition-colors" href="">Latest Image</button>
                <a class="inline-block px-6 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-lg transition-colors" href="$permalink">Read More</a>
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
