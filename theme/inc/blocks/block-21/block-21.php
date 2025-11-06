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

        <?php if ($items) : ?>
            <div class="flex flex-col gap-8 mt-8 md:mt-16 md:gap-10">
                <?php foreach ($items as $item) : ?>
                    <!-- Horizontal Layout -->
                    <div class="pt-8 border-t border-neutral-grey-2 md:pt-10 md:flex md:items-end md:gap-10 md:justify-between">
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
                        <?php if ($item['image']) : ?>
                            <img class="hidden md:block md:mt-0 md:w-7/12 md:object-cover md:aspect-[678/338] shrink-0" src="<?php echo esc_url($item['image']['url']) ?>" alt="<?php echo esc_attr($item['image']['alt']) ?>">
                        <?php endif ?>
                        <?php if ($item['mobile_image']) : ?>
                            <img class="w-full mt-8 aspect-[353/224] object-cover md:hidden" src="<?php echo esc_url($item['mobile_image']['url']) ?>" alt="<?php echo esc_attr($item['mobile_image']['alt']) ?>">
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>