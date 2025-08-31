<?php
/**
 * Custom post type definitions.
 *
 * @package Petslets
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Register Success Story post type.
 */
function petslets_register_success_story_cpt() {
    $labels = array(
        'name'               => _x( 'Success Stories', 'post type general name' ),
        'singular_name'      => _x( 'Success Story', 'post type singular name' ),
        'add_new'            => _x( 'Add New', 'success story' ),
        'add_new_item'       => __( 'Add New Success Story' ),
        'edit_item'          => __( 'Edit Success Story' ),
        'new_item'           => __( 'New Success Story' ),
        'all_items'          => __( 'All Success Stories' ),
        'view_item'          => __( 'View Success Stories' ),
        'search_items'       => __( 'Search Success Stories' ),
        'not_found'          => __( 'No Success Stories found' ),
        'not_found_in_trash' => __( 'No Success Stories found in Trash' ),
        'menu_name'          => __( 'Success Stories' ),
    );

    $args = array(
        'labels'       => $labels,
        'description'  => 'Our Success Stories',
        'public'       => true,
        'menu_position'=> 5,
        'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
        'has_archive'  => true,
        'menu_icon'    => 'dashicons-text-page',
        'show_in_rest' => true,
    );

    register_post_type( 'success-story', $args );
}
add_action( 'init', 'petslets_register_success_story_cpt' );

