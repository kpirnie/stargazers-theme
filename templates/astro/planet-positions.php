<?php
/**
 * Planet Positions Template
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

    <?php if ( ! $has_credentials ) : ?>
        <div class="bg-amber-900/50 border border-amber-700 rounded p-6 text-amber-200">
            <p>Configure AstronomyAPI credentials to display planet positions.</p>
        </div>
    <?php elseif ( ! empty( $planets ) ) : ?>
        <div class="bg-slate-800 rounded border border-slate-700 overflow-hidden">
            <div class="divide-y divide-slate-700">
                <?php foreach ( $planets as $planet ) : ?>
                    <div class="px-6 py-4 flex items-center gap-4 <?php echo $planet->visible ? 'bg-slate-800' : 'bg-slate-900'; ?>">
                        <?php echo SGU_Static::get_planet_icon( strtolower( $planet->name ), 'w-10 h-10 flex-shrink-0' ); ?>
                        <div class="flex-grow flex items-center justify-between">
                            <span class="font-medium <?php echo $planet->visible ? 'text-cyan-400' : 'text-slate-400'; ?>">
                                <?php echo esc_html( $planet->name ); ?>
                            </span>
                            <div class="text-right">
                                <?php if ( $planet->visible ) : ?>
                                    <span class="text-slate-200 font-medium"><?php echo esc_html( round( $planet->altitude ) ); ?>° altitude</span>
                                    <?php if ( $planet->constellation ) : ?>
                                        <span class="block text-xs text-slate-400 mt-1">in <?php echo esc_html( $planet->constellation ); ?></span>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <span class="text-slate-500 text-sm">Below horizon</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else : ?>
        <p class="bg-red-900/50 border border-red-700 rounded p-6 text-red-200">Unable to retrieve planet data.</p>
    <?php endif; ?>

</div>