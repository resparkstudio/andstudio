<?php
$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$title = get_field('title');
$description = get_field('description');
$colors = get_field('colors');

andstudio_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">
    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <div class="flex flex-col gap-6 md:grid md:grid-cols md:gap-y-8 md:gap-x-5">
            <?php if ($title) : ?>
                <h2 class="text-h1-mobile md:text-h1 md:max-w-135"><?php echo esc_html($title) ?></h2>
            <?php endif ?>

            <div class="md:row-start-2 md:col-start-2 md:flex md:flex-col md:items-end">
                <?php if ($description) : ?>
                    <div class="andstudio-wysiwyg-container text-body-s md:text-body-m md:max-w-145">
                        <?php echo wp_kses_post($description) ?>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <?php if ($colors) : ?>
            <div class="flex h-54 mt-8 md:mt-16 md:h-96">
                <?php foreach ($colors as $color) :
                    $text_color_class = $color['text_color'] === 'light' ? 'text-neutral-white' : 'text-neutral-black'; ?>
                    <div style="background-color: <?php echo esc_attr($color['color']) ?>; width: <?php echo esc_attr($color['width']) ?>%;" class="p-1.5 md:p-3 <?php echo esc_attr($text_color_class) ?>">
                        <span class="text-body-xs"><?php echo esc_html($color['width']) ?>%</span>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>