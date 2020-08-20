<?php

class Widgets
{
    /**
     * Initialization
     * This method should be run from functions.php
     */
    public function __construct()
    {
        add_action('widgets_init', [__CLASS__, 'register_widgets']);
}

    /**
     * Register Widgets For Wordpress
     */
    public static function register_widgets()
    {
        if (function_exists('register_sidebar')):

            register_sidebar(array(
                'name' => 'Header Navigation',
                'id' => 'widget-header-navigation',
                'before_widget' => '<div class="header__widget-header-navigation d-none d-md-block">',
                'after_widget' => '</div>',
            ));

            register_sidebar(array(
                'name' => 'Mobile Menu (Before)',
                'id' => 'widget-mobile-menu-before',
                'before_widget' => '<div class="header__mobile-nav-widget-before">',
                'after_widget' => '</div>',
            ));

            register_sidebar(array(
                'name' => 'Mobile Menu (After)',
                'id' => 'widget-mobile-menu-after',
                'before_widget' => '<div class="header__mobile-nav-widget-after">',
                'after_widget' => '</div>',
            ));

            register_sidebar(array(
                'name' => 'Footer Column 1',
                'id' => 'widget-footer-1',
                'before_widget' => '<div class="footer__widget-1">',
                'after_widget' => '</div>',
            ));

            register_sidebar(array(
                'name' => 'Footer Column 2',
                'id' => 'widget-footer-2',
                'before_widget' => '<div class="footer__widget-2">',
                'after_widget' => '</div>',
            ));

            register_sidebar(array(
                'name' => 'Footer Column 3',
                'id' => 'widget-footer-3',
                'before_widget' => '<div class="footer__widget-3">',
                'after_widget' => '</div>',
            ));

            register_sidebar(array(
                'name' => 'Footer Column 4',
                'id' => 'widget-footer-4',
                'before_widget' => '<div class="footer__widget-4">',
                'after_widget' => '</div>',
            ));

            register_sidebar(array(
                'name' => 'Footer Disclaimer Section',
                'id' => 'widget-footer-5',
                'before_widget' => '<div class="footer__widget-5">',
                'after_widget' => '</div>',
            ));

        endif;
    }
}
