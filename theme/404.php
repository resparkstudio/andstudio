<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package andstudio
 */

$parent_page = andstudio_get_parent_page_from_url();

get_header();
?>

<section id="primary" class="min-h-screen bg-neutral-grey-1 pt-34 md:flex md:w-full">
	<main id="main" class="md:w-full">
		<div class="container md:px-18 md:h-full md:pb-18">
			<div class="bg-neutral-white py-11 px-5 rounded-lg text-center md:h-full md:flex md:flex-col md:justify-center md:items-center md:rounded-xl">
				<span class="text-body-s"><?php _e('Error 404', 'andstudio') ?></span>
				<h1 class="mt-4 text-h2 text-[2.75rem] md:mt-6 md:text-[5rem]"><?php _e('Page Not Found', 'andstudio') ?></h1>
				<p class="text-body-s mt-8 max-w-65.5 mx-auto md:max-w-94.5"><?php _e('Oops! The page you’re looking for doesn’t seem to exist. It might have been moved or deleted.', 'andstudio') ?></p>

				<?php if ($parent_page) : ?>
					<a class="bg-brand-primary text-neutral-white mt-12 rounded-lg p-5 block md:px-6 md:py-3.5 md:hover:bg-brand-secondary md:hover:text-neutral-black md:transition-colors md:duration-200" href="<?php echo esc_url(get_page_link($parent_page->ID)) ?>"><?php _e('Go to Dashboard', 'andstudio') ?></a>
				<?php endif ?>
			</div>
		</div>
	</main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();
