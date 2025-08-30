<?php
/*
 * This is the child theme for Astra theme, generated with Generate Child Theme plugin by catchthemes.
 *
 * (Please see https://developer.wordpress.org/themes/advanced-topics/child-themes/#how-to-create-a-child-theme)
 */
add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_styles' );
function astra_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}
/*
 * Your code goes below
 */

// Showroom Post Type
 function success_story_posts() {
   $labels = array(
     'name'               => _x( 'Success Story', 'post type general name' ),
     'singular_name'      => _x( 'Success Story', 'post type singular name' ),
     'add_new'            => _x( 'Add New', 'Success Story' ),
     'add_new_item'       => __( 'Add New Success Story' ),
     'edit_item'          => __( 'Edit Success Story' ),
     'new_item'           => __( 'New Success Story' ),
     'all_items'          => __( 'All Success Stories' ),
     'view_item'          => __( 'View Success Stories' ),
     'search_items'       => __( 'Search Success Stories' ),
     'not_found'          => __( 'No Success Stories found' ),
     'not_found_in_trash' => __( 'No Success Stories found in the Trash' ), 
     'parent_item_colon'  => '',
     'menu_name'          => 'Success Stories'
   );
   $args = array(
     'labels'        => $labels,
     'description'   => 'Our Success Stories',
     'public'        => true,
     'menu_position' => 5,
     'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
     'has_archive'   => true,
     'menu_icon' 	=> 'dashicons-text-page',
   );
   register_post_type( 'success-story', $args ); 
 }
 add_action( 'init', 'success_story_posts' );