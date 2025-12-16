<?php
/**
 * Current Weather Template
 * 
 * Displays current weather conditions from OpenWeather API
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>
<div class="sgu-weather-container sgu-weather-current-container" data-weather-type="current">
    
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
            <p class="mt-3 text-slate-400">Loading weather data...</p>
        </div>
    </div>

    <!-- Weather Content -->
    <div class="sgu-weather-content">
        
        <?php if( ! $has_location ) : ?>
            <div class="sgu-weather-no-location bg-cyan-900/50 border border-cyan-700 rounded-lg p-4 text-cyan-200">
                <p>Please set your location above to view weather data.</p>
            </div>
        <?php elseif( ! $weather ) : ?>
            <div class="sgu-weather-error bg-amber-900/50 border border-amber-700 rounded-lg p-4 text-amber-200">
                <p>Unable to retrieve weather data. Please try again later.</p>
            </div>
        <?php else : ?>
            
            <?php
            // Extract weather data
            $temp = round( $weather -> main -> temp ?? 0 );
            $feels_like = round( $weather -> main -> feels_like ?? 0 );
            $humidity = $weather -> main -> humidity ?? 0;
            $pressure = $weather -> main -> pressure ?? 0;
            $wind_speed = round( $weather -> wind -> speed ?? 0 );
            $wind_deg = $weather -> wind -> deg ?? 0;
            $description = ucfirst( $weather -> weather[0] -> description ?? '' );
            $icon = $weather -> weather[0] -> icon ?? '01d';
            $visibility = isset( $weather -> visibility ) ? round( $weather -> visibility / 1609.34, 1 ) : null;
            $clouds = $weather -> clouds -> all ?? 0;
            $sunrise = isset( $weather -> sys -> sunrise ) ? date( 'g:i A', $weather -> sys -> sunrise ) : '';
            $sunset = isset( $weather -> sys -> sunset ) ? date( 'g:i A', $weather -> sys -> sunset ) : '';
            
            // Location name
            $loc_display = '';
            if( $location_name ) {
                $loc_display = $location_name -> name;
                if( ! empty( $location_name -> state ) ) {
                    $loc_display .= ', ' . $location_name -> state;
                }
            }
            
            // Wind direction to compass
            $wind_directions = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW'];
            $wind_dir = $wind_directions[ round( $wind_deg / 22.5 ) % 16 ];
            ?>

            <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
                <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl mt-3 font-bold text-cyan-400 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <?php echo esc_html( $loc_display ); ?>
                        </h3>
                        <button type="button" class="inline-flex items-center justify-center w-10 h-10 bg-slate-800 text-slate-300 rounded-lg hover:bg-cyan-600 hover:text-white transition-colors border border-slate-700 sgu-weather-refresh" title="Refresh">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Main Temperature -->
                        <div class="text-center">
                            <img src="https://openweathermap.org/img/wn/<?php echo esc_attr( $icon ); ?>@4x.png" 
                                 alt="<?php echo esc_attr( $description ); ?>"
                                 class="sgu-weather-icon w-36 h-36 mx-auto">
                            <div class="sgu-weather-temp text-6xl font-bold text-slate-100 leading-none">
                                <?php echo esc_html( $temp ); ?>°F
                            </div>
                            <div class="sgu-weather-desc text-xl text-slate-300 mt-2">
                                <?php echo esc_html( $description ); ?>
                            </div>
                            <div class="text-slate-500 mt-1">
                                Feels like <?php echo esc_html( $feels_like ); ?>°F
                            </div>
                        </div>

                        <!-- Weather Details -->
                        <?php if( $show_details ) : ?>
                        <div>
                            <ul class="divide-y divide-slate-700">
                                <li class="py-3 flex items-center gap-3">
                                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                    </svg>
                                    <span class="text-slate-400">Humidity:</span>
                                    <span class="sgu-weather-humidity text-slate-200 ml-auto font-medium"><?php echo esc_html( $humidity ); ?>%</span>
                                </li>
                                <li class="py-3 flex items-center gap-3">
                                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                    <span class="text-slate-400">Wind:</span>
                                    <span class="sgu-weather-wind text-slate-200 ml-auto font-medium"><?php echo esc_html( $wind_speed ); ?> mph <?php echo esc_html( $wind_dir ); ?></span>
                                </li>
                                <li class="py-3 flex items-center gap-3">
                                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <span class="text-slate-400">Pressure:</span>
                                    <span class="text-slate-200 ml-auto font-medium"><?php echo esc_html( $pressure ); ?> hPa</span>
                                </li>
                                <?php if( $visibility ) : ?>
                                <li class="py-3 flex items-center gap-3">
                                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span class="text-slate-400">Visibility:</span>
                                    <span class="text-slate-200 ml-auto font-medium"><?php echo esc_html( $visibility ); ?> mi</span>
                                </li>
                                <?php endif; ?>
                                <li class="py-3 flex items-center gap-3">
                                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                    </svg>
                                    <span class="text-slate-400">Cloud Cover:</span>
                                    <span class="text-slate-200 ml-auto font-medium"><?php echo esc_html( $clouds ); ?>%</span>
                                </li>
                                <?php if( $sunrise && $sunset ) : ?>
                                <li class="py-3 flex items-center gap-3">
                                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <span class="text-slate-400">Sunrise:</span>
                                    <span class="text-slate-200 ml-auto font-medium"><?php echo esc_html( $sunrise ); ?></span>
                                </li>
                                <li class="py-3 flex items-center gap-3">
                                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                    </svg>
                                    <span class="text-slate-400">Sunset:</span>
                                    <span class="text-slate-200 ml-auto font-medium"><?php echo esc_html( $sunset ); ?></span>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="bg-slate-900 px-6 py-3 border-t border-slate-700 text-sm text-slate-500 flex justify-between items-center">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Last updated: <?php echo esc_html( date( 'g:i A, M j', $weather -> dt ?? time() ) ); ?>
                    </span>
                </div>
            </div>

        <?php endif; ?>

    </div>

</div>