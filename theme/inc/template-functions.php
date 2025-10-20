<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package andstudio
 */

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function andstudio_pingback_header() {
	if (is_singular() && pings_open()) {
		printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
	}
}
add_action('wp_head', 'andstudio_pingback_header');

/**
 * Changes comment form default fields.
 *
 * @param array $defaults The default comment form arguments.
 *
 * @return array Returns the modified fields.
 */
function andstudio_comment_form_defaults($defaults) {
	$comment_field = $defaults['comment_field'];

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace('/rows="\d+"/', 'rows="5"', $comment_field);

	return $defaults;
}
add_filter('comment_form_defaults', 'andstudio_comment_form_defaults');

/**
 * Filters the default archive titles.
 */
function andstudio_get_the_archive_title() {
	if (is_category()) {
		$title = __('Category Archives: ', 'andstudio') . '<span>' . single_term_title('', false) . '</span>';
	} elseif (is_tag()) {
		$title = __('Tag Archives: ', 'andstudio') . '<span>' . single_term_title('', false) . '</span>';
	} elseif (is_author()) {
		$title = __('Author Archives: ', 'andstudio') . '<span>' . get_the_author_meta('display_name') . '</span>';
	} elseif (is_year()) {
		$title = __('Yearly Archives: ', 'andstudio') . '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'andstudio')) . '</span>';
	} elseif (is_month()) {
		$title = __('Monthly Archives: ', 'andstudio') . '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'andstudio')) . '</span>';
	} elseif (is_day()) {
		$title = __('Daily Archives: ', 'andstudio') . '<span>' . get_the_date() . '</span>';
	} elseif (is_post_type_archive()) {
		$cpt   = get_post_type_object(get_queried_object()->name);
		$title = sprintf(
			/* translators: %s: Post type singular name */
			esc_html__('%s Archives', 'andstudio'),
			$cpt->labels->singular_name
		);
	} elseif (is_tax()) {
		$tax   = get_taxonomy(get_queried_object()->taxonomy);
		$title = sprintf(
			/* translators: %s: Taxonomy singular name */
			esc_html__('%s Archives', 'andstudio'),
			$tax->labels->singular_name
		);
	} else {
		$title = __('Archives:', 'andstudio');
	}
	return $title;
}
add_filter('get_the_archive_title', 'andstudio_get_the_archive_title');

/**
 * Determines whether the post thumbnail can be displayed.
 */
function andstudio_can_show_post_thumbnail() {
	return apply_filters('andstudio_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail());
}

/**
 * Returns the size for avatars used in the theme.
 */
function andstudio_get_avatar_size() {
	return 60;
}

/**
 * Create the continue reading link
 *
 * @param string $more_string The string shown within the more link.
 */
function andstudio_continue_reading_link($more_string) {

	if (! is_admin()) {
		$continue_reading = sprintf(
			/* translators: %s: Name of current post. */
			wp_kses(__('Continue reading %s', 'andstudio'), array('span' => array('class' => array()))),
			the_title('<span class="sr-only">"', '"</span>', false)
		);

		$more_string = '<a href="' . esc_url(get_permalink()) . '">' . $continue_reading . '</a>';
	}

	return $more_string;
}

// Filter the excerpt more link.
add_filter('excerpt_more', 'andstudio_continue_reading_link');

// Filter the content more link.
add_filter('the_content_more_link', 'andstudio_continue_reading_link');

/**
 * Outputs a comment in the HTML5 format.
 *
 * This function overrides the default WordPress comment output in HTML5
 * format, adding the required class for Tailwind Typography. Based on the
 * `html5_comment()` function from WordPress core.
 *
 * @param WP_Comment $comment Comment to display.
 * @param array      $args    An array of arguments.
 * @param int        $depth   Depth of the current comment.
 */
function andstudio_html5_comment($comment, $args, $depth) {
	$tag = ('div' === $args['style']) ? 'div' : 'li';

	$commenter          = wp_get_current_commenter();
	$show_pending_links = ! empty($commenter['comment_author']);

	if ($commenter['comment_author_email']) {
		$moderation_note = __('Your comment is awaiting moderation.', 'andstudio');
	} else {
		$moderation_note = __('Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'andstudio');
	}
?>
	<<?php echo esc_attr($tag); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($comment->has_children ? 'parent' : '', $comment); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
					if (0 !== $args['avatar_size']) {
						echo get_avatar($comment, $args['avatar_size']);
					}
					?>
					<?php
					$comment_author = get_comment_author_link($comment);

					if ('0' === $comment->comment_approved && ! $show_pending_links) {
						$comment_author = get_comment_author($comment);
					}

					printf(
						/* translators: %s: Comment author link. */
						wp_kses_post(__('%s <span class="says">says:</span>', 'andstudio')),
						sprintf('<b class="fn">%s</b>', wp_kses_post($comment_author))
					);
					?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<?php
					printf(
						'<a href="%s"><time datetime="%s">%s</time></a>',
						esc_url(get_comment_link($comment, $args)),
						esc_attr(get_comment_time('c')),
						esc_html(
							sprintf(
								/* translators: 1: Comment date, 2: Comment time. */
								__('%1$s at %2$s', 'andstudio'),
								get_comment_date('', $comment),
								get_comment_time()
							)
						)
					);

					edit_comment_link(__('Edit', 'andstudio'), ' <span class="edit-link">', '</span>');
					?>
				</div><!-- .comment-metadata -->

				<?php if ('0' === $comment->comment_approved) : ?>
					<em class="comment-awaiting-moderation"><?php echo esc_html($moderation_note); ?></em>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div <?php andstudio_content_class('comment-content'); ?>>
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
			if ('1' === $comment->comment_approved || $show_pending_links) {
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="reply">',
							'after'     => '</div>',
						)
					)
				);
			}
			?>
		</article><!-- .comment-body -->
	<?php
}

/**
 * Custom password form for protected content.
 */
function andstudio_password_form() {
	ob_start();
	get_template_part('template-parts/layout/password-form');
	return ob_get_clean();
}
add_filter('the_password_form', 'andstudio_password_form');


/**
 * Output brand color styles in the head
 */
function andstudio_set_brand_colors() {
	global $post;

	// Only run on pages (frontend) or in block editor
	if (!is_page()) return;


	$parent_id = andstudio_get_top_parent_id($post);

	$primary_color   = get_field('brand_primary_color', $parent_id) ?: '#000000';
	$secondary_color = get_field('brand_secondary_color', $parent_id) ?: '#f2f2f2';
	?>
		<style>
			:root {
				--color-brand-primary: <?php echo esc_html($primary_color); ?>;
				--color-brand-secondary: <?php echo esc_html($secondary_color); ?>;
			}
		</style>
	<?php
}
add_action('wp_head', 'andstudio_set_brand_colors');


/**
 * Output brand color styles in the block editor (including iframe)
 */
function andstudio_set_brand_colors_editor() {
	// Only run in admin (block editor)
	if (!is_admin()) return;

	global $post;
	if (!$post) return;

	$parent_id = andstudio_get_top_parent_id($post);

	$primary_color   = get_field('brand_primary_color', $parent_id) ?: '#000000';
	$secondary_color = get_field('brand_secondary_color', $parent_id) ?: '#f2f2f2';

	$custom_css = "
		:root {
			--color-brand-primary: {$primary_color} !important;
			--color-brand-secondary: {$secondary_color} !important;
		}
	";

	// Register a virtual stylesheet handle
	wp_register_style('andstudio-brand-colors-editor', false);
	wp_enqueue_style('andstudio-brand-colors-editor');

	// Add the inline styles - this will work inside the iframe
	wp_add_inline_style('andstudio-brand-colors-editor', $custom_css);
}
add_action('enqueue_block_assets', 'andstudio_set_brand_colors_editor');



/**
 * Automatically inherit password protection from parent to child pages
 *
 */

// Hook into post save/update
add_action('save_post', 'inherit_password_from_parent', 10, 2);
add_action('wp_insert_post', 'inherit_password_from_parent', 10, 2);

function inherit_password_from_parent($post_id, $post) {
	// Only process pages, not posts or other post types
	if ($post->post_type !== 'page') {
		return;
	}

	// Avoid infinite loops
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Check if user has permission to edit
	if (!current_user_can('edit_page', $post_id)) {
		return;
	}

	// Remove the hook temporarily to prevent infinite recursion
	remove_action('save_post', 'inherit_password_from_parent');
	remove_action('wp_insert_post', 'inherit_password_from_parent');

	// If this page has a password, apply it to all child pages
	if (!empty($post->post_password)) {
		apply_password_to_children($post_id, $post->post_password);
	}

	// If this page had its password removed, check if children should inherit from grandparent
	if (empty($post->post_password) && $post->post_parent > 0) {
		$parent_password = get_ancestor_password($post->post_parent);
		if ($parent_password) {
			wp_update_post(array(
				'ID' => $post_id,
				'post_password' => $parent_password
			));
		}
		// Also update children to inherit the ancestor password (or remove password if no ancestor has one)
		apply_password_to_children($post_id, $parent_password);
	}

	// Re-add the hook
	add_action('save_post', 'inherit_password_from_parent', 10, 2);
	add_action('wp_insert_post', 'inherit_password_from_parent', 10, 2);
}

function apply_password_to_children($parent_id, $password) {
	// Get all child pages
	$children = get_pages(array(
		'parent' => $parent_id,
		'post_status' => array('publish', 'private', 'draft', 'pending')
	));

	foreach ($children as $child) {
		// Update child page password
		wp_update_post(array(
			'ID' => $child->ID,
			'post_password' => $password
		));

		// Recursively apply to grandchildren
		apply_password_to_children($child->ID, $password);
	}
}

function get_ancestor_password($page_id) {
	$page = get_post($page_id);

	if (!$page || $page->post_type !== 'page') {
		return '';
	}

	// If this page has a password, return it
	if (!empty($page->post_password)) {
		return $page->post_password;
	}

	// If this page has a parent, check the parent
	if ($page->post_parent > 0) {
		return get_ancestor_password($page->post_parent);
	}

	// No password found in the hierarchy
	return '';
}

// Optional: Also handle when pages are created as children of password-protected pages
add_action('wp_insert_post', 'inherit_password_on_creation', 20, 2);

function inherit_password_on_creation($post_id, $post) {
	// Only process pages
	if ($post->post_type !== 'page') {
		return;
	}

	// Only for new pages with parents
	if ($post->post_parent <= 0) {
		return;
	}

	// Skip if the page already has a password
	if (!empty($post->post_password)) {
		return;
	}

	// Get password from ancestor
	$ancestor_password = get_ancestor_password($post->post_parent);

	if ($ancestor_password) {
		// Remove hook to prevent infinite recursion
		remove_action('wp_insert_post', 'inherit_password_on_creation');

		wp_update_post(array(
			'ID' => $post_id,
			'post_password' => $ancestor_password
		));

		// Re-add hook
		add_action('wp_insert_post', 'inherit_password_on_creation', 20, 2);
	}
}

/**
 * Remove native password form from pages since we are handling it custom way
 */
add_filter('post_password_required', '__return_false');
