<?php
/**
 * Weather Alerts Template
 * 
 * Displays active NOAA weather alerts for the user's location
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// Severity color mapping
$severity_colors = [
    'Extreme' => 'bg-red-900 border-red-500 text-red-200',
    'Severe' => 'bg-red-800 border-red-500 text-red-200',
    'Moderate' => 'bg-yellow-900 border-yellow-500 text-yellow-200',
    'Minor' => 'bg-cyan-900 border-cyan-500 text-cyan-200',
    'Unknown' => 'bg-slate-700 border-slate-500 text-slate-300',
];

$severity_badges = [
    'Extreme' => 'bg-red-600 text-white',
    'Severe' => 'bg-red-500 text-white',
    'Moderate' => 'bg-yellow-500 text-slate-900',
    'Minor' => 'bg-cyan-500 text-slate-900',
    'Unknown' => 'bg-slate-500 text-white',
];

?>
<div class="sgu-weather-container sgu-weather-alerts-container my-6" data-weather-type="alerts">
    
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
        include locate_template( ['templates/weather/partials/location-picker.php'] );
        ?>
    <?php endif; ?>

    <!-- Weather Alerts Content -->
    <div class="sgu-weather-content">
        
        <?php if( ! $has_location ) : ?>
            <div class="sgu-weather-no-location bg-cyan-900/50 border border-cyan-700 rounded-lg p-4 text-cyan-200">
                <p>Please set your location to view weather alerts.</p>
            </div>
        <?php elseif( empty( $alerts ) ) : ?>
            <div class="bg-green-900/50 border border-green-700 rounded-lg p-4 text-green-200 flex items-center gap-3">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>No active weather alerts for your area.</span>
            </div>
        <?php else : ?>
            
            <div class="space-y-4">
                <?php foreach( $alerts as $index => $alert ) : 
                    $severity = $alert -> severity ?? 'Unknown';
                    $color_class = $severity_colors[ $severity ] ?? $severity_colors['Unknown'];
                    $badge_class = $severity_badges[ $severity ] ?? $severity_badges['Unknown'];
                    $urgency = $alert -> urgency ?? '';
                    $event = $alert -> event ?? 'Weather Alert';
                    $headline = $alert -> headline ?? '';
                    $description = $alert -> description ?? '';
                    $instruction = $alert -> instruction ?? '';
                    $effective = $alert -> effective ? date( 'M j, g:i A', strtotime( $alert -> effective ) ) : '';
                    $expires = $alert -> expires ? date( 'M j, g:i A', strtotime( $alert -> expires ) ) : '';
                    $sender = $alert -> senderName ?? 'National Weather Service';
                    $accordion_id = 'alert-' . $index . '-' . uniqid();
                ?>
                <div class="bg-slate-800 rounded-lg border border-slate-700 overflow-hidden">
                    <button 
                        class="w-full px-6 py-4 bg-slate-900 text-left flex justify-between items-center hover:bg-slate-800 transition-colors"
                        data-accordion-trigger="<?php echo esc_attr( $accordion_id ); ?>"
                    >
                        <div class="flex items-center gap-3">
                            <span class="<?php echo esc_attr( $badge_class ); ?> px-3 py-1 rounded-full text-sm font-semibold">
                                <?php echo esc_html( $severity ); ?>
                            </span>
                            <span class="text-lg font-heading font-semibold text-cyan-400"><?php echo esc_html( $event ); ?></span>
                        </div>
                        <div class="flex items-center gap-4">
                            <?php if( $urgency ) : ?>
                            <span class="text-sm text-slate-400"><?php echo esc_html( $urgency ); ?></span>
                            <?php endif; ?>
                            <svg class="w-5 h-5 text-cyan-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>
                    
                    <div id="<?php echo esc_attr( $accordion_id ); ?>" class="hidden">
                        <div class="p-6 space-y-4">
                            
                            <?php if( $headline ) : ?>
                            <div class="<?php echo esc_attr( $color_class ); ?> border rounded-lg p-4">
                                <strong><?php echo esc_html( $headline ); ?></strong>
                            </div>
                            <?php endif; ?>

                            <?php if( $effective || $expires ) : ?>
                            <div class="text-sm text-slate-400 flex flex-wrap gap-4">
                                <?php if( $effective ) : ?>
                                <span><strong class="text-slate-300">Effective:</strong> <?php echo esc_html( $effective ); ?></span>
                                <?php endif; ?>
                                <?php if( $expires ) : ?>
                                <span><strong class="text-slate-300">Expires:</strong> <?php echo esc_html( $expires ); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <?php if( $description ) : ?>
                            <div>
                                <h5 class="text-slate-200 font-semibold mb-2">Description</h5>
                                <pre class="whitespace-pre-wrap font-mono text-sm text-slate-300 bg-slate-900 p-4 rounded-lg border border-slate-700 overflow-x-auto"><?php echo esc_html( $description ); ?></pre>
                            </div>
                            <?php endif; ?>

                            <?php if( $instruction ) : ?>
                            <div>
                                <h5 class="text-slate-200 font-semibold mb-2 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Instructions
                                </h5>
                                <div class="bg-yellow-900/30 border border-yellow-700 rounded-lg p-4 text-yellow-200">
                                    <?php echo nl2br( esc_html( $instruction ) ); ?>
                                </div>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </div>

</div>