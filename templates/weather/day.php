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

?>
<div class="sgu-weather-container sgu-weather-daily-container" data-weather-type="daily">
    
    <h2 class="text-3xl font-heading font-bold text-cyan-400 mb-6 border-b-2 border-cyan-500 pb-2"><?php echo esc_html( $title ); ?></h2>

    <!-- Location Picker -->
    <?php if( $show_location_picker ) : ?>
        <?php 
        $compact = true;
        $title = $title ?? 'Set Your Location';
        $has_location = $has_location ?? false;
        $location = $location ?? null;
        include locate_template( ['templates/weather/location-picker.php', 'sgu/weather/location-picker.php', 'stargazers/weather/location-picker.php'] ) ?: SGUP_PATH . '/templates/weather/location-picker.php'; 
        ?>
    <?php endif; ?>

    <!-- Loading State -->
    <div class="sgu-weather-loading hidden">
        <div class="text-center py-8">
            <svg class="animate-spin h-10 w-10 text-cyan-400 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="mt-3 text-slate-400">Loading forecast...</p>
        </div>
    </div>

    <!-- Weather Content -->
    <div class="sgu-weather-content">
        
        <?php if( ! $has_location ) : ?>
            <div class="sgu-weather-no-location bg-cyan-900/50 border border-cyan-700 rounded-lg p-4 text-cyan-200">
                <p>Please set your location to view the forecast.</p>
            </div>
        <?php elseif( ! $forecast ) : ?>
            <div class="sgu-weather-error bg-amber-900/50 border border-amber-700 rounded-lg p-4 text-amber-200">
                <p>Unable to retrieve forecast data. Please try again later.</p>
            </div>
        <?php else : ?>

            <?php
            // Location name
            $loc_display = '';
            if( $location_name ) {
                $loc_display = $location_name -> name;
                if( ! empty( $location_name -> state ) ) {
                    $loc_display .= ', ' . $location_name -> state;
                }
            }
            ?>

            <!-- NOAA Detailed Forecast -->
            <?php if( $use_noaa && $noaa_forecast && ! empty( $noaa_forecast -> periods ) ) : ?>
            <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden mb-6">
                <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                    <h3 class="text-xl mt-3 font-bold text-cyan-400 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Detailed Forecast
                        <?php if( $loc_display ) : ?>
                        <span class="text-sm text-slate-400 font-normal ml-2">— <?php echo esc_html( $loc_display ); ?></span>
                        <?php endif; ?>
                    </h3>
                </div>
                <div class="p-6">
                    <?php 
                    // Show first 2 periods (today and tonight)
                    $shown = 0;
                    foreach( $noaa_forecast -> periods as $period ) : 
                        if( $shown >= 2 ) break;
                        $shown++;
                    ?>
                    <div class="<?php echo $shown < 2 ? 'mb-6 pb-6 border-b border-slate-700' : ''; ?>">
                        <div class="flex items-center gap-4">
                            <?php if( ! empty( $period['icon'] ) ) : ?>
                            <img src="<?php echo esc_url( $period['icon'] ); ?>" 
                                 alt="<?php echo esc_attr( $period['shortForecast'] ); ?>"
                                 class="w-20 h-20 rounded-lg bg-slate-900">
                            <?php endif; ?>
                            <div>
                                <h4 class="font-bold text-slate-200">
                                    <?php echo esc_html( $period['name'] ); ?>
                                    <span class="text-cyan-400 ml-2"><?php echo esc_html( $period['temperature'] ); ?>°<?php echo esc_html( $period['temperatureUnit'] ); ?></span>
                                </h4>
                                <p class="text-slate-400">
                                    <?php echo esc_html( $period['shortForecast'] ); ?>
                                </p>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-slate-300">
                            <?php echo esc_html( $period['detailedForecast'] ); ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Hourly Forecast -->
            <?php if( $show_hourly && isset( $forecast -> hourly ) && ! empty( $forecast -> hourly ) ) : ?>
            <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
                <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                    <h3 class="text-xl mt-3 font-bold text-cyan-400 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Hourly Forecast
                    </h3>
                </div>
                <div class="p-4 overflow-x-auto">
                    <div class="flex gap-2" style="min-width: max-content;">
                        <?php 
                        $hour_count = 0;
                        foreach( $forecast -> hourly as $hour ) : 
                            if( $hour_count >= $hours_to_show ) break;
                            $hour_count++;
                            
                            $hour_time = date( 'g A', $hour['dt'] );
                            $hour_temp = round( $hour['temp'] );
                            $hour_icon = $hour['weather'][0]['icon'] ?? '01d';
                            $hour_desc = $hour['weather'][0]['description'] ?? '';
                            $hour_pop = isset( $hour['pop'] ) ? round( $hour['pop'] * 100 ) : 0;
                        ?>
                        <div class="text-center bg-slate-900 rounded-lg p-3 min-w-[80px]">
                            <div class="text-xs text-slate-400"><?php echo esc_html( $hour_time ); ?></div>
                            <img src="https://openweathermap.org/img/wn/<?php echo esc_attr( $hour_icon ); ?>.png" 
                                 alt="<?php echo esc_attr( $hour_desc ); ?>"
                                 class="w-12 h-12 mx-auto">
                            <div class="font-bold text-slate-200"><?php echo esc_html( $hour_temp ); ?>°</div>
                            <?php if( $hour_pop > 0 ) : ?>
                            <div class="text-xs text-cyan-400 flex items-center justify-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                </svg>
                                <?php echo esc_html( $hour_pop ); ?>%
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Current Day Summary from OpenWeather -->
            <?php if( isset( $forecast -> daily ) && ! empty( $forecast -> daily ) ) : ?>
            <?php 
            $today = $forecast -> daily[0];
            $today_high = round( $today['temp']['max'] ?? 0 );
            $today_low = round( $today['temp']['min'] ?? 0 );
            $today_sunrise = date( 'g:i A', $today['sunrise'] ?? 0 );
            $today_sunset = date( 'g:i A', $today['sunset'] ?? 0 );
            $today_uvi = $today['uvi'] ?? 0;
            $today_summary = $today['summary'] ?? '';
            ?>
            <div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-lg border border-slate-700 mt-6 p-4">
                <div class="flex flex-wrap justify-center gap-6 text-sm">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        <span class="text-slate-400">High:</span>
                        <span class="font-bold text-slate-200"><?php echo esc_html( $today_high ); ?>°F</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                        <span class="text-slate-400">Low:</span>
                        <span class="font-bold text-slate-200"><?php echo esc_html( $today_low ); ?>°F</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="text-slate-400">UV Index:</span>
                        <span class="font-bold text-slate-200"><?php echo esc_html( $today_uvi ); ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span class="text-slate-400">Sunrise:</span>
                        <span class="font-bold text-slate-200"><?php echo esc_html( $today_sunrise ); ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                        <span class="text-slate-400">Sunset:</span>
                        <span class="font-bold text-slate-200"><?php echo esc_html( $today_sunset ); ?></span>
                    </div>
                </div>
                <?php if( $today_summary ) : ?>
                <p class="mt-4 text-center text-slate-300">
                    <?php echo esc_html( $today_summary ); ?>
                </p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>

</div>