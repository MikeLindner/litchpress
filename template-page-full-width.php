<?php
/**
 * Template Name: Full width page
 *
 * A custom page template without sidebar.
 *
 */
get_header(); ?>

	<?php
	/* Run the page loop to output the page content.
	 */
	 get_template_part( 'loop', 'page' );
	?>

<?php get_footer(); ?>