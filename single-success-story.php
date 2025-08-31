<?php
/**
 * The template for displaying Success Story posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

get_header();

get_template_part( 'template-parts/content', 'success-story' );

get_footer();

