<?php
/**
 * Daily Weather Forecast Template
 * 
 * Displays today's detailed forecast with hourly breakdown
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

if( ! $forecast ) {
    $forecast = $daily_forecast;
}
if( ! $use_noaa ) {
    $use_noaa = $show_noaa;
}
?>
<div class="sgu-weather-container sgu-weather-daily-container" data-weather-type="daily">
    
    <?php include locate_template( ['templates/weather/partials/header.php'] ); ?>

    <!-- Weather Content -->
    <div class="sgu-weather-content">
        
        <?php if( ! $has_location ) : ?>
            <div class="sgu-weather-no-location bg-cyan-900/50 border border-cyan-700 rounded-lg p-4 text-cyan-200">
                <p>Please set your location to view the forecast.</p>
            </div>
        <?php else : ?>

            <!-- NOAA Detailed Forecast -->
            <?php if( $use_noaa && $noaa_forecast && ! empty( $noaa_forecast -> periods ) ) : ?>
                <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden mb-6">
                    <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                        <h3 class="text-xl mt-3 font-bold text-cyan-400 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <?php echo esc_html( $title ); ?>
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-2">
                            <?php 
                            // Show first 2 periods (today and tonight)
                            $shown = 0;
                            foreach( $noaa_forecast -> periods as $period ) : 
                                if( $shown >= 2 ) break;
                                $shown++;
                            ?>
                            <div class="flex gap-4">
                                <?php if( ! empty( $period['icon'] ) ) : ?>
                                <img src="<?php echo esc_url( $period['icon'] ); ?>" 
                                    alt="<?php echo esc_attr( $period['shortForecast'] ); ?>"
                                    class="w-16 h-16 rounded-lg bg-slate-900 flex-shrink-0 mt-1">
                                <?php endif; ?>
                                <div class="flex-grow min-w-0">
                                    <h4 class="font-bold text-slate-200 mt-0">
                                        <?php echo esc_html( $period['name'] ); ?>
                                        <span class="text-cyan-400 ml-2"><?php echo esc_html( $period['temperature'] ); ?>°<?php echo esc_html( $period['temperatureUnit'] ); ?></span>
                                    </h4>
                                    <p class="text-slate-400 text-sm mb-1">
                                        <?php echo esc_html( $period['shortForecast'] ); ?>
                                    </p>
                                    <?php if( ! empty( $period['windSpeed'] ) ) : ?>
                                    <p class="text-slate-500 text-xs mt-1">
                                        Wind: <?php echo esc_html( $period['windSpeed'] ); ?> <?php echo esc_html( $period['windDirection'] ?? '' ); ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <?php if( ! empty( $noaa_forecast -> periods[0]['detailedForecast'] ) ) : ?>
                        <div class="mt-1 pt-4 border-t border-slate-700">
                            <p class="text-sm text-slate-300 my-0">
                                <?php echo esc_html( $noaa_forecast -> periods[0]['detailedForecast'] ); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>

</div>
