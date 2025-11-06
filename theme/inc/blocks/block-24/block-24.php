<?php
$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$title = get_field('title');
$description = get_field('description');
$link = get_field('link');
$images = get_field('images');

andstudio_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">
    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <div class="flex flex-col gap-8 md:grid md:grid-cols-2 md:gap-y-8 md:gap-x-5">
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

        <?php if ($images) : ?>
            <div class="flex flex-col mt-8 gap-2.5 md:mt-16 md:grid md:grid-cols-3 md:gap-5">
                <?php foreach ($images as $image) : ?>
                    <img class="w-full object-cover aspect-[353/436]" src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($image['alt']) ?>">
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>