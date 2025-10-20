<?php

/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package andstudio
 */

global $post;

// Do not render header content if user not authenticated
if (!isset($_COOKIE['hide_intro']) || intval($_COOKIE['hide_intro']) !== andstudio_get_top_parent_id($post)) {
    return;
}

$parent_id = andstudio_get_top_parent_id($post);
$current_page_id = get_the_ID();
$nav_logo = get_field('nav_logo', $parent_id);

$sub_pages = get_children([
    'post_parent' => $parent_id,
    'post_type' => 'page',
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC',
]);


?>
<?php get_template_part('template-parts/layout/menu') ?>
<?php get_template_part('template-parts/layout/navigation-anchor') ?>

<header data-hero-reveal="header" id="masthead" class="fixed z-100 top-0 w-full">
    <div class="container-lg flex justify-between pt-5 gap-8">
        <div class="flex md:w-full">
            <div class="relative bg-neutral-white px-4 py-2 rounded-lg flex items-center gap-x-1.5 md:gap-x-6 shrink-0">
                <button data-menu-animation="open-btn">
                    <svg class="w-7 h-7" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M25.5407 14H2.06227" stroke="black" stroke-linecap="square" stroke-linejoin="round" />
                        <path d="M25.4384 22.8042H1.54069" stroke="black" stroke-linecap="square" stroke-linejoin="round" />
                        <path d="M25.4384 5.1958L1.54069 5.1958" stroke="black" stroke-linecap="square" stroke-linejoin="round" />
                    </svg>
                </button>

                <a href="<?php echo esc_url(get_page_link($parent_id)) ?>">
                    <img class="h-6 md:h-9" src="<?php echo esc_url($nav_logo['url']) ?>" alt="">
                </a>
            </div>
            <?php get_template_part('template-parts/layout/header-nav') ?>
        </div>
        <div class="w-40 bg-amber-300 shrink-0"></div>
    </div>

</header><!-- #masthead -->