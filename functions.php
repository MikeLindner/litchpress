<?php
/**
 * litchpress Theme Functions
 *
 * @package litchpress
 * @since 0.03
 */

/**
 * Theme Setup - runs after theme is loaded
 */
function litchpress_setup() {
    // Add support for automatic title tag
    add_theme_support('title-tag');

    // Add support for post thumbnails (featured images)
    add_theme_support('post-thumbnails');

    // Set default thumbnail size (used by the_post_thumbnail())
    set_post_thumbnail_size(800, 450, true); // 16:9 aspect ratio, hard crop

    // Custom image sizes for blog posts
    add_image_size('blog-featured', 1200, 675, true);  // Large featured (16:9)
    add_image_size('blog-card', 600, 400, true);       // Card/grid view (3:2)
    add_image_size('blog-thumbnail', 300, 200, true);  // Small thumbnail (3:2)

    // Add support for HTML5 markup
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Register navigation menu locations
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'litchpress'),
        'footer'  => __('Footer Menu', 'litchpress'),
    ));

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Add support for custom background
    add_theme_support('custom-background', array(
        'default-color' => '444444',
    ));

    // Add WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'litchpress_setup');

/**
 * Enqueue scripts and styles
 */
function litchpress_scripts() {
    // Bootstrap CSS
    wp_enqueue_style(
        'bootstrap',
        get_stylesheet_directory_uri() . '/css/bootstrap.min.css',
        array(),
        '4.0.0'
    );

    // Main theme stylesheet
    wp_enqueue_style(
        'litchpress-style',
        get_stylesheet_uri(),
        array('bootstrap'),
        '0.03'
    );

    // Bootstrap JS (with Popper bundled)
    wp_enqueue_script(
        'bootstrap',
        get_stylesheet_directory_uri() . '/js/bootstrap.bundle.min.js',
        array('jquery'),
        '4.0.0',
        true // Load in footer
    );
}
add_action('wp_enqueue_scripts', 'litchpress_scripts');

/**
 * Register widget areas (sidebars)
 */
function litchpress_widgets_init() {
    register_sidebar(array(
        'name'          => __('Main Sidebar', 'litchpress'),
        'id'            => 'sidebar-main',
        'description'   => __('Widgets in this area will appear in the sidebar.', 'litchpress'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'litchpress_widgets_init');

/**
 * Add custom image sizes to the media uploader dropdown
 */
function litchpress_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'blog-featured'  => __('Blog Featured (1200×675)', 'litchpress'),
        'blog-card'      => __('Blog Card (600×400)', 'litchpress'),
        'blog-thumbnail' => __('Blog Thumbnail (300×200)', 'litchpress'),
    ));
}
add_filter('image_size_names_choose', 'litchpress_custom_image_sizes');

/**
 * Custom menu walker for simple inline nav (pipe-separated)
 */
class Litchpress_Inline_Nav_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $output .= '| <a href="' . esc_url($item->url) . '"';
        if ($item->target) {
            $output .= ' target="' . esc_attr($item->target) . '"';
        }
        $output .= '>' . esc_html($item->title) . '</a> ';
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        // No closing tag needed for inline style
    }

    function start_lvl(&$output, $depth = 0, $args = null) {
        // No nested lists for inline nav
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        // No nested lists for inline nav
    }
}

/**
 * Fallback menu if no menu assigned
 */
function litchpress_fallback_menu() {
    echo '| <a href="' . esc_url(home_url('/')) . '">Home</a> |';
}
