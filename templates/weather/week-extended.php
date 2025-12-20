<?php
/**
 * Weekly Weather Extended Forecast Template
 * 
 * Displays 7-day forecast with NOAA detailed predictions
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

if( ! $noaa_forecast ) {
    $noaa_forecast = $weather;
}
?>
<div class="sgu-weather-container sgu-weather-weekly-extended-container" data-weather-type="weekly">
    
    <?php include locate_template( ['templates/weather/header.php'] ); ?>

    <!-- Weather Content -->
    <div class="sgu-weather-content">
        
        <?php if( ! $has_location ) : ?>
            <div class="sgu-weather-no-location bg-cyan-900/50 border border-cyan-700 rounded-lg p-4 text-cyan-200">
                <p>Please set your location to view the 7-day forecast.</p>
            </div>
        <?php else : ?>

            <!-- NOAA Extended Forecast -->
            <?php if( $noaa_forecast && ! empty( $noaa_forecast -> periods ) ) : ?>
                <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
                    <?php if( $show_title && ! $is_dash ) { ?>
                    <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                        <h3 class="text-xl mt-3 font-bold text-cyan-400 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <?php echo esc_html( ( ! $is_dash ) ? $title : 'Extended Forecast' ); ?>
                        </h3>
                    </div>
                    <?php } ?>
                    <div class="p-4 overflow-x-auto">
                        <?php 
                        // Separate periods into day (even index) and night (odd index)
                        $day_periods = [];
                        $night_periods = [];
                        foreach( $noaa_forecast -> periods as $idx => $period ) {
                            if( $idx % 2 === 0 ) {
                                $day_periods[] = $period;
                            } else {
                                $night_periods[] = $period;
                            }
                        }
                        ?>
                        
                        <!-- Day Row -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-3 mb-3">
                            <?php foreach( $day_periods as $period ) : ?>
                                <div class="bg-slate-900 rounded-lg p-4 text-center flex flex-col">
                                    
                                    <!-- Period Name -->
                                    <div class="font-medium text-slate-200 text-sm mb-2">
                                        <?php echo esc_html( $period['name'] ); ?>
                                    </div>
                                    
                                    <!-- Icon -->
                                    <?php if( ! empty( $period['icon'] ) ) : ?>
                                    <img src="<?php echo esc_url( $period['icon'] ); ?>" 
                                        alt=""
                                        class="w-16 h-16 rounded bg-slate-800 mx-auto my-2">
                                    <?php endif; ?>
                                    
                                    <!-- Temperature -->
                                    <div class="text-cyan-400 font-bold text-2xl my-2">
                                        <?php echo esc_html( $period['temperature'] ); ?>°<?php echo esc_html( $period['temperatureUnit'] ); ?>
                                    </div>
                                    
                                    <!-- Short Forecast -->
                                    <div class="text-slate-400 text-xs mb-2 flex-grow">
                                        <?php echo esc_html( $period['shortForecast'] ); ?>
                                    </div>
                                    
                                    <!-- Wind -->
                                    <?php if( ! empty( $period['windSpeed'] ) || ! empty( $period['windDirection'] ) ) : 
                                        $wind_degrees = SGU_Static::compass_to_degrees( $period['windDirection'] ?? 'N' );
                                    ?>
                                    <div class="text-xs text-slate-500 flex items-center justify-center gap-1 mt-auto pt-2 border-t border-slate-700">
                                        <svg class="w-4 h-4 text-cyan-500" style="transform: rotate(<?php echo esc_attr( $wind_degrees ); ?>deg);" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2L6 12h4v10h4V12h4L12 2z"/>
                                        </svg>
                                        <?php echo esc_html( $period['windSpeed'] ?? '' ); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Night Row -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-3">
                            <?php foreach( $night_periods as $period ) : ?>
                                <div class="bg-slate-950 rounded-lg p-4 text-center flex flex-col border border-slate-800">
                                    
                                    <!-- Period Name -->
                                    <div class="font-medium text-slate-300 text-sm mb-2">
                                        <?php echo esc_html( $period['name'] ); ?>
                                    </div>
                                    
                                    <!-- Icon -->
                                    <?php if( ! empty( $period['icon'] ) ) : ?>
                                    <img src="<?php echo esc_url( $period['icon'] ); ?>" 
                                        alt=""
                                        class="w-16 h-16 rounded bg-slate-800 mx-auto my-2">
                                    <?php endif; ?>
                                    
                                    <!-- Temperature -->
                                    <div class="text-blue-400 font-bold text-2xl my-2">
                                        <?php echo esc_html( $period['temperature'] ); ?>°<?php echo esc_html( $period['temperatureUnit'] ); ?>
                                    </div>
                                    
                                    <!-- Short Forecast -->
                                    <div class="text-slate-400 text-xs mb-2 flex-grow">
                                        <?php echo esc_html( $period['shortForecast'] ); ?>
                                    </div>
                                    
                                    <!-- Wind -->
                                    <?php if( ! empty( $period['windSpeed'] ) || ! empty( $period['windDirection'] ) ) : 
                                        $wind_degrees = SGU_Static::compass_to_degrees( $period['windDirection'] ?? 'N' );
                                    ?>
                                    <div class="text-xs text-slate-500 flex items-center justify-center gap-1 mt-auto pt-2 border-t border-slate-700">
                                        <svg class="w-4 h-4 text-blue-400" style="transform: rotate(<?php echo esc_attr( $wind_degrees ); ?>deg);" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2L6 12h4v10h4V12h4L12 2z"/>
                                        </svg>
                                        <?php echo esc_html( $period['windSpeed'] ?? '' ); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="bg-slate-900 px-6 py-3 border-t border-slate-700 text-sm text-slate-500 flex justify-between">
                        <?php if( ! empty( $noaa_forecast -> generatedAt ) ) : ?>
                        <span>
                            Updated: <?php echo esc_html( date( 'M j, g:i A', strtotime( $noaa_forecast -> generatedAt ) ) ); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>

</div>