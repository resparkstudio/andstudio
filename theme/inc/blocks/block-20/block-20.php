<?php
$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$title = get_field('title');
$description = get_field('description');
$link = get_field('link');
$items = get_field('items');

andstudio_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">
    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <?php if ($title) : ?>
            <h2 class="text-h1-mobile md:text-h1 md:max-w-135"><?php echo esc_html($title) ?></h2>
        <?php endif ?>

        <?php if ($description) : ?>
            <div class="andstudio-wysiwyg-container text-body-s mt-6 md:mt-8 md:max-w-145.5">
                <?php echo wp_kses_post($description) ?>
            </div>
        <?php endif ?>

        <?php if ($link) :
            $link_target = $link['target'] ? $link['target'] : '_self'; ?>
            <a class="hidden text-body-s text-brand-primary underline md:inline-block md:mt-4" href="<?php echo esc_url($link['url']) ?>" target="<?php echo esc_attr($link_target) ?>"><?php echo esc_html($link['title']) ?></a>
        <?php endif ?>

        <?php if ($items) : ?>
            <div class="flex flex-col gap-8 mt-8 md:mt-16 md:gap-10">
                <?php foreach ($items as $item) :
                    $item_video_url = $item['video'] && $item['video_group'] ? ($item['video_group']['video_url'] ?: ($item['video_group']['video_file']['url'] ?? '')) : '';
                ?>
                    <?php if ($item['vertical_layout']) : ?>
                        <!-- Vertical Layout -->
                        <div class="pt-8 border-t border-neutral-grey-2 md:first:border-t-0 md:first:pt-0 md:pt-10 md:flex md:flex-col md:items-start md:gap-10 md:justify-between">
                            <div class="md:max-w-120.5">
                                <?php if ($item['title']) : ?>
                                    <h3 class="text-h3"><?php echo esc_html($item['title']) ?></h3>
                                <?php endif ?>
                                <?php if ($item['description']) : ?>
                                    <div class="andstudio-wysiwyg-container text-body-s mt-3 md:mt-4">
                                        <?php echo wp_kses_post($item['description']) ?>
                                    </div>
                                <?php endif ?>
                            </div>
                            <?php if ($item_video_url) : ?>
                                <div class="relative w-full mt-8 md:mt-0 aspect-video"><?php andstudio_background_video($item_video_url); ?></div>
                            <?php else : ?>
                                <?php if ($item['image']) {
                                    echo wp_get_attachment_image($item['image']['id'], 'full', false, array(
                                        'class' => 'w-full mt-8 hidden md:block md:w-full md:mt-0'
                                    ));
                                } ?>
                                <?php if ($item['mobile_image']) {
                                    echo wp_get_attachment_image($item['mobile_image']['id'], 'full', false, array(
                                        'class' => 'w-full mt-8 md:hidden'
                                    ));
                                } ?>
                            <?php endif ?>
                        </div>
                    <?php else : ?>
                        <!-- Horizontal Layout -->
                        <div class="pt-8 border-t border-neutral-grey-2 md:first:border-t-0 md:first:pt-0 md:pt-10 md:flex md:items-end md:gap-10 md:justify-between">
                            <div class="md:max-w-120.5 md:pb-4">
                                <?php if ($item['title']) : ?>
                                    <h3 class="text-h3"><?php echo esc_html($item['title']) ?></h3>
                                <?php endif ?>
                                <?php if ($item['description']) : ?>
                                    <div class="andstudio-wysiwyg-container text-body-s mt-3 md:mt-4">
                                        <?php echo wp_kses_post($item['description']) ?>
                                    </div>
                                <?php endif ?>
                            </div>
                            <?php if ($item_video_url) : ?>
                                <div class="relative w-full mt-8 md:mt-0 md:w-7/12 aspect-video"><?php andstudio_background_video($item_video_url); ?></div>
                            <?php elseif ($item['image']) : ?>
                                <?php echo wp_get_attachment_image($item['image']['id'], 'full', false, array(
                                    'class' => 'w-full mt-8 md:mt-0 md:w-7/12'
                                )); ?>
                            <?php endif ?>
                        </div>
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>