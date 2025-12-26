<?php
/**
 * Blog Sidebar
 * 
 * @package Stargazers Theme
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>

<div class="sticky top-[10rem] space-y-6">
    
    <!-- Search -->
    <div class="bg-slate-800 border border-slate-700 p-4 rounded-lg">
        <h3 class="text-lg font-heading font-bold text-cyan-400 mb-4 pb-2 border-b border-slate-700">Search Blog</h3>
        <?php get_search_form(); ?>
    </div>

    <!-- Categories -->
    <?php
    $categories = get_categories( array(
        'orderby' => 'count',
        'order'   => 'DESC',
        //'number'  => -1,
    ) );
    
    if ( $categories ) :
    ?>
    <div class="bg-slate-800 border border-slate-700 p-4 rounded-lg">
        <h3 class="text-lg font-heading font-bold text-cyan-400 mb-4 pb-2 border-b border-slate-700">Categories</h3>
        <ul class="space-y-2">
            <?php foreach ( $categories as $category ) : ?>
                <li>
                    <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" 
                       class="flex items-center justify-between text-slate-300 hover:text-cyan-400 transition-colors">
                        <span><?php echo esc_html( $category->name ); ?></span>
                        <span class="text-xs bg-slate-900 px-2 py-1 rounded"><?php echo esc_html( $category->count ); ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <!-- Popular Tags -->
    <?php
    $tags = get_tags( array(
        'orderby' => 'count',
        'order'   => 'DESC',
        //'number'  => 20,
    ) );
    
    if ( $tags ) :
    ?>
    <div class="bg-slate-800 border border-slate-700 p-4 rounded-lg">
        <h3 class="text-lg font-heading font-bold text-cyan-400 mb-4 pb-2 border-b border-slate-700">Popular Tags</h3>
        <div class="flex flex-wrap gap-2">
            <?php foreach ( $tags as $tag ) : ?>
                <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" 
                   class="px-3 py-1 bg-slate-900 border border-slate-700 text-slate-300 text-sm rounded hover:bg-cyan-600 hover:text-white hover:border-cyan-500 transition-colors">
                    <?php echo esc_html( $tag->name ); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Recent Posts -->
    <?php
    $recent_posts = new WP_Query( array(
        'posts_per_page' => 5,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );
    
    if ( $recent_posts->have_posts() ) :
    ?>
    <div class="bg-slate-800 border border-slate-700 p-4 rounded-lg">
        <h3 class="text-lg font-heading font-bold text-cyan-400 mb-4 pb-2 border-b border-slate-700">Recent Posts</h3>
        <ul class="space-y-3">
            <?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>" class="group">
                        <h4 class="text-slate-300 group-hover:text-cyan-400 transition-colors text-sm font-medium mb-1">
                            <?php the_title(); ?>
                        </h4>
                        <p class="text-xs text-slate-500">
                            <?php echo get_the_date(); ?>
                        </p>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
    <?php
    wp_reset_postdata();
    endif;
    ?>

    <!-- Archive by Month -->
    <?php
    $archives = wp_get_archives( array(
        'type'            => 'monthly',
        'limit'           => 12,
        'format'          => 'custom',
        'echo'            => false,
        'show_post_count' => true,
    ) );

    if ( $archives ) : ?>
    <div class="bg-slate-800 border border-slate-700 p-4 rounded-lg">
        <h3 class="text-lg font-heading font-bold text-cyan-400 mb-4 pb-2 border-b border-slate-700">Archives</h3>
        <ul class="space-y-2 text-sm">
            <?php
            // Match all archive links with their counts
            // Handles both &nbsp; and regular spaces, and both quote styles
            preg_match_all(
                '/<a\s+href=[\'"]([^\'"]+)[\'"]>([^<]+)<\/a>(?:&nbsp;|\s)*\((\d+)\)/',
                $archives,
                $matches,
                PREG_SET_ORDER
            );
            
            foreach ( $matches as $match ) {
                $url   = $match[1];
                $text  = $match[2];
                $count = $match[3];
                ?>
                <li class="flex items-center justify-between">
                    <a href="<?php echo esc_url( $url ); ?>" class="text-slate-300 hover:text-cyan-400 transition-colors">
                        <?php echo esc_html( $text ); ?>
                    </a>
                    <span class="text-xs bg-slate-900 px-2 py-1 rounded">
                        <?php echo esc_html( $count ); ?>
                    </span>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
    <?php endif; ?>

</div>