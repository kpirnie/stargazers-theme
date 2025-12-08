<?php
/**
 * Custom search form template
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="flex-grow">
        <span class="screen-reader-text"><?php _e('Search for:', 'stargazers'); ?></span>
        <input type="search" 
               class="search-field" 
               placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'stargazers'); ?>" 
               value="<?php echo get_search_query(); ?>" 
               name="s" />
    </label>
    <input type="submit" 
           class="search-submit" 
           value="<?php echo esc_attr_x('Search', 'submit button', 'stargazers'); ?>" />
</form>
