<?php
/**
 * Sun Rise/Set Template
 * 
 * @package Stargazers Theme
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );
?>

<div class="my-4" <?php echo $wrapper_attr; ?>>

    <?php if ( $show_title && ! empty( $title ) ) : ?>
        <h2 class="text-3xl font-heading font-bold text-cyan-400 mb-4 border-b-2 border-cyan-500 pb-2 mt-0"><?php echo esc_html( $title ); ?></h2>
    <?php endif; ?>

    <?php if ( $show_location_picker ) : ?>
        <?php 
        $theme_template = locate_template( [
            'templates/weather/partials/location-picker-inline.php',
            'sgu/weather/partials/location-picker-inline.php',
        ] );
        $partial = $theme_template ?: SGUP_PATH . '/templates/weather/partials/location-picker-inline.php';
        if ( file_exists( $partial ) ) {
            include $partial;
        }
        ?>
    <?php endif; ?>

    <?php if ( $sun ) : ?>
        <div class="bg-slate-800 rounded border border-slate-700 overflow-hidden">
            <div class="p-6">
                <div class="space-y-3">
                    <?php if ( $sun->civil_twilight_begin ) : ?>
                        <div class="flex items-center justify-between py-2 border-b border-slate-700">
                            <span class="text-slate-400 flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                                Dawn
                            </span>
                            <span class="text-slate-200 font-medium"><?php echo esc_html( $sun->civil_twilight_begin ); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ( $sun->rise ) : ?>
                        <div class="flex items-center justify-between py-2 border-b border-slate-700">
                            <span class="text-slate-400 flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Sunrise
                            </span>
                            <span class="text-slate-200 font-medium"><?php echo esc_html( $sun->rise ); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ( $sun->transit ) : ?>
                        <div class="flex items-center justify-between py-2 border-b border-slate-700">
                            <span class="text-slate-400 flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Solar Noon
                            </span>
                            <span class="text-slate-200 font-medium"><?php echo esc_html( $sun->transit ); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ( $sun->set ) : ?>
                        <div class="flex items-center justify-between py-2 border-b border-slate-700">
                            <span class="text-slate-400 flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                                Sunset
                            </span>
                            <span class="text-slate-200 font-medium"><?php echo esc_html( $sun->set ); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ( $sun->civil_twilight_end ) : ?>
                        <div class="flex items-center justify-between py-2 border-b border-slate-700">
                            <span class="text-slate-400 flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                                Dusk
                            </span>
                            <span class="text-slate-200 font-medium"><?php echo esc_html( $sun->civil_twilight_end ); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else : ?>
        <p class="bg-red-900/50 border border-red-700 rounded p-6 text-red-200">Unable to retrieve sun data.</p>
    <?php endif; ?>

</div>