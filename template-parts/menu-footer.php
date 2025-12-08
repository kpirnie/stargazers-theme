<?php
/**
 * Template part for displaying the footer menu
 */
?>
<nav class="footer-navigation">
    <?php
    wp_nav_menu(array(
        'theme_location' => 'footer',
        'menu_class'     => 'flex flex-wrap justify-center gap-6',
        'container'      => false,
        'walker'         => new Stargazers_Footer_Walker_Nav_Menu(),
        'depth'          => 1,
    ));
    ?>
</nav>
