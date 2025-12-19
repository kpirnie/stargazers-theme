<?php
/**
 * Current Weather Template
 * 
 * Displays current weather conditions from Open-Meteo API
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// check if we're in the normal current weather block
if( ! $current_weather ) {
    $current_weather = $weather;
}
?>
<div class="sgu-weather-container sgu-weather-current-container" data-weather-type="current">
    <?php
        // include the weather header template
        include locate_template( ['templates/weather/partials/header.php'] );
    ?>
    <!-- Weather Content -->
    <div class="sgu-weather-content">
        <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
            <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                <h3 class="text-xl mt-3 font-bold text-cyan-400 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <?php echo esc_html( $title ); ?>
                </h3>
            </div>
            <div class="p-4">
                <?php
                $temp = round( $current_weather -> main -> temp ?? 0 );
                $feels_like = round( $current_weather -> main -> feels_like ?? 0 );
                $humidity = round( $current_weather -> main -> humidity ?? 0 );
                $pressure = round( $current_weather -> main -> pressure ?? 0 );
                $wind_speed = round( $current_weather -> wind -> speed ?? 0 );
                $wind_direction = $current_weather -> wind -> deg ?? 0;
                $description = ucfirst( $current_weather -> weather[0] -> description ?? '' );
                $icon = $current_weather -> weather[0] -> icon ?? '01d';
                $wind_dir = SGU_Static::wind_direction_to_compass( $wind_direction );
                $clouds = $current_weather -> clouds -> all ?? 0;
                $sunrise = isset( $current_weather -> sys -> sunrise ) ? date( 'g:i A', $current_weather -> sys -> sunrise ) : '';
                $sunset = isset( $current_weather -> sys -> sunset ) ? date( 'g:i A', $current_weather -> sys -> sunset ) : '';
                ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- Weather Details (Left) -->
                    <ul class="divide-y divide-slate-700 text-sm pl-1 mt-1">
                        <li class="py-2 flex items-center gap-3">
                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                            </svg>
                            <span class="text-slate-400">Humidity:</span>
                            <span class="text-slate-200 ml-auto font-medium"><?php echo esc_html( $humidity ); ?>%</span>
                        </li>
                        <li class="py-2 flex items-center gap-3">
                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                            <span class="text-slate-400">Wind:</span>
                            <span class="text-slate-200 ml-auto font-medium"><?php echo esc_html( $wind_speed ); ?> mph <?php echo esc_html( $wind_dir ); ?></span>
                        </li>
                        <li class="py-2 flex items-center gap-3">
                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="text-slate-400">Pressure:</span>
                            <span class="text-slate-200 ml-auto font-medium"><?php echo esc_html( $pressure ); ?> hPa</span>
                        </li>
                        <li class="py-2 flex items-center gap-3">
                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                            </svg>
                            <span class="text-slate-400">Cloud Cover:</span>
                            <span class="text-slate-200 ml-auto font-medium"><?php echo esc_html( $clouds ); ?>%</span>
                        </li>
                        <?php if( $sunrise && $sunset ) : ?>
                        <li class="py-2 flex items-center gap-3">
                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="text-slate-400">Sunrise:</span>
                            <span class="text-slate-200 ml-auto font-medium"><?php echo esc_html( $sunrise ); ?></span>
                        </li>
                        <li class="py-2 flex items-center gap-3">
                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            <span class="text-slate-400">Sunset:</span>
                            <span class="text-slate-200 ml-auto font-medium"><?php echo esc_html( $sunset ); ?></span>
                        </li>
                        <?php endif; ?>
                    </ul>
                    
                    <!-- Main Temperature (Right) -->
                    <div class="text-center my-auto">
                        <div class="text-7xl leading-none">
                            <?php echo SGU_Static::get_weather_emoji( $icon ); ?>
                        </div>
                        <div class="text-5xl font-bold text-slate-100 leading-none mt-2">
                            <?php echo esc_html( $temp ); ?>°F
                        </div>
                        <div class="text-lg text-slate-300 mt-2">
                            <?php echo esc_html( $description ); ?>
                        </div>
                        <div class="text-slate-500">
                            Feels like <?php echo esc_html( $feels_like ); ?>°F
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>