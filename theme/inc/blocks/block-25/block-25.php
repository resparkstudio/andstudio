<?php

$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$title = get_field('title');
$description = get_field('description');
$link = get_field('link');
$image = get_field('image');
$mobile_image = get_field('mobile_image');

andstudio_display_block_preview_img($block);
?>



<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <div class="flex flex-col gap-6 md:grid md:grid-cols-2 md:gap-y-8 md:gap-x-5">
            <?php if ($title) : ?>
                <h2 class="text-h1-mobile md:text-h1 md:max-w-135"><?php echo esc_html($title) ?></h2>
            <?php endif ?>

            <div class="md:row-start-2 md:col-start-2 md:flex md:justify-end">
                <div class="md:max-w-145">
                    <?php if ($description) : ?>
                        <div class="andstudio-wysiwyg-container text-body-s md:text-body-m">
                            <?php echo wp_kses_post($description) ?>
                        </div>
                    <?php endif ?>

                    <?php if ($link) :
                        $link_target = $link['target'] ? $link['target'] : '_self'; ?>
                        <a class="hidden md:block mt-8 text-brand-primary underline" href="<?php echo esc_url($link['url']) ?>" target="<?php echo esc_attr($link_target) ?>"><?php echo esc_html($link['title']) ?></a>
                    <?php endif ?>
                </div>
            </div>
        </div>

        <?php if ($image) : ?>
            <img class="hidden md:block md:mt-16 md:w-full md:object-cover md:rounded-xl" src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($image['alt']) ?>">
        <?php endif ?>
        <?php if ($mobile_image) : ?>
            <img class=" w-full object-cover mt-8 rounded-lg md:hidden" src="<?php echo esc_url($mobile_image['url']) ?>" alt="<?php echo esc_attr($mobile_image['alt']) ?>">
        <?php endif ?>
    </div>
</section>