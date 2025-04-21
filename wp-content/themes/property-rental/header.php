<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <!-- Logo / Site Title -->
    <?php if ( function_exists('the_custom_logo') && has_custom_logo() ) : ?>
      <div class="navbar-brand">
        <?php the_custom_logo(); ?>
      </div>
    <?php else : ?>
      <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
        <?php bloginfo('name'); ?>
      </a>
    <?php endif; ?>

    <!-- Mobile Toggle Button -->
    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#primaryMenu"
            aria-controls="primaryMenu"
            aria-expanded="false"
            aria-label="<?php esc_attr_e('Toggle navigation', 'property-rental'); ?>">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="primaryMenu">
        <?php
            wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'navbar-nav ms-auto',
            'fallback_cb'    => false,
            'depth'          => 2,
            ]);
        ?>
    </div>
  </div>
</header>

<main class="site-main container py-4">
