<?php
$anchor_title = get_field('anchor_title') ?? false;
$boxed = get_field('boxed') ?? false;
$title = get_field('title') ?? false;
$items = get_field('items') ?? false;

andstudio_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?> overflow-hidden" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <?php if ($title) : ?>
            <h2 class="text-h1-mobile md:text-h1"><?php echo esc_html($title) ?></h2>
        <?php endif ?>

        <?php if ($items) : ?>
            <div data-swiper="block-6" class="mt-6 md:mt-16">
                <div class="swiper-wrapper md:grid md:grid-cols-3 md:gap-5">
                    <?php foreach ($items as $item) :
                        $title = $item['title'];
                        $description = $item['description'];
                    ?>
                        <div class="swiper-slide h-auto md:col-span-1">
                            <div class="bg-brand-secondary h-full rounded-lg py-8 px-5 md:px-8 md:py-15 md:rounded-xl">
                                <?php if ($title) : ?>
                                    <h3 class="text-body-m md:text-h3"><?php echo esc_html($title) ?></h3>
                                <?php endif ?>

                                <?php if ($description) : ?>
                                    <div class="andstudio-wysiwyg-container text-body-s mt-4 md:mt-10">
                                        <?php echo wp_kses_post($description) ?>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endif ?>
    </div>
</section>