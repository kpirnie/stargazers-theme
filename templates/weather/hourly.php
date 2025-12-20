<?php
/**
 * Weather Hourly Template
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

if( !$hourly_forecast ) {
    $hourly_forecast = $forecast;
}
?>
<div class="sgu-weather-container sgu-weather-hourly-container" data-weather-type="hourly">
    
    <?php include locate_template( ['templates/weather/header.php'] ); ?>

    <!-- Weather Content -->
    <div class="sgu-weather-content">
        
        <?php if( ! $has_location ) : ?>
            <div class="sgu-weather-no-location bg-cyan-900/50 border border-cyan-700 rounded-lg p-4 text-cyan-200">
                <p>Please set your location to view the forecast.</p>
            </div>
        <?php else : ?>

            <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden mt-6">
                <?php if( $show_title && ! $is_dash ) { ?>
                <div class="bg-slate-900 px-6 py-4 border-b border-slate-700">
                    <h3 class="text-xl mt-3 font-bold text-cyan-400 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <?php echo esc_html( ( ! $is_dash ) ? $title : 'Today\'s Hourly Forecast' ); ?>
                    </h3>
                </div>
                <?php } ?>
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
                            $wind_deg = $hour['wind_deg'] ?? 0;
                            $wind_dir = SGU_Static::wind_direction_to_compass( $wind_deg );
                        ?>
                        <div class="text-center bg-slate-900 rounded-lg p-3 min-w-[70px]">
                            <div class="text-xs text-slate-400"><?php echo esc_html( $hour_time ); ?></div>
                            <div class="text-2xl my-2">
                                <?php echo SGU_Static::get_weather_emoji( $hour_icon ); ?>
                            </div>
                            <div class="text-xs text-cyan-400">
                                <?php echo esc_html( $wind_speed ); ?> mph <?php echo esc_html( $wind_dir ); ?>
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

    </div>

</div>