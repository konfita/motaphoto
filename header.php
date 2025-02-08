<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="page">
        <header id="header" class="site-header">
            <div class="logo-container">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png" alt="Logo du site">
                </a>
            </div>
            <button id="menu-toggle" class="menu-toggle" aria-label="Menu">
                <span class="hamburger"></span>
            </button>
            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                ));
                ?>
                <ul>
                    <li><a href="#" id="contactLink" class="open-contact-modal">CONTACT</a></li>
                </ul>
            </nav>
            <div class="mobile-menu-overlay">
                <button class="menu-close">Fermer</button>
            </div>
            <!-- Modale de contact  -->
            <?php get_template_part('modale'); ?>
        </header>
        <main id="main" class="site-main">