<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Webpack + Typescript + Sass + Wordpress
 * @since 1.0.0
 */

require get_template_directory() . '/classes/class-desktop-nav-walker.php';

require get_template_directory() . '/classes/class-mobile-nav-walker.php';

require get_template_directory() . '/classes/class-post-types.php';

require get_template_directory() . '/classes/class-theme-options.php';

require get_template_directory() . '/classes/class-widgets.php';

require get_template_directory() . '/classes/class-blocks.php';

new Post_Types();

new Theme_Options();

new Widgets();

new Blocks();

function theme_support()
{

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Set content-width.
    global $content_width;
    if ( ! isset($content_width)) {
        $content_width = 580;
    }

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    // Set post thumbnail size.
    set_post_thumbnail_size(1200, 9999);

    // Add custom image size used in Cover Template.
    add_image_size('fullscreen', 1980, 9999);

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'script',
            'style',
        )
    );

    // Make theme available for translation.
    load_theme_textdomain('wordpress-starter');

    // Add support for full and wide align images.
    add_theme_support('align-wide');

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    // Add theme support for custom colors
    add_theme_support('editor-color-palette', array(
        array(
            'name' => __('Teal', 'wordpress-starter'),
            'slug' => 'teal',
            'color' => '#008e88',
        ),
        array(
            'name' => __('Dark Grey', 'wordpress-starter'),
            'slug' => 'dark-grey',
            'color' => '#1c1d21',
        ),
    ));
}

add_action('after_setup_theme', 'theme_support');

/**
 * Register and Enqueue Styles.
 */
function register_styles()
{
    wp_enqueue_style('main', get_template_directory_uri() . '/static/main.css');
}

add_action('wp_enqueue_scripts', 'register_styles');

/**
 * Register and Enqueue Scripts.
 */
function register_scripts()
{
    wp_enqueue_script('main', get_template_directory_uri() . '/static/main.js');
    wp_enqueue_script('gsap', get_template_directory_uri() . '/assets/gsap.min.js');
    wp_enqueue_script('gsap-draw-svg', get_template_directory_uri() . '/assets/DrawSVGPlugin.min.js');
}

add_action('wp_enqueue_scripts', 'register_scripts');

/**
 * Register navigation menus uses wp_nav_menu in five places.
 */
function menus()
{

    $locations = array(
        'primary-desktop' => __('Primary Desktop', 'wordpress-starter'),
        'primary-mobile' => __('Primary Mobile', 'wordpress-starter'),
    );

    register_nav_menus($locations);
}

add_action('init', 'menus');

/**
 * Use custom ACF save point
 */
function acf_json_save_point($path)
{
    $path = get_stylesheet_directory() . '/../acf-json';
    return $path;
}

add_filter('acf/settings/save_json', 'acf_json_save_point');

/**
 * Use custom ACF load point
 */
function acf_json_load_point($paths)
{
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/../acf-json';
    return $paths;
}

add_filter('acf/settings/load_json', 'acf_json_load_point');

/**
 * Add support for custom mime types
 */
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');

/**
 * Output a bootstrap button withe extra classes or an icon added
 */
function button($link, $class = false, $icon = false)
{
    error_log($class);
    $className = 'btn';
    if ($class) {
        $className .= ' ' . $class;
    }
    ?>
        <a class="<?php echo $className; ?>" href="<?php echo $link['url']; ?>" <?php if (isset($link['target'])): ?>target="<?php echo $link['target']; ?>"<?php endif; ?>>
            <?php echo $link['title']; ?>

            <?php if ($icon): ?>
                <i class="<?php echo $icon; ?>"></i>
            <?php endif;?>
        </a>
    <?php
}

/**
 * Add styles to admin interface
 */
function admin_style()
{
    wp_enqueue_style('admin-styles', get_template_directory_uri() . '/admin.css');
}

add_action('admin_enqueue_scripts', 'admin_style');

/**
 * Print plugin dependencies
 */
function theme_dependencies () {
    if( ! is_plugin_active('advanced-custom-fields-pro/acf.php') && ! is_plugin_active('advanced-custom-fields/acf.php') ) {
        echo '<div class="error"><p>' . __( 'Warning: The Advanced Custom Fields plugin is required for this theme.', 'wordpress-starter' ) . '</p></div>';
    }
}
add_action( 'admin_notices', 'theme_dependencies' );
