<?php
/**
 * The template for displaying comments
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area container mx-auto px-4 py-8 mt-8 bg-slate-900 rounded-lg border border-slate-700">
    
    <?php if (have_comments()) : ?>
        <h2 class="comments-title text-2xl font-heading font-bold text-cyan-400 mb-6">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    esc_html__('One comment on &ldquo;%s&rdquo;', 'stargazers'),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf(
                    esc_html(_nx(
                        '%1$s comment on &ldquo;%2$s&rdquo;',
                        '%1$s comments on &ldquo;%2$s&rdquo;',
                        $comment_count,
                        'comments title',
                        'stargazers'
                    )),
                    number_format_i18n($comment_count),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2>
        
        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 60,
            ));
            ?>
        </ol>
        
        <?php
        the_comments_navigation(array(
            'prev_text' => '<span class="nav-subtitle">' . __('Previous Comments', 'stargazers') . '</span>',
            'next_text' => '<span class="nav-subtitle">' . __('Next Comments', 'stargazers') . '</span>',
        ));
        ?>
        
        <?php if (!comments_open()) : ?>
            <p class="no-comments text-slate-400 mt-6">
                <?php _e('Comments are closed.', 'stargazers'); ?>
            </p>
        <?php endif; ?>
        
    <?php endif; ?>
    
    <?php
    comment_form(array(
        'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title text-2xl font-heading font-bold text-cyan-400 mb-6">',
        'title_reply_after'  => '</h3>',
    ));
    ?>
    
</div>
