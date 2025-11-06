<?php
$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$title = get_field('title');
$description = get_field('description');
$images = get_field('images');

andstudio_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">
    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">

        <div class="md:max-w-145">
            <?php if ($title) : ?>
                <h2 class="text-h1-mobile md:text-h1"><?php echo esc_html($title) ?></h2>
            <?php endif ?>
            <?php if ($description) : ?>
                <div class="andstudio-wysiwyg-container mt-6 text-body-s md:mt-8">
                    <?php echo wp_kses_post($description) ?>
                </div>
            <?php endif ?>
        </div>

        <?php if ($images) : ?>
            <div class="mt-8 flex flex-col gap-2.5 md:grid md:grid-cols-3 md:gap-5 md:mt-16">
                <?php foreach ($images as $image) : ?>
                    <?php if ($image['image']) : ?>
                        <img class="hidden md:block md:object-cover md:w-full md:aspect-[381/472]" src="<?php echo esc_url($image['image']['url']) ?>" alt="<?php echo esc_attr($image['image']['alt']) ?>">
                    <?php endif ?>
                    <?php if ($image['mobile_image']) : ?>
                        <img class="object-cover w-full aspect-[353/436] md:hidden" src="<?php echo esc_url($image['mobile_image']['url']) ?>" alt="<?php echo esc_attr($image['mobile_image']['alt']) ?>">
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>