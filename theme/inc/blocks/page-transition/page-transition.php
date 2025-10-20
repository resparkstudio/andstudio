<?php
$subtitle = get_field('subtitle') ?? false;
$title = get_field('title') ?? false;
$next_page = get_field('next_page_link') ?? false;

andstudion_display_block_preview_img($block);
?>

<footer data-next-page="<?php echo esc_attr($next_page) ?>" class="h-screen relative bg-brand-primary py-12 text-neutral-white md:py-23 md:sticky md:top-0">
    <div data-scroll-transition="parallax-footer" class="container-lg flex flex-col justify-between h-full">
        <?php if ($subtitle) : ?>
            <h3 class="text-body-m md:text-h2"><?php echo esc_html($subtitle) ?></h3>
            <h2 class="grow flex flex-col justify-end" data-text-fit="target"><?php echo esc_html($title) ?></h2>
        <?php endif ?>
    </div>
</footer>