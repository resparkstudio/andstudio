<?php
$anchor_title = get_field('anchor_title');
$images = get_field('images');

andstudio_display_block_preview_img($block);
?>

<section class="w-full md:aspect-[1440/720]" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">
    <?php if ($images) : ?>
        <div class="w-full h-full flex flex-col gap-2.5 md:flex-row">
            <?php if (isset($images[0])) :
                $item = $images[0];
                $video_url = $item['video'] && $item['video_group'] ? ($item['video_group']['video_url'] ?: ($item['video_group']['video_file']['url'] ?? '')) : '';
            ?>
                <div class="md:flex-1 md:h-full">
                    <?php if ($video_url) : ?>
                        <div class="hidden md:block md:h-full"><?php andstudio_background_video($video_url); ?></div>
                        <div class="w-full aspect-video md:hidden"><?php andstudio_background_video($video_url); ?></div>
                    <?php else : ?>
                        <img class="hidden md:block md:w-full md:h-full md:object-cover" src="<?php echo esc_url($item['desktop_image']['url'] ?? '') ?>" alt="<?php echo esc_attr($item['desktop_image']['alt'] ?? '') ?>">
                        <img class="w-full object-cover md:hidden" src="<?php echo esc_url($item['mobile_image']['url'] ?? '') ?>" alt="<?php echo esc_attr($item['mobile_image']['alt'] ?? '') ?>">
                    <?php endif ?>
                </div>
            <?php endif; ?>

            <?php if (count($images) > 1) : ?>
                <div class="flex flex-col gap-2.5 md:flex-1 md:h-full">
                    <?php foreach (array_slice($images, 1) as $item) :
                        $video_url = $item['video'] && $item['video_group'] ? ($item['video_group']['video_url'] ?: ($item['video_group']['video_file']['url'] ?? '')) : '';
                    ?>
                        <?php if ($video_url) : ?>
                            <div class="hidden md:block md:w-full md:flex-1 md:min-h-0"><?php andstudio_background_video($video_url); ?></div>
                            <div class="w-full aspect-video md:hidden"><?php andstudio_background_video($video_url); ?></div>
                        <?php else : ?>
                            <img class="hidden md:block md:w-full md:flex-1 md:min-h-0 md:object-cover" src="<?php echo esc_url($item['desktop_image']['url'] ?? '') ?>" alt="<?php echo esc_attr($item['desktop_image']['alt'] ?? '') ?>">
                            <img class="w-full object-cover md:hidden" src="<?php echo esc_url($item['mobile_image']['url'] ?? '') ?>" alt="<?php echo esc_attr($item['mobile_image']['alt'] ?? '') ?>">
                        <?php endif ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif ?>
</section>