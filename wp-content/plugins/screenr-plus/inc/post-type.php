<?php
add_action( 'init', 'codex_portfolio_init' );
/**
 * Register a portfolio post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_portfolio_init() {

    $slug  = get_theme_mod( 'portfolios_slug', 'portfolio' );
    if ( ! $slug ) {
        $slug = 'portfolio';
    }

    $labels = array(
        'name'               => _x( 'Portfolios', 'post type general name', 'screenr-plus' ),
        'singular_name'      => _x( 'Portfolio', 'post type singular name', 'screenr-plus' ),
        'menu_name'          => _x( 'Portfolios', 'admin menu', 'screenr-plus' ),
        'name_admin_bar'     => _x( 'Portfolio', 'add new on admin bar', 'screenr-plus' ),
        'add_new'            => _x( 'Add New', 'portfolio', 'screenr-plus' ),
        'add_new_item'       => __( 'Add New Portfolio', 'screenr-plus' ),
        'new_item'           => __( 'New Portfolio', 'screenr-plus' ),
        'edit_item'          => __( 'Edit Portfolio', 'screenr-plus' ),
        'view_item'          => __( 'View Portfolio', 'screenr-plus' ),
        'all_items'          => __( 'All Portfolios', 'screenr-plus' ),
        'search_items'       => __( 'Search Portfolios', 'screenr-plus' ),
        'parent_item_colon'  => __( 'Parent Portfolios:', 'screenr-plus' ),
        'not_found'          => __( 'No portfolios found.', 'screenr-plus' ),
        'not_found_in_trash' => __( 'No portfolios found in Trash.', 'screenr-plus' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => $slug ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail' )
    );

    register_post_type( 'portfolio', $args );

    // Portfolio category
    $labels = array(
        'name'                       => _x( 'Categories', 'taxonomy general name', 'screenr-plus' ),
        'singular_name'              => _x( 'Category', 'taxonomy singular name', 'screenr-plus' ),
        'search_items'               => __( 'Search Categories', 'screenr-plus' ),
        'popular_items'              => __( 'Popular Categories', 'screenr-plus' ),
        'all_items'                  => __( 'All Categories', 'screenr-plus' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Edit Category', 'screenr-plus' ),
        'update_item'                => __( 'Update Category', 'screenr-plus' ),
        'add_new_item'               => __( 'Add New Category', 'screenr-plus' ),
        'new_item_name'              => __( 'New Category Name', 'screenr-plus' ),
        'separate_items_with_commas' => __( 'Separate categories with commas', 'screenr-plus' ),
        'add_or_remove_items'        => __( 'Add or remove categories', 'screenr-plus' ),
        'choose_from_most_used'      => __( 'Choose from the most used categories', 'screenr-plus' ),
        'not_found'                  => __( 'No categories found.', 'screenr-plus' ),
        'menu_name'                  => __( 'Categories', 'screenr-plus' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => false,
        'rewrite'               => array( 'slug' => 'portfolio_cat' ),
    );

    register_taxonomy( 'portfolio_cat', 'portfolio', $args );

}


