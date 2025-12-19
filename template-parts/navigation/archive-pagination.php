<?php
/**
 * Template part for displaying pagination
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

$pagination = paginate_links( array(
    'mid_size'  => 2,
    'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>',
    'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
    'type'      => 'array',
) );

if ($pagination) :
?>
    <nav class="pagination container mx-auto px-4 py-8" role="navigation">
        <div class="nav-links flex flex-wrap justify-center gap-2">
            <?php foreach ($pagination as $page) : ?>
                <div class="page-numbers">
                    <?php
                    $page = str_replace('page-numbers', 'px-4 py-2 bg-slate-800 text-slate-200 rounded-lg hover:bg-cyan-600 hover:text-white transition-colors border border-slate-700', $page);
                    $page = str_replace('current', 'px-4 py-2 bg-cyan-600 text-white rounded-lg border border-cyan-500', $page);
                    echo $page;
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </nav>
<?php
endif;
