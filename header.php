<?php
/**
 * The header for Astra Theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<?php astra_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
<?php astra_head_top(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>	
	

<script>	
	$(window).scroll(function(){
		if ($(this).scrollTop() > 10) {
		   $('.ts-header').addClass('add_bg_color');
		}
		else {
       $('.ts-header').removeClass('add_bg_color');
		}
	});	
	
	$(document).ready(function() {
 	  var lastScroll = 0;
	  jQuery(document).ready(function($) {
		$(window).scroll(function() {
		  setTimeout(function() {
			//gives 100ms to finish scrolling before doing a check
			var scroll = $(window).scrollTop() > 600;
			if (scroll > lastScroll) {
			  $(".ts-header").addClass("shift");
			} else if (scroll < lastScroll) {
			  $(".ts-header").removeClass("shift");
			}
 			lastScroll = scroll;
		  }, 100);
		});
	  });
	});
	
	// Hide header on scroll down
jQuery(document).ready(function() {
var lastScroll = 0;
var isScrolled = false;
window.addEventListener("scroll", function () {
  var topHeader = document.querySelector(".ts-header");
  var currentScroll =
    window.pageYOffset ||
    document.documentElement.scrollTop ||
    document.body.scrollTop ||
    0;
  var scrollDirection = currentScroll < lastScroll;
  var shouldToggle = isScrolled && scrollDirection;
  isScrolled = currentScroll > 200;
  topHeader.classList.toggle("active", shouldToggle);
  lastScroll = currentScroll;
});

  });

// Hide header on scroll down
</script>
<?php wp_head(); ?>
<?php astra_head_bottom(); ?>
</head>

<body <?php astra_schema_body(); ?> <?php body_class(); ?>>
<?php astra_body_top(); ?>
<?php wp_body_open(); ?>

<div
<?php
	echo astra_attr(
		'site',
		array(
			'id'    => 'page',
			'class' => 'hfeed site',
		)
	);
	?>
>
	<?php
	astra_header_before();

	astra_header();

	astra_header_after();

	astra_content_before();
	?>
	<div id="content" class="site-content">
		<div class="ast-container">
		<?php astra_content_top(); ?>
			

			
			
			
