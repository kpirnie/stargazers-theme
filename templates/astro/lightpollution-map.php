<?php
/**
 * Light Pollution Map Template
 * 
 * @package Stargazers Theme
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

$map_id = 'sgu-lp-map-' . wp_unique_id();

$popup_content = '';
if ( $has_location && ! empty( $location_name ) ) {
    $popup_content = '<small>' . esc_js( $location_name );
    if ( ! empty( $location->state ) ) {
        $popup_content .= ' ' . esc_js( $location->state );
    }
    $popup_content .= '</small>';
} else {
    $popup_content = '<small>' . esc_js( round( $latitude, 4 ) ) . ', ' . esc_js( round( $longitude, 4 ) ) . '</small>';
}

wp_enqueue_style( 'leaflet' );
wp_enqueue_script( 'sgu-light-pollution-map' );
wp_enqueue_style( 'sgu-light-pollution-map' );

wp_add_inline_script( 'sgu-light-pollution-map', 'window.sguLightPollutionMaps = window.sguLightPollutionMaps || [];
window.sguLightPollutionMaps.push(' . wp_json_encode( [
    'mapId'        => $map_id,
    'lat'          => $latitude,
    'lng'          => $longitude,
    'popupContent' => $popup_content,
] ) . ');', 'before' );
?>

<div class="my-4 z-1" <?php echo $wrapper_attr; ?>>

    <?php if ( $show_title && ! empty( $title ) ) : ?>
        <h2 class="text-3xl font-heading font-bold text-cyan-400 mb-4 border-b-2 border-cyan-500 pb-2 mt-0"><?php echo esc_html( $title ); ?></h2>
    <?php endif; ?>

    <?php if ( $show_location_picker ) : ?>
        <?php 
        $theme_template = locate_template( [
            'templates/weather/partials/location-picker-inline.php',
            'sgu/weather/partials/location-picker-inline.php',
        ] );
        $partial = $theme_template ?: SGUP_PATH . '/templates/weather/partials/location-picker-inline.php';
        if ( file_exists( $partial ) ) {
            include $partial;
        }
        ?>
    <?php endif; ?>

    <div 
        id="<?php echo esc_attr( $map_id ); ?>" 
        class="rounded-lg overflow-hidden border border-slate-700"
        style="height:<?php echo esc_attr( $max_height ); ?>px;"
    ></div>

    <div class="mt-4">
        <div class="h-4 rounded-lg" style="background: linear-gradient(to right, #000000, #0b0b2a, #1a1a4a, #3d3d7a, #7a7a00, #ffaa00, #ffffff);"></div>
        <div class="flex justify-between text-xs text-slate-400 mt-1">
            <span>Dark</span>
            <span>Intense</span>
        </div>
    </div>

</div>