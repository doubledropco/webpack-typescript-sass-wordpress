<?php

require get_template_directory() . '/classes/class-desktop-nav-walker.php';

require get_template_directory() . '/classes/class-mobile-nav-walker.php';

class Menus
{
    /**
     * Initialization
     * This method should be run from functions.php
     */
    public function __construct()
    {
        add_action('init', [__CLASS__, 'register_menus']);
}

    /**
     * Register Menus For Wordpress
     */
    public static function register_menus()
    {
        if (function_exists('register_nav_menus')):

            $locations = array(
                'primary-desktop' => __('Primary Desktop', 'wordpress-starter'),
                'primary-mobile' => __('Primary Mobile', 'wordpress-starter'),
            );
        
            register_nav_menus($locations);

        endif;
    }
}
