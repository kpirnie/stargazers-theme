<?php
/**
 * Template part for displaying the footer
 */
?>
<footer id="colophon" class="site-footer bg-slate-950 border-t border-slate-800 mt-auto">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Footer Menu -->
        <div class="footer-menu mb-6">
            <?php get_template_part('template-parts/menu-footer'); ?>
        </div>
        
        <!-- Footer Info -->
        <div class="footer-info text-center text-sm text-slate-500 border-t border-slate-800 pt-6">
            <p>Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
            <p class="mt-2">
                Developed and Maintained by <a href="https://kevinpirnie.com" class="text-cyan-400 hover:text-cyan-300 transition-colors" target="_blank" rel="noopener">Kevin Pirnie</a>
            </p>
        </div>
        
    </div>
</footer>
