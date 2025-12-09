<?php
/**
 * Template part for displaying page content
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('container mx-auto px-4 py-6'); ?>>
    
    <div class="entry-content prose prose-invert prose-slate prose-lg max-w-none">
        <?php
            the_content();
        ?>
    </div>
    
</article>
