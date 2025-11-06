<?php
$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$title = get_field('title');
$description = get_field('description');
$items = get_field('items');

andstudio_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <div class="md:grid md:grid-cols-2 md:gap-y-6 md:gap-x-10">
            <?php if ($title) : ?>
                <h2 class="text-h1-mobile md:text-h1 md:col-span-1"><?php echo esc_html($title) ?></h2>
            <?php endif ?>

            <?php if ($description) : ?>
                <div class="andstudio-wysiwyg-container text-body-s mt-6 md:text-body-m md:col-span1 md:col-start-2 md:row-start-2 md:mt-0 md:max-w-[35rem] md:ml-auto">
                    <?php echo wp_kses_post($description) ?>
                </div>
            <?php endif ?>
        </div>

        <?php if ($items) : ?>
            <div class="mt-6 flex flex-col gap-6 md:mt-16 md:grid md:grid-cols-2 md:gap-10">
                <?php foreach ($items as $item) : ?>
                    <div class="pt-6 border-t border-neutral-grey-2 first:pt-0 first:border-t-0 md:pt-0 md:border-t-0">
                        <?php echo wp_get_attachment_image($item['image']['id'], 'full', false, array(
                            'class' => 'object-cover w-full aspect-[572/369]',
                        )); ?>

                        <?php if ($item['description']) : ?>
                            <div class="andstudio-wysiwyg-container text-body-s mt-2.5 md:mt-4">
                                <?php echo wp_kses_post($item['description']) ?>
                            </div>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>