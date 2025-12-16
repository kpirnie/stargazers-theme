<?php
/**
 * The header template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/wp-content/themes/sgu/assets/stargazers_us-favicon.svg">
    <link rel="alternate icon" type="image/webp" href="/wp-content/themes/sgu/assets/stargazers_us-favicon.webp">
    <link rel="apple-touch-icon" href="/wp-content/themes/sgu/assets/stargazers_us-favicon.webp">
</head>

<body <?php body_class('bg-slate-900 text-slate-200'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site min-h-screen flex flex-col">
    
    <header id="masthead" class="site-header bg-slate-950 border-b border-slate-800 sticky top-0 z-40">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                
                <!-- Logo/Site Title -->
                <div class="site-branding">
                    <a href="<?php echo home_url('/'); ?>" class="header-logo">
                        <?php
                            // get the SVG content for my logo
                            echo file_get_contents( ABSPATH . '/wp-content/themes/sgu/assets/stargazers_us-logo.svg' );
                        ?>
                    </a>
                </div>
                
                <!-- Mobile Menu Toggle -->
                <button id="mobile-menu-toggle" class="lg:hidden text-slate-200 hover:text-cyan-400 focus:outline-none" aria-label="Toggle Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <!-- Primary Navigation -->
                <nav id="site-navigation" class="main-navigation hidden lg:block">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'flex space-x-1',
                        'container'      => false,
                        'walker'         => new Stargazers_Walker_Nav_Menu(),
                    ));
                    ?>
                </nav>
                
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden lg:hidden pb-4">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'flex flex-col space-y-2',
                    'container'      => false,
                    'link_before'    => '<span class="block px-4 py-2 text-slate-200 hover:text-cyan-400 hover:bg-slate-800 rounded transition-colors">',
                    'link_after'     => '</span>',
                ));
                ?>
            </div>
        </div>
    </header>
    <?php if( ! is_front_page( ) ) { ?>
    <div class="breadcrumbs-container bg-slate-900 border-b border-slate-800">
        <div class="container mx-auto px-4 py-3">
            <?php 

                // if we're in a posts page
                if (function_exists( 'yoast_breadcrumb') && ( ! is_page( ) && ! in_array( $post -> post_type, [ 'sgu_apod', 'sgu_neo' ] ) ) ) {
                    yoast_breadcrumb( '<nav class="text-sm text-slate-400">', '</nav>' ); 
                } else {
                ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php
                        // we want to put in the alert-menu left aligned to the container
                        echo do_shortcode( '[sgup_astro_menu which="alert-menu" is_inline="true" text_align="left"]' );
                        ?>
                        <?php
                        // we want to put in the alert-menu right aligned to the container
                        echo do_shortcode( '[sgup_astro_menu which="astro-menu" is_inline="true" text_align="right"]' );
                        ?>
                    </div>
                <?php
                }
                
            ?>
        
        </div>
    </div>
    <?php } ?>
    <div id="content" class="site-content flex-grow">
