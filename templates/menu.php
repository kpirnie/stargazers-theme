<?php
/**
 * Plugin Menu Template
 * 
 * @package US Stargazers Plugin
 */

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// Set flex classes based on inline vs vertical
$flex_class = $is_inline ? 'flex flex-wrap gap-4 justify-center' : 'flex flex-col space-y-2';
$list_style = $is_inline ? 'list-none' : 'list-disc list-inside';

// return the html string
echo <<<HTML
<nav class="border-b border-slate-700 mb-6 pb-4">
    <ul class="$flex_class $list_style">
        $the_menu
    </ul>
</nav>
HTML;