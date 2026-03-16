<?php
$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$subtitle = get_field('subtitle');
$title = get_field('title');
$text = get_field('text');
$image_group = get_field('image_group');
$video = get_field('video');
$video_group = get_field('video_group');



andstudio_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <?php if ($subtitle || $title) : ?>
            <div class="flex flex-col gap-6 md:gap-8 md:max-w-[57.625rem]">
                <?php if ($subtitle) : ?>
                    <h3 class="text-body-s md:text-body-l"><?php echo esc_html($subtitle) ?></h3>
                <?php endif ?>
                <?php if ($title) : ?>
                    <h2 class="text-h1-mobile md:text-h1"><?php echo esc_html($title) ?></h2>
                <?php endif ?>
            </div>

            <?php if ($text) : ?>
                <div class="andstudio-wysiwyg-container text-body-s mt-4 md:mt-16 md:max-w-[33.125rem] md:ml-auto md:text-body-l">
                    <?php echo wp_kses_post($text) ?>
                </div>
            <?php endif ?>

            <?php
            $video_url = $video && $video_group ? ($video_group['video_url'] ?: ($video_group['video_file']['url'] ?? '')) : '';
            $has_image = $image_group && ($image_group['desktop_image'] || $image_group['mobile_image']);
            ?>
            <?php if ($video_url || $has_image) : ?>
                <div class="mt-8 md:mt-10 aspect-[353/305] md:aspect-[1184/500]">
                    <?php if ($video_url) : ?>
                        <?php andstudio_background_video($video_url); ?>
                    <?php else : ?>
                        <?php echo wp_get_attachment_image($image_group['mobile_image']['id'], 'full', false, array(
                            'class' => 'w-full h-full object-cover md:hidden'
                        )); ?>
                        <?php echo wp_get_attachment_image($image_group['desktop_image']['id'], 'full', false, array(
                            'class' => 'hidden w-full h-full object-cover md:block'
                        )); ?>
                    <?php endif ?>
                </div>
            <?php endif ?>
        <?php endif ?>
    </div>

</section>