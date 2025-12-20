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
    
    <?php include locate_template( ['templates/weather/partials/header.php'] ); ?>

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

            <!-- Open-Meteo Daily Forecast Grid -->
            <?php if( isset( $forecast -> daily ) && ! empty( $forecast -> daily ) ) : ?>
                <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden mb-6">
                    <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                        <h3 class="text-xl mt-3 font-bold text-cyan-400 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <?php echo esc_html( ( ! $is_dash ) ? $title : '7-Day Outlook' ); ?>
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
                                <div class="text-4xl my-2">
                                    <?php echo SGU_Static::get_weather_emoji( $day_icon ); ?>
                                </div>
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
                    <div class="p-4 overflow-x-auto">
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-3">
                            <?php foreach( $noaa_forecast -> periods as $index => $period ) : ?>
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
                                    <?php if( ! empty( $period['windSpeed'] ) || ! empty( $period['windDirection'] ) ) : ?>
                                    <div class="text-xs text-slate-500 flex items-center justify-center gap-1 mt-auto pt-2 border-t border-slate-700">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                        <?php echo esc_html( $period['windSpeed'] ?? '' ); ?> <?php echo esc_html( $period['windDirection'] ?? '' ); ?>
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
