<?php
/**
 * Template part for displaying the header menu
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>
<nav id="site-navigation" class="main-navigation">
    <?php
    wp_nav_menu(array(
        'theme_location' => 'primary',
        'menu_class'     => 'flex space-x-1',
        'container'      => false,
        'walker'         => new Stargazers_Walker_Nav_Menu(),
    ));
    ?>
</nav>
