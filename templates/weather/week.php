<?php
/**
 * Weekly Weather Forecast Template
 * 
 * Displays 7-day forecast with NOAA detailed predictions
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>
<div class="sgu-weather-container sgu-weather-weekly-container" data-weather-type="weekly">
    
    <h2 class="text-3xl font-heading font-bold text-cyan-400 mb-6 border-b-2 border-cyan-500 pb-2"><?php echo esc_html( $title ); ?></h2>

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
                <p>Please set your location to view the 7-day forecast.</p>
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

            <!-- OpenWeather Daily Forecast Grid -->
            <?php if( isset( $forecast -> daily ) && ! empty( $forecast -> daily ) ) : ?>
            <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden mb-6">
                <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                    <h3 class="text-xl mt-3 font-bold text-cyan-400 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <?php echo esc_html( $days_to_show ); ?>-Day Forecast
                        <?php if( $loc_display ) : ?>
                        <span class="text-sm text-slate-400 font-normal ml-2">— <?php echo esc_html( $loc_display ); ?></span>
                        <?php endif; ?>
                    </h3>
                </div>
                <div class="p-4 overflow-x-auto">
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-2">
                        <?php 
                        $day_count = 0;
                        foreach( $forecast -> daily as $day ) : 
                            if( $day_count >= $days_to_show ) break;
                            $day_count++;
                            
                            $day_name = date( 'D', $day['dt'] );
                            $day_date = date( 'M j', $day['dt'] );
                            $day_high = round( $day['temp']['max'] );
                            $day_low = round( $day['temp']['min'] );
                            $day_icon = $day['weather'][0]['icon'] ?? '01d';
                            $day_desc = $day['weather'][0]['description'] ?? '';
                            $day_pop = isset( $day['pop'] ) ? round( $day['pop'] * 100 ) : 0;
                            
                            // Highlight today
                            $is_today = ( date( 'Y-m-d', $day['dt'] ) === date( 'Y-m-d' ) );
                        ?>
                        <div class="text-center p-3 rounded-lg <?php echo $is_today ? 'bg-cyan-900/50 border border-cyan-700' : 'bg-slate-900'; ?>">
                            <div class="font-bold <?php echo $is_today ? 'text-cyan-400' : 'text-slate-200'; ?>">
                                <?php echo $is_today ? 'Today' : esc_html( $day_name ); ?>
                            </div>
                            <div class="text-xs text-slate-500"><?php echo esc_html( $day_date ); ?></div>
                            <img src="https://openweathermap.org/img/wn/<?php echo esc_attr( $day_icon ); ?>@2x.png" 
                                 alt="<?php echo esc_attr( $day_desc ); ?>"
                                 class="w-14 h-14 mx-auto">
                            <div class="mt-1">
                                <span class="font-bold text-slate-200"><?php echo esc_html( $day_high ); ?>°</span>
                                <span class="text-slate-500"><?php echo esc_html( $day_low ); ?>°</span>
                            </div>
                            <div class="text-xs text-slate-400 truncate" title="<?php echo esc_attr( ucfirst( $day_desc ) ); ?>">
                                <?php echo esc_html( ucfirst( $day_desc ) ); ?>
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

            <!-- NOAA Extended Forecast -->
            <?php if( $use_noaa && $noaa_forecast && ! empty( $noaa_forecast -> periods ) ) : ?>
            <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
                <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                    <h3 class="text-xl mt-3 font-bold text-cyan-400 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Extended Forecast
                    </h3>
                </div>
                <div class="divide-y divide-slate-700">
                    <?php foreach( $noaa_forecast -> periods as $index => $period ) : ?>
                    <details class="group" <?php echo $index < 2 ? 'open' : ''; ?>>
                        <summary class="px-6 py-4 cursor-pointer hover:bg-slate-900/50 transition-colors list-none">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <?php if( ! empty( $period['icon'] ) ) : ?>
                                    <img src="<?php echo esc_url( $period['icon'] ); ?>" 
                                         alt=""
                                         class="w-10 h-10 rounded bg-slate-900">
                                    <?php endif; ?>
                                    <span class="font-medium text-slate-200">
                                        <?php echo esc_html( $period['name'] ); ?>
                                    </span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-cyan-400 font-bold">
                                        <?php echo esc_html( $period['temperature'] ); ?>°<?php echo esc_html( $period['temperatureUnit'] ); ?>
                                    </span>
                                    <svg class="w-5 h-5 text-slate-500 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </summary>
                        <div class="px-6 pb-4">
                            <p class="text-slate-400 text-sm mb-2">
                                <strong class="text-slate-300"><?php echo esc_html( $period['shortForecast'] ); ?></strong>
                            </p>
                            <p class="text-slate-300 text-sm">
                                <?php echo esc_html( $period['detailedForecast'] ); ?>
                            </p>
                            <?php if( ! empty( $period['windSpeed'] ) || ! empty( $period['windDirection'] ) ) : ?>
                            <p class="text-xs text-slate-500 mt-3 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                                Wind: <?php echo esc_html( $period['windSpeed'] ?? '' ); ?> <?php echo esc_html( $period['windDirection'] ?? '' ); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                    </details>
                    <?php endforeach; ?>
                </div>
                <div class="bg-slate-900 px-6 py-3 border-t border-slate-700 text-sm text-slate-500 flex justify-between">
                    <span></span>
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