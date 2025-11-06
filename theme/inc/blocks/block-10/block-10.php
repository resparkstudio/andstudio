<?php
$anchor_title = get_field('anchor_title');
$images = get_field('images');

andstudio_display_block_preview_img($block);
?>

<section class="w-full md:aspect-[1440/720]" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">
    <?php if ($images) : ?>
        <div class="flex flex-col gap-2.5 md:flex-row w-full h-full">
            <?php if (isset($images[0])) : ?>
                <img class="hidden md:block md:w-full md:h-full md:object-cover" src="<?php echo esc_url($images[0]['desktop_image']['url']) ?>" alt="<?php echo esc_attr($images[0]['desktop_image']['alt']) ?>">
                <img class="w-full object-cover md:hidden" src="<?php echo esc_url($images[0]['mobile_image']['url']) ?>" alt="<?php echo esc_attr($images[0]['mobile_image']['alt']) ?>">
            <?php endif; ?>

            <?php if (count($images) > 1) : ?>
                <div class="flex flex-col gap-2.5 w-full h-full">
                    <?php foreach (array_slice($images, 1) as $image) : ?>
                        <img class="hidden md:block md:w-full md:flex-1 md:min-h-0 md:object-cover" src="<?php echo esc_url($image['desktop_image']['url']) ?>" alt="<?php echo esc_attr($image['desktop_image']['alt']) ?>">
                        <img class="w-full object-cover md:hidden" src="<?php echo esc_url($image['mobile_image']['url']) ?>" alt="<?php echo esc_attr($image['mobile_image']['alt']) ?>">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif ?>
</section>