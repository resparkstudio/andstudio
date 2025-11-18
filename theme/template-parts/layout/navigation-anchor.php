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

if (empty($page_anchor_links) || count($page_anchor_links) < 6) return;
?>

<div class="hidden md:block container fixed w-full z-20 bottom-8">
    <div data-nav-slider-target="anchor" class="flex items-center justify-center min-w-0 w-full opacity-0 translate-y-6">
        <div data-nav-slider="container" class="flex gap-6 items-center px-4 py-3 bg-neutral-grey-1 h-full rounded-lg min-w-0">
            <button class="swiper-button-prev text-neutral-black">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 12L8.64645 11.6464C8.45118 11.8417 8.45118 12.1583 8.64645 12.3536L9 12ZM14.6464 18.3536C14.8417 18.5488 15.1583 18.5488 15.3536 18.3536C15.5488 18.1583 15.5488 17.8417 15.3536 17.6464L15 18L14.6464 18.3536ZM15 6L14.6464 5.64645L8.64645 11.6464L9 12L9.35355 12.3536L15.3536 6.35355L15 6ZM9 12L8.64645 12.3536L14.6464 18.3536L15 18L15.3536 17.6464L9.35355 11.6464L9 12Z" fill="currentColor" />
                </svg>
            </button>

            <div data-nav-slider="wrap" class="overflow-auto touch-none no-scrollbar flex gap-[32px]">

                <?php foreach ($page_anchor_links as $link) : ?>
                    <a data-nav-slider="item" class="group shrink-0 flex items-center gap-2 text-body-s" href="#<?php echo esc_attr($link['slug']) ?>">
                        <span class="text-neutral-grey-3 group-[.is-current]:text-neutral-black group-hover:text-neutral-black transition-colors duration-200">
                            <?php echo esc_html($link['title']) ?>
                        </span>
                    </a>
                <?php endforeach ?>

            </div>

            <button class="swiper-button-next text-neutral-black">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15 12L15.3536 12.3536C15.5488 12.1583 15.5488 11.8417 15.3536 11.6464L15 12ZM9.35355 5.64645C9.15829 5.45118 8.84171 5.45118 8.64645 5.64645C8.45118 5.84171 8.45118 6.15829 8.64645 6.35355L9 6L9.35355 5.64645ZM9 18L9.35355 18.3536L15.3536 12.3536L15 12L14.6464 11.6464L8.64645 17.6464L9 18ZM15 12L15.3536 11.6464L9.35355 5.64645L9 6L8.64645 6.35355L14.6464 12.3536L15 12Z" fill="currentColor" />
                </svg>
            </button>
        </div>
    </div>
</div>