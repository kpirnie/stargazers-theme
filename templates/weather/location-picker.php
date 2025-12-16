<?php
/**
 * Weather Location Picker Template
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// Determine display state
$prompt_class = $has_location ? 'hidden' : '';
$compact_class = $compact ? 'sgu-weather-location-compact' : '';

?>

<div class="sgu-weather-location-picker <?php echo esc_attr( $compact_class ); ?> mb-6">
    
    <?php if( ! $compact ) : ?>
    <h3 class="text-xl font-heading font-bold text-cyan-400 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        <?php echo esc_html( $title ); ?>
    </h3>
    <?php endif; ?>

    <!-- Current Location Display -->
    <div class="sgu-weather-has-location <?php echo ! $has_location ? 'hidden' : ''; ?>">
        <div class="flex items-center justify-between bg-slate-800 rounded-lg border border-slate-700 px-4 py-3">
            <div class="flex items-center gap-2 text-slate-200">
                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="sgu-weather-location-name font-medium">
                    <?php 
                    if( $location ) {
                        echo esc_html( $location -> name );
                        if( ! empty( $location -> state ) ) {
                            echo ', ' . esc_html( $location -> state );
                        }
                    }
                    ?>
                </span>
            </div>
            <button type="button" class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-700 text-slate-300 text-sm rounded-lg hover:bg-cyan-600 hover:text-white transition-colors sgu-weather-change-location">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Change Location
            </button>
        </div>
    </div>

    <!-- Location Prompt -->
    <div class="sgu-weather-location-prompt <?php echo esc_attr( $prompt_class ); ?>">
        <div class="bg-slate-800 rounded-lg border border-slate-700 p-6">
            
            <p class="text-slate-400 mb-4">Set your location to see local weather data.</p>

            <!-- Geolocation Button -->
            <div class="mb-4">
                <button type="button" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-cyan-600 text-white font-medium rounded-lg hover:bg-cyan-500 transition-colors sgu-weather-geolocate">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Use My Current Location
                </button>
            </div>

            <div class="text-center mb-4">
                <span class="text-slate-500">— or —</span>
            </div>

            <!-- ZIP Code Form -->
            <form class="sgu-weather-zip-form">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2" for="sgu-weather-zip">Enter ZIP Code</label>
                    <div class="flex gap-2">
                        <input type="text" 
                               class="flex-1 px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 placeholder-slate-500 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 sgu-weather-zip-input" 
                               id="sgu-weather-zip"
                               placeholder="12345"
                               maxlength="5"
                               pattern="[0-9]{5}"
                               inputmode="numeric"
                               required>
                        <button type="submit" class="px-6 py-2 bg-slate-700 text-slate-200 font-medium rounded-lg hover:bg-cyan-600 hover:text-white transition-colors">
                            Find
                        </button>
                    </div>
                </div>
            </form>

            <?php if( $has_location ) : ?>
            <div class="text-center mt-4">
                <button type="button" class="text-slate-400 hover:text-cyan-400 transition-colors text-sm sgu-weather-cancel-change">
                    Cancel
                </button>
            </div>
            <?php endif; ?> 

        </div>
    </div>

</div>