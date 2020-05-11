<?php

class Post_Types
{
    /**
     * Initialization
     * This method should be run from functions.php
     */
    public function __construct()
    {
        add_action('init', [__CLASS__, 'register_post_types']);
    }

    /**
     * Register Custom Post Types
     */
    public static function register_post_types() {}
}
