<?php
$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$title = get_field('title');
$description = get_field('description');
$images = get_field('images');

if ($images) {
    $first_image = array_shift($images); // tall left image (if there was at least 1)
    $remaining_count = count($images);

    // split remaining into 2 rows, top gets ceil(remaining/2)
    $top_count = ceil($remaining_count / 2);
    $top_row = array_slice($images, 0, $top_count);
    $bottom_row = array_slice($images, $top_count);
}

andstudio_display_block_preview_img($block)
?>

<section class="overflow-hidden md:overflow-visible <?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14 md:flex md:flex-col">
        <div>
            <?php if ($title) : ?>
                <h2 class="text-h1-mobile md:text-h1 md:max-w-135"><?php echo esc_html($title) ?></h2>
            <?php endif ?>

            <?php if ($description) : ?>
                <div class="andstudio-wysiwyg-container text-body-s mt-6 md:mt-8 md:max-w-145">
                    <?php echo wp_kses_post($description) ?>
                </div>
            <?php endif ?>
        </div>

        <?php if ($images) : ?>
            <!-- Mobile slider -->
            <div data-swiper="block-13" class="mt-8 md:hidden">
                <div class="swiper-wrapper">
                    <?php foreach ($images as $image) : ?>
                        <div class="swiper-slide">
                            <?php echo wp_get_attachment_image($image['id'], 'full', false, array(
                                'class' => 'object-cover w-full',
                            )); ?>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>

            <!-- Desktop horizontal scroll -->
            <div data-scroll-gallery="track" class="hidden md:block mt-16 relative">
                <!-- Track -->
                <div class="h-screen w-dvw -ml-32 pl-32 overflow-hidden sticky top-0 flex">
                    <div data-scroll-gallery="wrap" class="h-full flex gap-5 min-h-0">
                        <!-- First image -->
                        <img class="h-full shrink-0" src="<?php echo esc_url($first_image['url']) ?>" alt="">

                        <!-- Smaller rows wrap -->
                        <div class="flex flex-col gap-5">
                            <!-- Top row -->
                            <div class="grow flex gap-5 min-h-0">
                                <?php foreach ($top_row as $image) : ?>
                                    <img class="h-full shrink-0" src="<?php echo esc_url($image['url']) ?>" alt="">
                                <?php endforeach ?>
                            </div>
                            <!-- Bottom row -->
                            <div class="grow flex gap-5 min-h-0">
                                <?php foreach ($bottom_row as $image) : ?>
                                    <img class="h-full shrink-0" src="<?php echo esc_url($image['url']) ?>" alt="">
                                <?php endforeach ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>


</section>