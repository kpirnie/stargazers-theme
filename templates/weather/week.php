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

if( ! $forecast ) {
    $forecast = $daily_forecast;
    $days_to_show = 7;
}
?>
<div class="sgu-weather-container sgu-weather-weekly-container" data-weather-type="weekly">
    
    <?php include locate_template( ['templates/weather/header.php'] ); ?>

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
                    <?php if( $show_title && ! $is_dash ) { ?>
                    <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                        <h3 class="text-xl mt-3 font-bold text-cyan-400 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <?php echo esc_html( ( ! $is_dash ) ? $title : '7-Day Outlook' ); ?>
                        </h3>
                    </div>
                    <?php } ?>
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
                <?php
                    // include the weather header template
                    include locate_template( ['templates/weather/week-extended.php'] );
                ?>
            <?php endif; ?>

        <?php endif; ?>

    </div>

</div>
