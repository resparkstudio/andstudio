<?php

/**
 * Menu modal render template used inside header-content.php
 */

// global $post;

$parent_page_id = $args['parent_page_id'] ?? null;

if (!$parent_page_id) return;

// $top_parent_id = andstudio_get_top_parent_id($post);
$current_page_id = get_the_ID();

$pages = andstudio_get_direct_child_pages($parent_page_id);
?>

<!-- Menu modal -->
<div data-menu-animation="modal" class="hidden z-110 fixed inset-0 md:px-18 md:py-5 md:gap-2 md:grid-cols-2">

    <!-- Main menu overlay -->
    <div data-menu-animation="overlay" class="fixed left-0 top-0 -z-10 w-full h-full bg-neutral-black opacity-30"></div>

    <!-- Desktop submenu background -->
    <div data-submenu-animation="desktop-background" class="hidden md:block -z-10 w-0 h-0 bg-neutral-grey-1 rounded-b-lg md:rounded-xl origin-top-left order-2"></div>


    <!-- Modal main content wrap -->
    <div class="relative w-full pt-10 pb-5 px-5 z-10 md:flex md:flex-col md:justify-between md:pb-4 md:px-6 md:pt-6 md:w-full md:h-full md:order-1">
        <!-- Modal background -->
        <div data-menu-animation="background" class="absolute -z-10 h-full w-full top-0 left-0 bg-neutral-grey-1 rounded-b-lg md:rounded-xl origin-top-left md:w-0 md:h-0"></div>

        <!-- Close button -->
        <button data-menu-animation="close-btn" class="absolute top-5 right-5 w-10 h-10 flex items-center justify-center bg-neutral-white rounded-full md:left-6 md:top-6 md:hover:bg-brand-secondary md:transition-colors md:duration-200">
            <svg class="h-3 w-3 text-neutral-black" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 1L1 11M1 1L11 11" stroke="currentColor" />
            </svg>
        </button>

        <!-- nav wrap -->
        <nav class="md:self-end">
            <ul class="flex flex-col items-start gap-2.5 md:gap-4 md:items-end">
                <?php foreach ($pages as $page) :
                    $is_current = $page->ID === $current_page_id || andstudio_is_child_of($current_page_id, $page->ID);
                    $has_children = andstudio_has_page_children($page);
                    $dot_classes = 'w-1.5 h-1.5 hidden group-[.is-current]:block rounded-full bg-brand-primary ml-2';
                    $nav_link_classes = 'group flex w-full items-center text-body-m text-neutral-grey-3 [&.is-current]:text-neutral-black hover:text-neutral-black transition-colors duration-300 md:text-body-l';
                    if ($is_current) {
                        $nav_link_classes .= ' is-current';
                    }
                ?>
                    <li class="md:text-end">

                        <?php if (!$has_children) : ?>
                            <a data-menu-animation="nav-link"
                                class="<?php echo esc_attr($nav_link_classes) ?>"
                                href="<?php echo esc_url(get_page_link($page->ID)) ?>">
                                <?php echo esc_html($page->post_title) ?>
                                <div class="<?php echo esc_attr($dot_classes) ?>"></div>
                            </a>
                        <?php else : ?>
                            <a
                                href="<?php echo esc_url(get_page_link($page->ID)) ?>"
                                data-menu-animation="nav-link"
                                data-submenu-animation="trigger"
                                data-modal-id="<?php echo esc_attr($page->ID) ?>"
                                class="<?php echo esc_attr($nav_link_classes) ?>">
                                <?php echo esc_html($page->post_title) ?>
                                <div class="<?php echo esc_attr($dot_classes) ?>"></div>
                                <svg class="w-6 h-6 group-[.is-current]:hidden" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.00049 17.9995L15.0005 11.9995L9.00049 5.99951" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>

                            <?php get_template_part('template-parts/layout/submenu', null, array('parent_page' => $page)) ?>
                        <?php endif ?>

                    </li>
                <?php endforeach ?>
            </ul>
        </nav>

        <!-- Bottom menu content -->
        <div data-menu-animation="privacy-wrap" class="mt-18 px-1 w-full">
            <div class="flex justify-between">
                <span class="text-xs text-neutral-black">© <?php echo esc_html(date("Y")) ?> Company. All rights reserved.
                    <a class="underline" href="">Privacy policy</a>
                </span>
                <a target="_blank" href="https://byandstudio.com/">
                    <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.9999 15.7055L12.9569 12.6626C13.3692 11.9558 13.6441 11.2098 13.8404 10.5031C14.0367 9.73742 14.1152 9.01104 14.1152 8.40245V7.71534H11.4846V8.22577C11.4846 9.1681 11.3471 10.0515 11.0723 10.7779L8.00971 7.71534C8.81461 7.34233 9.59989 6.91043 10.2281 6.3411C10.5815 6.00736 10.876 5.63436 11.0919 5.20245C11.3079 4.77055 11.4257 4.26012 11.4257 3.6908C11.4257 3.1411 11.3275 2.63068 11.1116 2.17914C10.7974 1.49203 10.2674 0.942333 9.541 0.569327C8.81462 0.196321 7.93118 0 6.89069 0C5.43793 0 4.29928 0.451534 3.514 1.17791C2.72873 1.90429 2.33609 2.88589 2.33609 3.90675C2.33609 4.53497 2.47352 5.08466 2.76799 5.65399C3.02321 6.14478 3.39621 6.61595 3.90664 7.18528C3.12137 7.59755 2.35572 8.06871 1.7864 8.71657C1.45266 9.06994 1.17781 9.48221 0.98149 9.95337C0.785171 10.4245 0.687012 10.9546 0.687012 11.5632C0.687012 12.2307 0.824436 12.8393 1.09928 13.389C1.51155 14.2135 2.2183 14.8614 3.18026 15.3129C4.14223 15.7644 5.33977 16 6.75327 16C7.85265 16 8.79498 15.8233 9.59989 15.5288V12.8196L9.61952 12.8393V12.8196L12.5054 15.6859H15.9999V15.7055ZM5.45756 2.66994C5.61462 2.53252 5.79131 2.41472 6.02689 2.31656C6.26247 2.23804 6.53732 2.17914 6.87106 2.17914C7.47965 2.17914 7.91155 2.35583 8.20603 2.63068C8.5005 2.90552 8.63793 3.27853 8.63793 3.73006C8.63793 4.00491 8.57904 4.22086 8.46124 4.43681C8.28456 4.75092 7.99008 5.0454 7.57781 5.32025C7.22443 5.55583 6.7729 5.79141 6.30174 6.00736C5.8502 5.5362 5.51646 5.16319 5.32014 4.82945C5.20235 4.65276 5.12382 4.47607 5.06492 4.29939C5.00603 4.1227 4.9864 3.96564 4.9864 3.76932C5.02566 3.35705 5.16308 2.96442 5.45756 2.66994ZM6.73363 13.6245C5.81093 13.6245 5.00603 13.4086 4.43671 13.0159C4.16186 12.8196 3.9459 12.584 3.78885 12.3092C3.63179 12.0344 3.55327 11.7006 3.55327 11.3276C3.55327 11.0331 3.61216 10.7583 3.71032 10.5227C3.86738 10.1693 4.1226 9.85521 4.45634 9.56073C4.75082 9.30552 5.12382 9.06994 5.53609 8.85399L9.541 12.8196C8.83425 13.3301 7.91155 13.6245 6.73363 13.6245Z" fill="black" />
                    </svg>
                </a>
            </div>
            <button data-menu-animation="close-btn" class="block mt-6 h-1.5 w-41 bg-neutral-grey-2 rounded-xs mx-auto md:hidden"></button>

        </div>
    </div>

</div>



<?php
// Separate sub-menu wraps
// Desktop - show all stacked, and change visibility with opacity - only active submenu has opacity of 100 while others are set to 0.
// Mobile animate like separate modals
// Sub-menu bg padaryti kaip atskira elementa (kaip main meniu turi pvz)

?>