<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Open Graph / Social Media -->
    <meta property="og:title" content="<?php bloginfo('name'); ?>" />
    <meta property="og:description" content="<?php bloginfo('description'); ?>">
    <meta property="og:image" content="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/images/og-image.png" />
    <meta property="og:url" content="<?php echo esc_url(home_url('/')); ?>">
    <meta property="og:type" content="website">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/images/favicon.png">
    <link rel="apple-touch-icon" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/images/favicon.png">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <div id="ttr_header" class="jumbotron">
        <h1><a href="<?php echo esc_url(home_url('/')); ?>">mikelindner.com</a></h1>
        <i><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('description'); ?></a></i>
        <br><br>

        <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Menu', 'litchpress'); ?>">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '%3$s|',
                'walker'         => new Litchpress_Inline_Nav_Walker(),
                'fallback_cb'    => 'litchpress_fallback_menu',
                'depth'          => 1,
            ));
            ?>
        </nav>

    </div>
    <div class="container">


