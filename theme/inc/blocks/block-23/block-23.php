<?php
$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$title = get_field('title');
$items = get_field('items');

andstudio_display_block_preview_img($block);
?>

<section class="overflow-hidden <?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">
    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <?php if ($title) : ?>
            <h2 class="text-h1-mobile md:text-h1"><?php echo esc_html($title) ?></h2>
        <?php endif ?>

        <?php if ($items) : ?>
            <!-- Mobile layout -->
            <div data-swiper="block-23" class="mt-8 md:hidden">
                <div class="swiper-wrapper">
                    <?php foreach ($items as $item) : ?>
                        <div class="swiper-slide">
                            <?php if ($item['subtitle']) : ?>
                                <h3 class="text-body-m"><?php echo esc_html($item['subtitle']) ?></h3>
                            <?php endif ?>

                            <?php if ($item['image']) : ?>
                                <img src="<?php echo esc_url($item['image']['url']) ?>" alt="<?php echo esc_attr($item['image']['alt']) ?>" class="w-full object-cover aspect-[340/267] rounded-lg mt-4">
                            <?php endif ?>

                            <?php if ($item['title'] || $item['description'] || $item['button']) : ?>
                                <div class="flex flex-col gap-6 mt-2.5 py-8 px-5 bg-neutral-grey-1 rounded-lg">
                                    <?php if ($item['title']) : ?>
                                        <h3 class="text-body-m"><?php echo esc_html($item['title']) ?></h3>
                                    <?php endif ?>

                                    <?php if ($item['description']) : ?>
                                        <div class="andstudio-wysiwyg-container text-body-s">
                                            <?php echo wp_kses_post($item['description']) ?>
                                        </div>
                                    <?php endif ?>

                                    <?php if ($item['button']) :
                                        $target_attr = $item['button']['target'] ? $item['button']['target'] : '_self'; ?>
                                        <a class="text-body-s text-center bg-brand-primary text-neutral-white rounded-lg p-5 md:hover:bg-brand-secondary md:hover:text-neutral-black md:transition-colors duration-200" href="<?php echo esc_url($item['button']['url']) ?>" target="<?php echo esc_attr($target_attr) ?>"><?php echo esc_html($item['button']['title']) ?></a>
                                    <?php endif ?>
                                </div>
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>

            <!-- Desktop layout -->
            <div class="hidden md:grid md:grid-cols-3 md:mt-16 md:gap-5">
                <?php foreach ($items as $item) : ?>
                    <div>
                        <?php if ($item['subtitle']) : ?>
                            <h3 class="text-body-m md:mx-6"><?php echo esc_html($item['subtitle']) ?></h3>
                        <?php endif ?>

                        <?php if ($item['image']) : ?>
                            <img src="<?php echo esc_url($item['image']['url']) ?>" alt="<?php echo esc_attr($item['image']['alt']) ?>" class="md:w-full md:object-cover md:aspect-[340/267] md:rounded-xl md:mt-6">
                        <?php endif ?>

                        <?php if ($item['title'] || $item['description'] || $item['button']) : ?>
                            <div class="flex flex-col gap-6 mt-6 py-8 px-6 bg-neutral-grey-1 rounded-xl">
                                <?php if ($item['title']) : ?>
                                    <h3 class="text-body-m"><?php echo esc_html($item['title']) ?></h3>
                                <?php endif ?>

                                <?php if ($item['description']) : ?>
                                    <div class="andstudio-wysiwyg-container text-body-s">
                                        <?php echo wp_kses_post($item['description']) ?>
                                    </div>
                                <?php endif ?>

                                <?php if ($item['button']) :
                                    $target_attr = $item['button']['target'] ? $item['button']['target'] : '_self'; ?>
                                    <a class="text-body-xs text-center bg-brand-primary text-neutral-white rounded-lg px-5 py-3.5 md:hover:bg-brand-secondary md:hover:text-neutral-black md:transition-colors duration-200" href="<?php echo esc_url($item['button']['url']) ?>" target="<?php echo esc_attr($target_attr) ?>"><?php echo esc_html($item['button']['title']) ?></a>
                                <?php endif ?>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>