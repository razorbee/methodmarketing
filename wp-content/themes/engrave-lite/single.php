<?php
/**
 * The Template for displaying all single posts.
 *
 * @package ThinkUpThemes
 */

get_header(); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?>

				<?php thinkup_input_nav( 'nav-below' ); ?>

				<?php /* Add Author Bio */ thinkup_input_postauthorbio(); ?>

				<?php thinkup_input_allowcomments(); ?>

			<?php endwhile; wp_reset_postdata(); ?>

<?php get_footer(); ?>