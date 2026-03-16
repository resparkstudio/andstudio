<?php
$anchor_title = get_field('anchor_title') ?? false;
$boxed = get_field('boxed') ?? false;
$subtitle = get_field('subtitle') ?? false;
$title = get_field('title') ?? false;
$text = get_field('text') ?? false;
$first_video = get_field('first_video');
$first_image_group = get_field('first_image_group');
$first_video_group = get_field('first_video_group');
$second_video = get_field('second_video');
$second_image_group = get_field('second_image_group');
$second_video_group = get_field('second_video_group');

$first_video_url = $first_video && $first_video_group ? ($first_video_group['video_url'] ?: ($first_video_group['video_file']['url'] ?? '')) : '';
$second_video_url = $second_video && $second_video_group ? ($second_video_group['video_url'] ?: ($second_video_group['video_file']['url'] ?? '')) : '';

andstudio_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <div class="flex flex-col gap-6 md:gap-8">
            <?php if ($subtitle) : ?>
                <h3 class="text-body-s md:text-body-l"><?php echo esc_html($subtitle) ?></h3>
            <?php endif ?>
            <?php if ($title) : ?>
                <h2 class="text-h1-mobile md:text-h2"><?php echo esc_html($title) ?></h2>
            <?php endif ?>
        </div>

        <div class="flex flex-col gap-8 mt-8 md:grid md:grid-cols-12 md:mt-16 md:items-end md:gap-5">

            <?php if ($first_video_url || ($first_image_group && $first_image_group['mobile_image'])) : ?>
                <div class="w-full aspect-[353/305] md:hidden">
                    <?php if ($first_video_url) : ?>
                        <?php andstudio_background_video($first_video_url); ?>
                    <?php else : ?>
                        <?php echo wp_get_attachment_image($first_image_group['mobile_image']['id'], 'full', false, array(
                            'class' => 'w-full h-full object-cover'
                        )); ?>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <?php if ($text) : ?>
                <div class="andstudio-wysiwyg-container text-body-s md:col-span-4 md:pb-16">
                    <?php echo wp_kses_post($text) ?>
                </div>
            <?php endif ?>

            <?php if ($second_video_url || ($second_image_group && $second_image_group['mobile_image'])) : ?>
                <div class="w-full aspect-[353/380] md:hidden">
                    <?php if ($second_video_url) : ?>
                        <?php andstudio_background_video($second_video_url); ?>
                    <?php else : ?>
                        <?php echo wp_get_attachment_image($second_image_group['mobile_image']['id'], 'full', false, array(
                            'class' => 'w-full h-full object-cover'
                        )); ?>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <?php if ($first_video_url || ($first_image_group && $first_image_group['desktop_image'])) : ?>
                <div class="hidden w-full md:block md:col-span-4 aspect-[382/488]">
                    <?php if ($first_video_url) : ?>
                        <?php andstudio_background_video($first_video_url); ?>
                    <?php else : ?>
                        <?php echo wp_get_attachment_image($first_image_group['desktop_image']['id'], 'full', false, array(
                            'class' => 'w-full h-full object-cover'
                        )); ?>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <?php if ($second_video_url || ($second_image_group && $second_image_group['desktop_image'])) : ?>
                <div class="hidden w-full md:block md:col-span-4 aspect-[382/600]">
                    <?php if ($second_video_url) : ?>
                        <?php andstudio_background_video($second_video_url); ?>
                    <?php else : ?>
                        <?php echo wp_get_attachment_image($second_image_group['desktop_image']['id'], 'full', false, array(
                            'class' => 'w-full h-full object-cover'
                        )); ?>
                    <?php endif ?>
                </div>
            <?php endif ?>

        </div>
    </div>
</section>
