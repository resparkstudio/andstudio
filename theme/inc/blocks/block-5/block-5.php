<?php
$anchor_title = get_field('anchor_title') ?? false;
$boxed = get_field('boxed') ?? false;
$subtitle = get_field('subtitle') ?? false;
$title = get_field('title') ?? false;
$text = get_field('text') ?? false;
$video = get_field('video');
$image_group = get_field('image_group');
$video_group = get_field('video_group');

$video_url = $video && $video_group ? ($video_group['video_url'] ?: ($video_group['video_file']['url'] ?? '')) : '';

andstudio_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <div class="flex flex-col gap-6 md:gap-16">
            <?php if ($subtitle) : ?>
                <h3 class="text-body-s md:text-body-l"><?php echo esc_html($subtitle) ?></h3>
            <?php endif ?>
            <?php if ($title) : ?>
                <h2 class="text-h1-mobile md:text-[5rem] md:leading-[5.5rem]"><?php echo esc_html($title) ?></h2>
            <?php endif ?>
        </div>

        <div class="mt-8 flex flex-col gap-8 md:mt-16 md:flex-row-reverse md:justify-between md:items-end">
            <div class="md:w-full md:max-w-1/2">
                <?php if ($video_url) : ?>
                    <div class="w-full aspect-[353/305] md:aspect-[580/420]">
                        <?php andstudio_background_video($video_url); ?>
                    </div>
                <?php else : ?>
                    <?php if ($image_group && $image_group['mobile_image']) : ?>
                        <?php echo wp_get_attachment_image($image_group['mobile_image']['id'], 'full', false, array(
                            'class' => 'w-full object-cover aspect-[353/305] md:hidden'
                        )); ?>
                    <?php endif ?>
                    <?php if ($image_group && $image_group['desktop_image']) : ?>
                        <?php echo wp_get_attachment_image($image_group['desktop_image']['id'], 'full', false, array(
                            'class' => 'hidden w-full object-cover aspect-[580/420] md:block'
                        )); ?>
                    <?php endif ?>
                <?php endif ?>
            </div>

            <?php if ($text) : ?>
                <div class="andstudio-wysiwyg-container text-body-s md:text-body-l md:max-w-120">
                    <?php echo wp_kses_post($text) ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>