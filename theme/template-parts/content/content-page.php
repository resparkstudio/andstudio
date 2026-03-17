<?php

/**
 * Template part for displaying pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package andstudio
 */

?>

<article class="relative" data-scroll-transition="content" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if (get_field('enable_hero')) : ?>
		<?php get_template_part('template-parts/content/hero') ?>
	<?php endif ?>

	<div data-hero-scroll="content-wrap" class="bg-neutral-grey-1 rounded-t-lg md:rounded-t-xl relative z-10 origin-top will-change-transform">
		<div class="entry-content relative">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</div>

	<?php get_template_part('template-parts/layout/navigation-anchor') ?>

	<?php if (get_field('enable_footer_transition')) : ?>
		<?php get_template_part('template-parts/content/footer-transition') ?>
	<?php endif ?>

</article><!-- #post-<?php the_ID(); ?> -->