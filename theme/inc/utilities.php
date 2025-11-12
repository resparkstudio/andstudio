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
 * Get the parent brand page ID
 * 
 * Gets the closest page that has parent_brand_page checked to retrieve brand styles. 
 * Important for sub-brand pages
 */
function andstudio_get_brand_parent_id($post) {
    if (!$post || $post->post_type !== 'page') return;

    $current_id = $post->ID;

    // First check if current page has brand styles
    if (get_field('parent_brand_page', $current_id)) {
        return $current_id;
    }

    // Loop through ancestor pages and check if they have brand styles
    while ($current_id) {
        $parent_id = wp_get_post_parent_id($current_id);

        // Return false if there are no parents
        if (!$parent_id) {
            return false;
        }

        if (get_field('parent_brand_page', $parent_id)) {
            return $parent_id;
        } else {
            // Continue the while loop with next id
            $current_id = $parent_id;
        }
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
    return $boxed ? $base_classes . ' md:bg-neutral-grey-1 md:py-23' : $base_classes . " md:pt-0 md:pb-18 md:rounded-xl";
}


/**
 * Output preview image for the ACF block
 */
function andstudio_display_block_preview_img($block) {

    // Runs in preview context inside the editor
    if (isset($block['data']['preview_image'])) :
        $block_name = str_replace('andstudio/', '', $block['name']);
        $block_dir = get_template_directory_uri() . '/inc/blocks/' . $block_name;
        $image_src = $block_dir . '/preview.jpg';
?>
        <img src="<?php echo esc_url($image_src) ?>" style="width: 100%; height: auto; max-height: 100%">
    <?php endif ?>

<?php return;
}


/**
 * Return parsed SVG element from ACF image field
 * 
 * Removes either height or width property
 * Sets either height or width to 100%
 * Sets path colors to currentColor
 */
function andstudio_format_svg_for_output($svg_content, $control_height = false, $control_color = false) {
    // Create a new DOMDocument
    $dom = new DOMDocument();
    $dom->loadXML($svg_content);

    // Get the SVG element
    $svg = $dom->getElementsByTagName('svg')->item(0);


    if ($control_height) {
        // Remove width attribute
        $svg->removeAttribute('width');
        // Set height to 100%
        $svg->setAttribute('height', '100%');
    } else {
        // Remove height attribute
        $svg->removeAttribute('height');
        // Set width to 100%
        $svg->setAttribute('width', '100%');
    }

    if ($control_color) {
        // Get all path elements and change fill to currentColor
        $paths = $dom->getElementsByTagName('path');
        foreach ($paths as $path) {
            $path->setAttribute('fill', 'currentColor');
        }
    }

    return $dom->saveXML($dom->documentElement);
}


/**
 * Get parent page from URl
 */
function andstudio_get_parent_page_from_url() {
    $url_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $path_parts = explode('/', $url_path);

    // Get the first slug which should be brand parent
    $brand_slug = $path_parts[0] ?? '';

    $brand_page = get_page_by_path($brand_slug, OBJECT, 'page');

    return $brand_page;
}
