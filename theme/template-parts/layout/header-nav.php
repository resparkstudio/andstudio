<?php
global $post;

if (!$post) return;

$ancestors = get_post_ancestors($post->ID);
$ancestors_count = count($ancestors);

$main_title = null;
$sibling_pages = null;


if ($ancestors_count === 0) {
    return;
} elseif ($ancestors_count === 1) {
    $main_title = $post->post_title;
} else {
    $parent_post = get_post_parent($post->ID);
    $main_title = $parent_post->post_title;

    $sibling_pages = get_pages(array(
        'parent' => $parent_post->ID,
        'sort_column' => 'menu_order',
        'sort_order' => 'ASC'
    ));
}

?>

<div class="hidden md:flex rounded-lg grow min-w-0">
    <div class="bg-neutral-white px-5 py-4 rounded-lg shrink-0 relative z-10">
        <?php echo esc_html($main_title) ?>
    </div>
    <?php if ($sibling_pages) {
        get_template_part('template-parts/layout/navigation-swiper', null, array(
            'sibling_pages' => $sibling_pages
        ));
    } ?>
</div>