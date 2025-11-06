<?php
$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$title = get_field('title');
$download_link = get_field('download_link');
$items = get_field('items');

andstudio_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <div class="md:flex md:justify-between md:items-end">
            <?php if ($title) : ?>
                <h2 class="text-h1-mobile md:text-h1"><?php echo esc_html($title) ?></h2>
            <?php endif ?>

            <?php if ($download_link) : ?>
                <a class="hidden md:block md:text-brand-primary md:underline md:text-body-s" target="<?php echo esc_attr($download_link['target'] ? $download_link['target'] : '_self') ?>" href="<?php echo esc_url($download_link['url']) ?>">
                    <?php echo esc_html($download_link['title']) ?>
                </a>
            <?php endif ?>
        </div>

        <?php if ($items) : ?>
            <div class="flex flex-col gap-6 mt-6 md:mt-16 md:gap-10">
                <?php foreach ($items as $item) : ?>
                    <div class="pt-6 border-t border-neutral-grey-2 md:pt-10 md:first:pt-0 md:first:border-t-0 md:grid md:grid-cols-12 md:items-end">
                        <div class="md:col-span-5 md:col-start-1 md:max-w-[30rem] md:pb-4">
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
                            <?php echo wp_get_attachment_image($item['image']['id'], 'full', false, array(
                                'class' => 'object-cover w-full aspect-[353/248] mt-8 md:col-span-5 md:col-start-8 md:mt-0',
                            )); ?>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>