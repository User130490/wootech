<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (! file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

try {
    \Roots\bootloader();
} catch (Throwable $e) {
    wp_die(
        __('You need to install Acorn to use this theme.', 'sage'),
        '',
        [
            'link_url' => 'https://docs.roots.io/acorn/2.x/installation/',
            'link_text' => __('Acorn Docs: Installation', 'sage'),
        ]
    );
}

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect(['setup', 'filters'])
    ->each(function ($file) {
        if (! locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
                /* translators: %s is replaced with the relative file path */
                sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
            );
        }
    });

/*
|--------------------------------------------------------------------------
| Enable Sage Theme Support
|--------------------------------------------------------------------------
|
| Once our theme files are registered and available for use, we are almost
| ready to boot our application. But first, we need to signal to Acorn
| that we will need to initialize the necessary service providers built in
| for Sage when booting.
|
*/

add_theme_support('sage');


/*
|--------------------------------------------------------------------------
| ACF OPTIONS PAGE
|--------------------------------------------------------------------------
*/
if( function_exists('acf_add_options_page')){

    acf_add_options_page(
        array(
            'page_title' => 'Options page',
            'menu_title' => 'Options page',
            'menu_slug' => 'option-page',
            'capability' => 'edit_posts',
            'icon_url' => 'dashicons-admin-tools'
        )
    );

/*
|--------------------------------------------------------------------------
| IF WE NEED A SUBPAGE
|--------------------------------------------------------------------------
*/
// 
// acf_add_options_sub_page(
//     array(
//         'page_title' => 'Settings Page 1',
//         'menu_title' => 'Settings Page 1',
//         'parent_slug' => 'option-page'
//     )
// );


}

/*
|--------------------------------------------------------------------------
| CUSTOM POST TYPE TESTIMONIALS
|--------------------------------------------------------------------------
*/
function custom_post_type() {
  
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => 'Testimonials', 'Post Type General Name',
        'singular_name'       => 'Testimonial', 'Post Type Singular Name',
        'menu_name'           => 'Testimonials'
    );
      
// Set other options for Custom Post Type
      
    $args = array(
        'label'               => 'Testimonial',
        'description'         => 'Testimonial',
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title','custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'testimonials' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true
  
    );
      
    // Registering your Custom Post Type
    register_post_type( 'testimonials', $args );
  
}
  
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
add_action( 'init', 'custom_post_type', 0 );

/*
|--------------------------------------------------------------------------
| THEME SUPPORT FOR WOOCOMMERCE
|--------------------------------------------------------------------------
*/
function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

/*
|--------------------------------------------------------------------------
| REORDER ADD TO CART BUTTON ON CONENT-SINGLE-PRODUCT.PHP
|--------------------------------------------------------------------------
*/
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 11 );

/*
|--------------------------------------------------------------------------
| REMOVE BILLING COMPANY FIELD IN CHECKOUT PAGE
|--------------------------------------------------------------------------
*/
add_filter( 'woocommerce_checkout_fields' , 'override_checkout_fields' );
    function override_checkout_fields( $fields ) {
    unset($fields["billing"]["billing_company"]);
    return $fields;
}

/*
|--------------------------------------------------------------------------
| REORDER BILLING COUNTRY FIELD UNDER BILLING ZIP CODE FIELD IN CHECKOUT PAGE
|--------------------------------------------------------------------------
*/
add_filter( 'woocommerce_checkout_fields', 'reorder_checkout_fields' );
function reorder_checkout_fields( $checkout_fields ) {
    $checkout_fields['billing']['billing_country']['priority'] = 91;
    return $checkout_fields;
}