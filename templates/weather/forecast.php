<?php
/**
 * Full Weather Dashboard Template
 * 
 * Comprehensive weather display combining all components
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>
<div class="sgu-weather-dashboard">
    
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

    <?php if( ! $has_location ) : ?>
        <div class="sgu-weather-no-location bg-cyan-900/50 border border-cyan-700 rounded-lg p-4 text-cyan-200 mt-6">
            <p>Please set your location above to view weather data.</p>
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

        <!-- Weather Alerts (if any) -->
        <?php if( $show_alerts && ! empty( $alerts ) ) : ?>
        <div class="mt-6">
            <?php 
            $title = '';
            $show_location_picker = false;
            $max_alerts = 3;
            include locate_template( ['templates/weather/alerts.php', 'sgu/weather/alerts.php', 'stargazers/weather/alerts.php'] ) ?: SGUP_PATH . '/templates/weather/alerts.php'; 
            ?>
        </div>
        <?php endif; ?>

        <!-- Current Weather + Daily Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            
            <?php if( $show_current && $current_weather ) : ?>

            <!-- Current Conditions -->
            <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
                <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                    <h3 class="text-xl mt-3 font-bold text-cyan-400 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                        </svg>
                        Current Conditions
                        <?php if( $loc_display ) : ?>
                        <span class="text-sm text-slate-400 font-normal ml-2">— <?php echo esc_html( $loc_display ); ?></span>
                        <?php endif; ?>
                    </h3>
                </div>
                <div class="p-6">
                    <?php
                    $temp = round( $current_weather -> main -> temp ?? 0 );
                    $feels_like = round( $current_weather -> main -> feels_like ?? 0 );
                    $humidity = round( $current_weather -> main -> humidity ?? 0 );
                    $pressure = round( $current_weather -> main -> pressure ?? 0 );
                    $wind_speed = round( $current_weather -> wind -> speed ?? 0 );
                    $wind_direction = $current_weather -> wind -> deg ?? 0;
                    $description = ucfirst( $current_weather -> weather[0] -> description ?? '' );
                    $icon = $current_weather -> weather[0] -> icon ?? '01d';
                    ?>
                    
                    <div class="flex items-center gap-4">
                        <img src="https://openweathermap.org/img/wn/<?php echo esc_attr( $icon ); ?>@2x.png" 
                             alt="<?php echo esc_attr( $description ); ?>"
                             class="w-24 h-24">
                        <div>
                            <div class="text-5xl font-bold text-slate-100">
                                <?php echo esc_html( $temp ); ?>°F
                            </div>
                            <div class="text-slate-400">
                                Feels Like: <?php echo esc_html( $feels_like ); ?>°F
                            </div>
                            <div class="text-slate-400">
                                <?php echo esc_html( $description ); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-4 mt-6 text-center">
                        <div class="bg-slate-900 rounded-lg p-3">
                            <div class="text-slate-400 text-sm">Humidity</div>
                            <div class="text-lg font-bold text-slate-200"><?php echo esc_html( $humidity ); ?>%</div>
                        </div>
                        <div class="bg-slate-900 rounded-lg p-3">
                            <div class="text-slate-400 text-sm">Wind</div>
                            <div class="text-lg font-bold text-slate-200">
                                <?php echo esc_html( $wind_speed ); ?> mph
                                <?php echo sgu_wind_direction_arrow( $wind_direction ); ?>
                            </div>
                        </div>
                        <div class="bg-slate-900 rounded-lg p-3">
                            <div class="text-slate-400 text-sm">Pressure</div>
                            <div class="text-lg font-bold text-slate-200"><?php echo esc_html( $pressure ); ?> inHg</div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if( $show_noaa && $noaa_forecast && ! empty( $noaa_forecast -> periods ) ) : ?>

            <!-- Today's Forecast -->
            <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
                <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                    <h3 class="text-xl mt-3 font-bold text-cyan-400 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Today's Forecast
                    </h3>
                </div>
                <div class="p-6">
                    <?php $period = $noaa_forecast -> periods[0]; ?>
                    <div class="flex items-center gap-4">
                        <?php if( ! empty( $period['icon'] ) ) : ?>
                        <img src="<?php echo esc_url( $period['icon'] ); ?>" 
                             alt=""
                             class="w-20 h-20">
                        <?php endif; ?>
                        <div>
                            <div class="font-bold text-slate-200">
                                <?php echo esc_html( $period['name'] ); ?>: 
                                <span class="text-cyan-400"><?php echo esc_html( $period['temperature'] ); ?>°<?php echo esc_html( $period['temperatureUnit'] ); ?></span>
                            </div>
                            <div class="text-slate-400">
                                <?php echo esc_html( $period['shortForecast'] ); ?><br />
                                Precip: <?php echo esc_html( $period['probabilityOfPrecipitation']['value'] ?? 0 ); ?>%
                            </div>
                        </div>
                    </div>
                    
                    <p class="mt-4 text-slate-300">
                        <?php echo esc_html( $period['detailedForecast'] ); ?>
                    </p>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <!-- Hourly Forecast -->
        <?php if( $show_hourly && $hourly_forecast && isset( $hourly_forecast -> hourly ) ) : ?>
        <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden mt-6">
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
                    foreach( $hourly_forecast -> hourly as $hour ) : 
                        if( $hour_count >= 24 ) break;
                        $hour_count++;
                        
                        $hour_time = date( 'g A', $hour['dt'] );
                        $hour_temp = round( $hour['temp'] );
                        $hour_icon = $hour['weather'][0]['icon'] ?? '01d';
                        $hour_pop = isset( $hour['pop'] ) ? round( $hour['pop'] * 100 ) : 0;
                        $wind_speed = round( $hour['wind_speed'] ?? 0 );
                        $wind_dir = $hour['wind_deg'] ?? 0;
                    ?>
                    <div class="text-center bg-slate-900 rounded-lg p-3 min-w-[70px]">
                        <div class="text-xs text-slate-400"><?php echo esc_html( $hour_time ); ?></div>
                        <img src="https://openweathermap.org/img/wn/<?php echo esc_attr( $hour_icon ); ?>.png" 
                             class="w-10 h-10 mx-auto my-2">
                        <div class="text-xs text-cyan-400">
                            <?php echo esc_html( $wind_speed ); ?> mph 
                            <?php echo sgu_wind_direction_arrow( $wind_dir ); ?>
                        </div>
                        <div class="font-bold text-slate-200"><?php echo esc_html( $hour_temp ); ?>°</div>
                        <?php if( $hour_pop > 0 ) : ?>
                        <div class="text-xs text-cyan-400"><?php echo esc_html( $hour_pop ); ?>%</div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- 7-Day Forecast -->
        <?php if( $show_daily && $daily_forecast && isset( $daily_forecast -> daily ) ) : ?>
        <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden mt-6">
            <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                <h3 class="text-xl mt-3 font-bold text-cyan-400 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    7-Day Forecast
                </h3>
            </div>
            <div class="p-4 overflow-x-auto">
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-2">
                    <?php 
                    $day_count = 0;
                    foreach( $daily_forecast -> daily as $day ) : 
                        if( $day_count >= 7 ) break;
                        $day_count++;
                        
                        $is_today = ( date( 'Y-m-d', $day['dt'] ) === date( 'Y-m-d' ) );
                        $day_name = $is_today ? 'Today' : date( 'D', $day['dt'] );
                        $day_date = date( 'M j', $day['dt'] );
                        $day_high = round( $day['temp']['max'] );
                        $day_low = round( $day['temp']['min'] );
                        $day_icon = $day['weather'][0]['icon'] ?? '01d';
                        $day_desc = ucfirst( $day['weather'][0]['description'] ?? '' );
                        $day_pop = isset( $day['pop'] ) ? round( $day['pop'] * 100 ) : 0;

                    ?>
                    <div class="text-center p-3 rounded-lg <?php echo $is_today ? 'bg-cyan-900/50 border border-cyan-700' : 'bg-slate-900'; ?>">
                        <div class="font-bold <?php echo $is_today ? 'text-cyan-400' : 'text-slate-200'; ?>">
                            <?php echo esc_html( $day_name ); ?>
                        </div>
                        <div class="text-xs text-slate-500"><?php echo esc_html( $day_date ); ?></div>
                        <img src="https://openweathermap.org/img/wn/<?php echo esc_attr( $day_icon ); ?>@2x.png" 
                            class="w-25 h-25 mx-auto my-1">
                        <div class="mt-1">
                            <span class="font-bold text-slate-200"><?php echo esc_html( $day_high ); ?>°</span>
                            <span class="text-slate-500"><?php echo esc_html( $day_low ); ?>°</span>
                        </div>
                        <div class="text-xs text-slate-400 truncate" title="<?php echo esc_attr( $day_desc ); ?>">
                            <?php echo esc_html( $day_desc ); ?>
                        </div>
                        <?php if( $day_pop > 0 ) : ?>
                        <div class="text-xs text-cyan-400 flex items-center justify-center gap-1 mt-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                            </svg>
                            <?php echo esc_html( $day_pop ); ?>%
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        

        <!-- Footer -->
        <div class="mt-6 text-sm text-slate-500 text-center">
            <button type="button" class="inline-flex items-center gap-1 text-cyan-400 hover:text-cyan-300 transition-colors mt-2 sgu-weather-refresh">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Refresh Data
            </button>
        </div>

    <?php endif; ?>

</div>