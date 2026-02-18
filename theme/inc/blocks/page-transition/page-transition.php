<?php
$subtitle = get_field('subtitle');
$title = get_field('title');
$next_page = get_field('next_page_link');

$title = str_replace('|m|', '<br class="md:hidden">', $title);
$title = str_replace('|d|', '<br class="hidden md:block">', $title);
?>

<footer data-next-page="<?php echo esc_attr($next_page) ?>" class="h-screen relative bg-brand-primary py-12 text-text-primary md:py-23 md:sticky md:top-0">
    <div data-scroll-transition="parallax-footer" class="container-lg flex flex-col justify-between h-full will-change-transform">
        <?php if ($subtitle) : ?>
            <h3 class="text-body-m md:text-h2"><?php echo esc_html($subtitle) ?></h3>
            <h2 class="w-full leading-[1]" data-text-fit="target"><?php echo $title ?></h2>
        <?php endif ?>
    </div>
</footer>