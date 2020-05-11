<?php

class Blocks
{
    /**
     * Initialization
     * This method should be run from functions.php
     */
    public function __construct()
    {
        add_filter('block_categories', [__CLASS__, 'register_block_categories'], 10, 2);
        add_action('acf/init', [__CLASS__, 'register_blocks']);
    }

    /**
     * Register Block Categories
     */
    public static function register_block_categories($categories, $post)
    {
        return array_merge(
            array(
                array(
                    'slug' => 'custom-blocks',
                    'title' => __('Custom Blocks', 'custom-blocks'),
                ),
            ),
            $categories
        );
    }

    /**
     * Register ACF Blocks For Wordpress
     */
    public static function register_blocks()
    {
        if (function_exists('acf_register_block_type')):

            acf_register_block_type(array(
                'name' => 'hero',
                'title' => __('Hero'),
                'render_template' => 'template-parts/blocks/hero/hero.php',
                'category' => 'custom-blocks',
                'icon' => 'admin-site',
                'keywords' => array('hero', 'carousel'),
                'supports' => array(
                    'align' => false,
                ),
            ));

        endif;
    }
}
