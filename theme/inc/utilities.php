<?php

/**
 * Custom utility functions
 *
 * @package andstudio
 */

function andstudio_get_top_parent_id($post) {
    if (!$post || $post->post_type !== 'page') return;

    $ancestors = get_post_ancestors($post->ID);

    if (! empty($ancestors)) {
        // Top-level parent is the last one in the array
        return end($ancestors);
    } else {
        // No ancestors → this is already top-level
        return $post->ID;
    }
}


/**
 * Set cookie for intro page
 */
function andstudio_set_intro_cookie($post) {
    if (!$post || $post->post_type !== 'page') return;

    $cookie_id = andstudio_get_top_parent_id($post);
    setcookie('hide_intro', $cookie_id, time() + (86400 * 30), '/');
}

/**
 * Check if page has any children
 */
function andstudio_has_page_children($post) {

    return count(get_posts(array('post_parent' => $post->ID, 'post_type' => $post->post_type)));
}

/**
 * Get direct child pages
 */
function andstudio_get_direct_child_pages($parent_id) {
    $children =  get_children([
        'post_parent' => $parent_id,
        'post_type' => 'page',
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ]);

    return array_values($children);
}

/**
 * Check if a page is a child or descendant of another page
 */
function andstudio_is_child_of($child_id, $parent_id) {
    $ancestors = get_post_ancestors($child_id);
    return in_array($parent_id, $ancestors);
}


function andstudio_construct_submenu_rows($posts, $isMobile = false) {
    $rows = [];
    $currentRow = 0;
    $itemsInCurrentRow = 0;

    foreach ($posts as $post) {
        if ($isMobile) {
            // Mobile: alternating 1-2-1-2-1-2 pattern
            $maxItemsInRow = ($currentRow % 2 === 0) ? 1 : 2;
        } else {
            // Desktop: 1-2-3-3-3 pattern
            if ($currentRow === 0) {
                $maxItemsInRow = 1;
            } elseif ($currentRow === 1) {
                $maxItemsInRow = 2;
            } else {
                $maxItemsInRow = 3;
            }
        }

        // Start new row if current is full
        if ($itemsInCurrentRow >= $maxItemsInRow) {
            $currentRow++;
            $itemsInCurrentRow = 0;
        }

        // Add post to current row
        if (!isset($rows[$currentRow])) {
            $rows[$currentRow] = [];
        }
        $rows[$currentRow][] = $post;
        $itemsInCurrentRow++;
    }

    return $rows;
}


/**
 * Create anchor link slug
 */
function andstudio_construct_anchor_slug($anchor_title) {
    if ($anchor_title) {
        return 'section-' . sanitize_title($anchor_title);
    } else {
        return '';
    }
}


/**
 * Output dynamic section classes
 * 
 * These classes are for boxed/full-width layout acf option that every field has
 */
function andstudio_get_section_classes($boxed = false) {
    $base_classes = 'bg-neutral-white py-12 md:px-18';
    return $boxed ? $base_classes . ' md:bg-neutral-grey-1 md:py-23' : $base_classes . " md:py-0 md:rounded-xl";
}


/**
 * Output preview image for the ACF block
 */
function andstudion_display_block_preview_img($block) {

    // Runs in preview context inside the editor
    if (isset($block['data']['preview_image'])) :
        $block_name = str_replace('andstudio/', '', $block['name']);
        $block_dir = get_template_directory_uri() . '/inc/blocks/' . $block_name;
        $image_src = $block_dir . '/preview.jpg';
?>
        <img src="<?php echo esc_url($image_src) ?>" style="width: 100%; height: auto;">
    <?php endif ?>

<?php return;
}
