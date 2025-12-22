<?php
/**
 * Plugin Menu Template
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// Generate unique ID for this menu instance
$menu_id = 'sgu-menu-' . uniqid();

// Extract label from $which variable if available
$menu_label = isset( $which ) ? strtoupper( str_replace( '-', ' ', str_replace( '-menu', '', $which ) ) ) . ':' : 'MENU:';

// Set flex classes based on inline vs vertical
$flex_class = $is_inline ? 'hidden md:flex flex-wrap gap-3 text-sm' : 'flex flex-col space-y-2';
$flex_class .= ( $text_align == 'right' ) ? ' md:text-right md:justify-end' : '';
$list_style = $is_inline ? 'list-none' : 'list-disc list-inside';

if( $is_inline ) {
    echo <<<HTML
    <div class="sgu-menu-container">
        <div class="md:hidden flex items-center justify-between">
            <span class="text-sm font-semibold text-slate-300">$menu_label</span>
            <button type="button" class="sgu-menu-toggle p-2 text-slate-300 hover:text-cyan-400 transition-colors" data-menu-target="$menu_id" aria-expanded="false" aria-label="Toggle menu">
                <svg class="w-5 h-5 sgu-menu-icon-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
                <svg class="w-5 h-5 sgu-menu-icon-close hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                </svg>
            </button>
        </div>
        <ul id="$menu_id" class="$flex_class $list_style sgu-collapsible-menu">
            $the_menu
        </ul>
    </div>
    HTML;
} else {
    echo <<<HTML
    <ul class="$flex_class $list_style">
        $the_menu
    </ul>
    HTML;
}