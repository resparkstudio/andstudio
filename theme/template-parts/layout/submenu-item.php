<?php

/**
 * Single submenu item template
 */

$sub_page = $args['sub_page'] ?? null;
$mobile_align_class = ($args['top_align'] ?? false) ? 'items-start' : 'items-center';

if (!$sub_page) return;

$page_url = get_page_link($sub_page->ID);
$thumbnail_url = get_the_post_thumbnail_url($sub_page);
$text_color = $thumbnail_url ? 'text-neutral-white' : 'text-neutral-black';
?>

<a
    href="<?php echo esc_url($page_url) ?>"
    data-submenu-animation="link"
    class="<?php echo esc_attr($mobile_align_class) ?> group w-full h-full bg-brand-secondary md:hover:bg-brand-primary transition-colors duration-300 rounded-xl p-5 text-body-m flex justify-between relative overflow-hidden md:p-4 md:pl-6 md:flex-col md:items-start">

    <?php if ($thumbnail_url) : ?>
        <img
            src="<?php echo esc_url($thumbnail_url) ?>"
            alt=""
            class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 md:group-hover:scale-105" />
    <?php endif ?>

    <h3 class="<?php echo esc_attr($text_color) ?> text-body-m text-start md:group-hover:text-neutral-white transition-colors duration-300 relative z-10"><?php echo esc_html($sub_page->post_title) ?></h3>
    <button class="bg-brand-primary text-neutral-white rounded-full w-8 h-8 flex items-center justify-center md:group-hover:bg-neutral-white md:group-hover:text-neutral-black transition-colors duration-300 relative z-10 md:self-end">
        <svg class="w-2.5 h-2.5" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 1L11 11M11 11L0.999999 11M11 11L1 1" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
</a>