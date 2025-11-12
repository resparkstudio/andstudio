<?php

/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package andstudio
 */

global $post;

$parent_page_id = null;

if (is_404()) {
    $parent_page_id = andstudio_get_parent_page_from_url()?->ID;
} else {
    $parent_page_id = andstudio_get_top_parent_id($post);
}

// Do not render header content if user not authenticated
if (!isset($_COOKIE['hide_intro']) || intval($_COOKIE['hide_intro']) !== andstudio_get_top_parent_id($post) && !is_404()) {
    return;
}

// $parent_id = andstudio_get_top_parent_id($post);
$current_page_id = get_the_ID();
$nav_logo = get_field('nav_logo', $parent_page_id);
$download_links = get_field('download_links', $parent_page_id);

if ($parent_page_id) {
    $sub_pages = get_children([
        'post_parent' => $parent_page_id,
        'post_type' => 'page',
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ]);
}

?>
<?php get_template_part('template-parts/layout/menu', null, [
    'parent_page_id' => $parent_page_id
]) ?>
<?php get_template_part('template-parts/layout/navigation-anchor') ?>

<header data-hero-reveal="header" id="masthead" class="fixed z-100 top-0 w-full">
    <div class="container-lg flex justify-between pt-5 gap-8">
        <div class="flex grow min-w-0">
            <?php if (!empty($sub_pages) || $nav_logo) : ?>
                <div class="bg-neutral-white px-4 py-2 rounded-lg flex items-center gap-x-1.5 md:gap-x-6 shrink-0">
                    <?php if (!empty($sub_pages)) : ?>
                        <button data-menu-animation="open-btn">
                            <svg class="w-7 h-7" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M25.5407 14H2.06227" stroke="black" stroke-linecap="square" stroke-linejoin="round" />
                                <path d="M25.4384 22.8042H1.54069" stroke="black" stroke-linecap="square" stroke-linejoin="round" />
                                <path d="M25.4384 5.1958L1.54069 5.1958" stroke="black" stroke-linecap="square" stroke-linejoin="round" />
                            </svg>
                        </button>
                    <?php endif ?>

                    <?php if ($nav_logo) : ?>
                        <a href="<?php echo esc_url(get_page_link($parent_page_id)) ?>">
                            <img class="h-6 md:h-9" src="<?php echo esc_url($nav_logo['url']) ?>" alt="<?php echo esc_attr($nav_logo['alt']) ?>">
                        </a>
                    <?php endif ?>
                </div>
            <?php endif ?>
            <?php get_template_part('template-parts/layout/header-nav') ?>
        </div>

        <!-- Download dropdown -->
        <?php if ($download_links) : ?>
            <div x-data='{"expanded" : false}' class="hidden md:block shrink-0 relative">
                <button @click="expanded = !expanded" class="group flex items-center gap-3 p-4 bg-neutral-white rounded-lg text-body-s hover:bg-brand-primary hover:text-neutral-white transition-colors duration-200">
                    <?php _e('Download elements', 'andstudio') ?>
                    <svg class="w-5 h-5 text-brand-primary group-hover:text-neutral-white transition-colors duration-200" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="20" height="20" rx="10" fill="currentColor" />
                        <path class="text-neutral-white group-hover:text-brand-primary transition-colors duration-200" d="M10.001 5.66699V11.667M10.001 11.667L7.00098 8.93972M10.001 11.667L13.001 8.93972" stroke="currentColor" />
                        <path class="text-neutral-white group-hover:text-brand-primary transition-colors duration-200" d="M6.00098 13.667H14.001" stroke="currentColor" />
                    </svg>
                </button>

                <div class="absolute w-full top-full" x-show="expanded" x-collapse.duration.700ms>
                    <div class="bg-neutral-grey-1 rounded-lg">
                        <?php foreach ($download_links as $link) :
                            $link_target = $link['link']['target'] ? $link['link']['target'] : '_self'; ?>
                            <a class="group py-4 px-5.5 flex items-center gap-1 rounded-lg hover:bg-neutral-white transition-colors duration-200" href="<?php echo esc_url($link['link']['url']) ?>" target="<?php echo esc_attr($link_target) ?>">
                                <div class="hidden bg-brand-primary w-1.5 h-1.5 rounded-full group-hover:inline-block"></div>
                                <?php echo esc_html($link['link']['title']) ?>
                            </a>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>

</header><!-- #masthead -->