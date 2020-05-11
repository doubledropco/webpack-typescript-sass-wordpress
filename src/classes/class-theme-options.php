<?php

class Theme_Options
{
    /**
     * Initialization
     * This method should be run from functions.php
     */
    public function __construct()
    {
        add_action('acf/init', [__CLASS__, 'add_options_page']);
        add_action('acf/init', [__CLASS__, 'add_google_maps_api_key']);
    }

    /**
     * ACF Options Page
     */
    public static function add_options_page()
    {
        if (function_exists('acf_add_options_page')) {

            acf_add_options_page(array(
                'page_title' => 'Theme Options',
                'menu_title' => 'Theme Options',
                'menu_slug' => 'theme-options',
                'icon_url' => 'dashicons-admin-settings',
                'position' => 2,
                'capability' => 'activate_plugins',
            ));
        }
    }

    /**
     * ACF Google Maps API Key
     */
    public static function add_google_maps_api_key()
    {
        if (function_exists('acf_update_setting')) {
            $google_maps_api_key = get_field('google_maps_api_key', 'option');
            acf_update_setting('google_api_key', $google_maps_api_key);
        }
    }
}
