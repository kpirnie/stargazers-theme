<?php
/**
 * The template for displaying single posts
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while (have_posts()) :
        the_post();
        
        get_template_part('template-parts/content', 'post');
        
        // Post navigation
        the_post_navigation(array(
            'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'stargazers') . '</span> <span class="nav-title">%title</span>',
            'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'stargazers') . '</span> <span class="nav-title">%title</span>',
            'screen_reader_text' => __('Post navigation', 'stargazers'),
        ));
        
    endwhile;
    ?>
</main>

<?php
get_footer();
