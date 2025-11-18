<?php

/**
 * Template part for displaying pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package andstudio
 */

?>

<article data-scroll-transition="content" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content relative bg-neutral-white">
		<?php
		the_content();
		?>
	</div><!-- .entry-content -->

	<?php get_template_part('template-parts/layout/navigation-anchor') ?>

</article><!-- #post-<?php the_ID(); ?> -->