<?php

/**
 * This template is used inside menu-modal.php for elements that have sub-pages
 */

$page = $args['parent_page'] ?? null;

if (!$page) return;

$has_children = andstudio_has_page_children($page);
$sub_pages = andstudio_get_direct_child_pages($page->ID);

if (!$has_children) return;

$desktop_rows = andstudio_construct_submenu_rows($sub_pages);
$mobile_rows_visible = array_slice($sub_pages, 0, 6);
$mobile_rows_overflow = array_slice($sub_pages, 6);

$sub_pages_count = count($sub_pages);

$mobile_size = match (true) {
    $sub_pages_count <= 2 => 'large',
    $sub_pages_count === 3 => 'medium',
    $sub_pages_count >= 4 => 'small',
};

$modal_height_style = '';

if ($sub_pages_count >= 4) {
    $visible_count = min($sub_pages_count, 6);
    $gap_rem = 0.625;
    $padding_rem = 2.75;
    $handle_rem = 1.0;
    $modal_height_rem = (4.5 * $visible_count) + ($gap_rem * ($visible_count - 1)) + $padding_rem + $handle_rem;
    $modal_height_style = "--mobile-h: {$modal_height_rem}rem;";
}
?>

<div data-submenu-animation="container" data-modal-parent-id="<?php echo esc_attr($page->ID) ?>" class="hidden fixed inset-0 z-30 items-end md:w-1/2 md:left-auto md:py-5 md:pr-18 md:pl-1">
    <div data-submenu-animation="overlay" class="absolute z-10 left-0 top-0 w-full h-full bg-neutral-black opacity-0 md:hidden"></div>

    <?php if ($modal_height_style) : ?>
        <div data-submenu-animation="modal"
            style="<?php echo $modal_height_style ?>"
            class="h-[var(--mobile-h)] max-h-[90vh] translate-y-full w-full bg-neutral-grey-1 rounded-t-lg relative bottom-0 z-20 px-5 pt-5 pb-6 flex flex-col md:translate-0 md:rounded-xl md:h-full md:max-h-none md:p-6 md:bg-transparent md:opacity-0">
        <?php else : ?>
            <div data-submenu-animation="modal"
                class="translate-y-full w-full bg-neutral-grey-1 rounded-t-lg relative bottom-0 z-20 px-5 pt-5 pb-6 flex flex-col md:translate-0 md:rounded-xl md:h-full md:p-6 md:bg-transparent md:opacity-0">
            <?php endif ?>

            <button data-submenu-animation="close-btn" class="block mb-2.5 h-1.5 w-41 bg-neutral-grey-2 rounded-xs mx-auto md:hidden"></button>

            <!-- Mobile -->
            <div data-lenis-prevent class="h-full w-full overflow-y-scroll md:hidden">
                <?php if ($mobile_rows_visible) : ?>
                    <!-- Visible part -->
                    <div class="flex flex-col h-full gap-2.5">
                        <?php foreach ($mobile_rows_visible as $sub_page) : ?>
                            <?php get_template_part('template-parts/layout/submenu-item', null, [
                                'sub_page' => $sub_page,
                                'mobile_size' => $mobile_size,
                            ]) ?>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
                <!-- Overflow part -->
                <?php if ($mobile_rows_overflow) : ?>
                    <div class="flex flex-col gap-2.5 mt-2.5">
                        <?php foreach ($mobile_rows_overflow as $sub_page) : ?>
                            <?php get_template_part('template-parts/layout/submenu-item', null, [
                                'sub_page' => $sub_page,
                                'mobile_size' => $mobile_size,
                            ]) ?>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            </div>

            <!-- Desktop -->
            <?php if ($desktop_rows) : ?>
                <div data-lenis-prevent class="hidden md:grid [grid-auto-rows:calc((100%_-_0.75rem)/3)] md:grid-cols-1 md:gap-1.5 md:h-full md:overflow-y-scroll">
                    <?php foreach ($desktop_rows as $row) : ?>
                        <div class="flex w-full gap-1.5">
                            <?php foreach ($row as $sub_page) : ?>
                                <?php get_template_part('template-parts/layout/submenu-item', null, ['sub_page' => $sub_page]) ?>
                            <?php endforeach ?>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
            </div>
        </div>