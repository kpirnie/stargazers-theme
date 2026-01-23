<?php
/**
 * Star Chart Template
 * 
 * @package Stargazers Theme
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

$iframe_params = [
    'projection' => $projection ?? 'stereo',
    'latitude' => $latitude,
    'longitude' => $longitude,
    'az' => absint( $az ?? 180 ),
    'gradient' => filter_var( $gradient ?? true, FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
    'constellations' => filter_var( $show_constellations ?? true, FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
    'constellationlabels' => filter_var( $show_constellation_labels ?? true, FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
    'showplanets' => filter_var( $show_planets ?? true, FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
    'showplanetlabels' => filter_var( $show_planet_labels ?? true, FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
    'showstars' => filter_var( $show_stars ?? true, FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
    'showstarlabels' => filter_var( $show_star_labels ?? false, FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
    'showorbits' => filter_var( $show_orbits ?? false, FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
    'showgalaxy' => filter_var( $show_galaxy ?? true, FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
    'showground' => filter_var( $ground ?? true, FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
    'showdate' => 'true',
    'showposition' => 'true',
    'mouse' => filter_var( $mouse ?? true, FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
    'keyboard' => filter_var( $keyboard ?? true, FILTER_VALIDATE_BOOLEAN ) ? 'true' : 'false',
];

switch($style ?? 'default') {
    case 'inverted':
        $iframe_params['negative'] = 'true';
        break;
    case 'navy':
        $iframe_params['color'] = '#000033';
        break;
    case 'red':
        $iframe_params['color'] = '#330000';
        break;
}

$base_url = 'https://virtualsky.lco.global/embed/index.html';
$iframe_url = add_query_arg( $iframe_params, $base_url );

$height = 400 + ($zoom * 50);
?>

<div class="my-4" <?php echo $wrapper_attr; ?>>

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

    <div class="bg-slate-800 rounded border border-slate-700 overflow-hidden">
        <iframe 
            src="<?php echo esc_url( $iframe_url ); ?>" 
            style="width: 100%; height: <?php echo esc_attr($height); ?>px; border: none;"
            title="<?php echo esc_attr( $title ); ?>"
            loading="lazy"
        ></iframe>
        
        <div class="bg-slate-900 px-6 py-3 border-t border-slate-700">
            <p class="text-sm text-slate-400">
                Location: <span class="text-slate-300"><?php echo esc_html($location_name); ?></span>
                <span class="text-slate-500">(<?php echo number_format($latitude, 2); ?>, <?php echo number_format($longitude, 2); ?>)</span>
            </p>
            <p class="text-xs text-slate-500 mt-1">
                <em>Click and drag to explore • Use mouse wheel to zoom • Arrow keys to navigate</em>
            </p>
        </div>
    </div>

</div>