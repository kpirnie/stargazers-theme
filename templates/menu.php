<?php
/**
 * Plugin Menu Template
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// Set flex classes based on inline vs vertical
$flex_class = $is_inline ? 'flex flex-wrap gap-3 text-sm' : 'flex flex-col space-y-2';
$flex_class .= ( $text_align == 'right' ) ? ' text-right justify-end' : '';
$list_style = $is_inline ? 'list-none' : 'list-disc list-inside';

// return the html string
echo <<<HTML
    <ul class="$flex_class $list_style">
        $the_menu
    </ul>
HTML;