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

        <!-- Bouton du menu burger -->
        <button id="menu-toggle" class="menu-toggle" aria-label="Menu">
            <span class="hamburger"></span>
        </button>

        <!-- Navigation principale -->
        <nav id="site-navigation" class="main-navigation">
            <li><a href="<?= esc_url(home_url( '/' ) ); ?>">ACCUEIL</a></li>
            <li><a href="<?= esc_url(home_url( '/a-propos' ) ); ?>">A PROPOS</a></li>
            <li><a href="#" id="contactLink" class="open-contact-modal">CONTACT</a></li>
            
        </nav>

        <!-- Modale de contact  -->
        <?php get_template_part('modale'); ?>
    </header>
    <main id="main" class="site-main">
    <!-- … -->
