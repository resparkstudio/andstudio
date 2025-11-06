<?php
$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$title = get_field('title');
$image = get_field('image');
$mobile_image = get_field('mobile_image');
$items = get_field('items');

andstudio_display_block_preview_img($block);
?>

<section class="overflow-hidden <?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">
    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <?php if ($title) : ?>
            <h2 class="text-h1-mobile md:text-h1"><?php echo esc_html($title) ?></h2>
        <?php endif ?>

        <?php if ($image) : ?>
            <img class="hidden md:block md:mt-16 md:w-full md:object-cover md:rounded-xl" src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($image['alt']) ?>">
        <?php endif ?>

        <?php if ($mobile_image) : ?>
            <img class=" w-full object-cover mt-8 rounded-lg md:hidden" src="<?php echo esc_url($mobile_image['url']) ?>" alt="<?php echo esc_attr($mobile_image['alt']) ?>">
        <?php endif ?>

        <?php if ($items) : ?>
            <!-- Mobile layout -->
            <div data-swiper="block-26" class="mt-8 md:hidden">
                <div class="swiper-wrapper">
                    <?php foreach ($items as $item) : ?>
                        <div class="swiper-slide">
                            <?php if ($item['title']) : ?>
                                <h3 class="text-body-m mx-5"><?php echo esc_html($item['title']) ?></h3>
                            <?php endif ?>

                            <?php if ($item['description']) : ?>
                                <div class="andstudio-wysiwyg-container mt-4 text-body-s py-8 px-5 bg-neutral-grey-1 rounded-lg">
                                    <?php echo wp_kses_post($item['description']) ?>
                                </div>
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>

            <!-- Desktop layout -->
            <div class="hidden md:grid md:grid-cols-3 md:mt-10 md:gap-5">
                <?php foreach ($items as $item) : ?>
                    <div>
                        <?php if ($item['title']) : ?>
                            <h3 class="text-body-m md:mx-6"><?php echo esc_html($item['title']) ?></h3>
                        <?php endif ?>

                        <?php if ($item['description']) : ?>
                            <div class="andstudio-wysiwyg-container md:mt-6 md:text-body-s md:py-8 md:px-6 bg-neutral-grey-1 rounded-xl">
                                <?php echo wp_kses_post($item['description']) ?>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>