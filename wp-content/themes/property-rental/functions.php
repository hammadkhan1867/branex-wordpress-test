<?php
function pr_enqueue_assets() {
  // Bootstrap CSS (optional; swap for Tailwind if you prefer)
  wp_enqueue_style(
    'pr-bootstrap',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
    [],
    '5.3.3'
  );

  // Theme stylesheet
  wp_enqueue_style(
    'pr-style',
    get_stylesheet_uri(),
    ['pr-bootstrap'], 
    filemtime( get_stylesheet_directory() . '/style.css' )
  );

  // Bootstrap JS bundle (requires Popper + Bootstrap JS)
  wp_enqueue_script(
    'pr-bootstrap-js',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
    ['jquery'],
    '5.3.3',
    true
  );

  // Main JS placeholder
  wp_enqueue_script(
    'pr-main-js',
    get_template_directory_uri() . '/assets/js/main.js',
    ['jquery'],
    filemtime( get_template_directory() . '/assets/js/main.js' ),
    true
  );
}
add_action( 'wp_enqueue_scripts', 'pr_enqueue_assets' );

add_action('after_setup_theme', function() {
    // Custom Logo
    add_theme_support('custom-logo', [
      'height'      => 60,
      'width'       => 200,
      'flex-height' => true,
      'flex-width'  => true,
    ]);

    // Primary menu
    register_nav_menus([
      'primary' => __('Primary Menu', 'property-rental'),
    ]);

    // Featured image support for property CPT
    add_theme_support('post-thumbnails', ['property']);
});

// Enqueue Bootstrap + theme assets
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('pr-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', [], '5.3.3');
    wp_enqueue_style('pr-style', get_stylesheet_uri(), ['pr-bootstrap'], filemtime(get_stylesheet_directory() . '/style.css'));
    wp_enqueue_script('pr-bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', ['jquery'], '5.3.3', true);
    wp_enqueue_script('pr-main-js', get_template_directory_uri() . '/assets/js/main.js', ['jquery'], filemtime(get_template_directory() . '/assets/js/main.js'), true);
});

// Disable Gutenberg on property CPT so ACF shows classic meta‐boxes
add_filter('use_block_editor_for_post_type', function($use, $post_type) {
    return $post_type === 'property' ? false : $use;
}, 10, 2);

// Add 'nav-item' to each <li> in the Primary Menu
add_filter( 'nav_menu_css_class', function( $classes, $item, $args ) {
    if ( isset($args->theme_location) && $args->theme_location === 'primary' ) {
        $classes[] = 'nav-item';
    }
    return $classes;
}, 10, 3 );

// Add 'nav-link' to each <a> in the Primary Menu
add_filter( 'nav_menu_link_attributes', function( $atts, $item, $args ) {
    if ( isset($args->theme_location) && $args->theme_location === 'primary' ) {
        $atts['class'] = 'nav-link';
    }
    return $atts;
}, 10, 3 );

// 1) Register 'property' CPT
if (! function_exists('pr_register_property_cpt')) {
  function pr_register_property_cpt() {
      $labels = [
        'name'               => __('Properties','property-rental'),
        'singular_name'      => __('Property','property-rental'),
        'add_new_item'       => __('Add New Property','property-rental'),
        'edit_item'          => __('Edit Property','property-rental'),
        'all_items'          => __('All Properties','property-rental'),
        'menu_name'          => __('Properties','property-rental'),
      ];
      $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug'=>'properties'],
        'menu_icon'          => 'dashicons-admin-home',
        'supports'           => ['title','editor','thumbnail','excerpt','custom-fields'],
        'show_in_rest'       => true,
      ];
      register_post_type('property',$args);
  }
  add_action('init','pr_register_property_cpt');
}

// 2) Register 'home_type' taxonomy
if (! function_exists('pr_register_home_type_taxonomy')) {
  function pr_register_home_type_taxonomy() {
      $labels = [
        'name'           => __('Home Types','property-rental'),
        'singular_name'  => __('Home Type','property-rental'),
        'menu_name'      => __('Home Types','property-rental'),
      ];
      $args = [
        'labels'        => $labels,
        'hierarchical'  => true,
        'public'        => true,
        'rewrite'       => ['slug'=>'home-type'],
        'show_in_rest'  => true,
      ];
      register_taxonomy('home_type','property',$args);
  }
  add_action('init','pr_register_home_type_taxonomy');
}

