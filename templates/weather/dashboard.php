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

// set the "is dash" flag
$is_dash = true;

?>
<div class="sgu-weather-dashboard">
    
    <!-- Title -->
    <?php if( $title ) : ?>
        <h2 class="text-3xl font-heading font-bold text-cyan-400 mb-6 border-b-2 border-cyan-500 pb-2"><?php echo esc_html( $title ); ?></h2>
    <?php endif; ?>

    <!-- Location Picker -->
    <?php if( $show_location_picker ) : ?>
        <?php 
        $compact = true;
        $title = $title ?? 'Set Your Location';
        $has_location = $has_location ?? false;
        $location = $location ?? null;
        include locate_template( ['templates/weather/location-picker.php'] );
        ?>
    <?php endif; ?>

    <?php if( ! $has_location ) : ?>
        <div class="sgu-weather-no-location bg-cyan-900/50 border border-cyan-700 rounded-lg p-4 text-cyan-200 mt-6">
            <p>Please set your location above to view weather data.</p>
        </div>
    <?php else : ?>

        <!-- Weather Alerts (if any) -->
        <?php if( $show_alerts && ! empty( $alerts ) ) : ?>
            <?php
                // include the weather header template
                include locate_template( ['templates/weather/alerts.php'] );
            ?>
        <?php endif; ?>

        <!-- Current Weather + Daily Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            
            <?php if( $show_current && $current_weather ) : ?>

                <!-- Current Conditions -->
                <?php
                    // include the weather header template
                    include locate_template( ['templates/weather/current.php'] );
                ?>
            <?php endif; ?>

            <?php if( $show_noaa && $noaa_forecast && ! empty( $noaa_forecast -> periods ) ) : ?>

                <!-- Today's Forecast -->
                <?php
                    // include the weather header template
                    include locate_template( ['templates/weather/day.php'] );
                ?>
            <?php endif; ?>

        </div>

        <!-- Hourly Forecast -->
        <?php if( $show_hourly && $hourly_forecast && isset( $hourly_forecast -> hourly ) ) : ?>
            <?php
                // include the weather header template
                include locate_template( ['templates/weather/hourly.php'] );
            ?>
        <?php endif; ?>

        <!-- 7-Day Forecast -->
        <?php if( $show_daily && $daily_forecast && isset( $daily_forecast -> daily ) ) : ?>
            <?php
                // include the weather header template
                include locate_template( ['templates/weather/week.php'] );
            ?>
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