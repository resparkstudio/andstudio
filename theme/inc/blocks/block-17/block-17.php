<?php
$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$tabs = get_field('tabs');

$tabs_btn_wrap_classes = !$boxed ? 'md:-ml-18 md:-mr-18 md:bg-neutral-grey-1 md:pl-18' : '';

andstudio_display_block_preview_img($block);
?>

<section x-data='{"activeTab": 0}' class="overflow-hidden <?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <!-- Tab boxed buttons -->
    <?php if ($tabs) : ?>
        <div class="px-5 md:px-0 <?php echo esc_attr($tabs_btn_wrap_classes) ?>">
            <div class="flex gap-3 bg-brand-secondary p-1.5 rounded-lg md:gap-2 md:bg-transparent md:p-0">
                <?php foreach ($tabs as $index => $tab) : ?>
                    <button
                        @click="activeTab = <?php echo esc_attr($index) ?>"
                        :class="activeTab === <?php echo esc_attr($index) ?> ? 'bg-neutral-white' : 'md:bg-brand-secondary'"
                        class="w-full flex items-center justify-center gap-2 p-2 rounded-md md:rounded-b-none md:w-auto md:py-3 md:px-12">
                        <div x-show="activeTab === <?php echo esc_attr($index) ?>" class="rounded-full bg-brand-primary w-1.5 h-1.5"></div>
                        <?php echo esc_html($tab['tab_name']) ?>
                    </button>
                <?php endforeach ?>
            </div>
        </div>
    <?php endif ?>

    <!-- Tab content -->
    <div class="container bg-neutral-white md:rounded-xl md:rounded-tl-none md:pt-16 md:pb-14">
        <?php if ($tabs) : ?>
            <?php foreach ($tabs as $index => $tab) : ?>
                <div x-show="activeTab === <?php echo esc_attr($index) ?>" class="mt-8 md:mt-0">
                    <div class="md:max-w-[35rem]">
                        <?php if ($tab['title']) : ?>
                            <h2 class="text-h1-mobile md:text-h1"><?php echo esc_html($tab['title']) ?></h2>
                        <?php endif ?>

                        <?php if ($tab['description']) : ?>
                            <div class="andstudio-wysiwyg-container text-body-s mt-4 md:mt-6">
                                <?php echo wp_kses_post($tab['description']) ?>
                            </div>
                        <?php endif ?>
                    </div>

                    <?php if ($tab['images']) : ?>
                        <div data-swiper="block-17" class="mt-8 md:mt-16 md:overflow-hidden">
                            <div class="swiper-wrapper md:aspect-[1240/460]">
                                <?php foreach ($tab['images'] as $image) : ?>
                                    <div class="swiper-slide">
                                        <div class="block-17_img-wrap aspect-[620/460] w-full md:scale-75">
                                            <img class="w-full h-full object-cover" src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($image['alt']) ?>">
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>

                            <div data-swiper-pagination class="flex gap-1.5 mt-2.5 justify-center md:mt-2"></div>
                        </div>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</section>