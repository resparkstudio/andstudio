<?php

/**
 * Template part for sticky anchor navigation
 */

/**
 * Recursively collect anchor links from blocks
 */
function andstudio_get_anchor_links($blocks) {
    $anchor_links = [];

    foreach ($blocks as $block) {
        // Check if it's an ACF block with anchor_title
        if (isset($block['attrs']['data']['anchor_title']) && !empty($block['attrs']['data']['anchor_title'])) {
            $anchor_title = $block['attrs']['data']['anchor_title'];
            $anchor_links[] = [
                'title' => $anchor_title,
                'slug' => andstudio_construct_anchor_slug($anchor_title)
            ];
        }

        // Recursively check inner blocks
        if (!empty($block['innerBlocks'])) {
            $inner_links = andstudio_get_anchor_links($block['innerBlocks']);
            $anchor_links = array_merge($anchor_links, $inner_links);
        }
    }

    return $anchor_links;
}

$content = get_The_content();
$blocks = parse_blocks($content);

$page_anchor_links = andstudio_get_anchor_links($blocks);

if (empty($page_anchor_links)) return;
?>

<div class="hidden md:block fixed left-1/2 -translate-x-1/2 z-20 bottom-20">
    <div class="bg-neutral-grey-1 p-4 flex gap-5">
        <?php foreach ($page_anchor_links as $link) : ?>
            <a class="text-body-l" href="#<?php echo esc_attr($link['slug']) ?>"><?php echo esc_html($link['title']) ?></a>
        <?php endforeach ?>
    </div>
</div>