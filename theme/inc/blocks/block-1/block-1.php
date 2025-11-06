<?php
$anchor_title = get_field('anchor_title') ?? false;
$boxed = get_field('boxed') ?? false;
$bento_items = get_field('bento_items') ?? false;
$numbered_items = get_field('numbered_items') ?? false;

$bento_grid_classes = ['md:col-span-5 md:row-span-2', 'md:col-span-7', 'md:col-span-7'];

andstudio_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">

        <?php if ($bento_items) : ?>
            <div class="grid grid-cols-1 gap-2.5 md:grid-cols-12 md:grid-rows-2 md:gap-5">
                <?php foreach ($bento_items as $index => $bento_item) :
                    $image_id = $bento_item['image']['ID'] ?? false;
                    $subtitle = $bento_item['subtitle'];
                    $title = $bento_item['title'];
                ?>
                    <div class="py-4 px-5 rounded-xl border border-neutral-grey-2 text-neutral-black <?php echo esc_attr($bento_grid_classes[$index]) ?> md:py-5 md:px-10 md:items-center">
                        <?php if ($image_id) {
                            echo wp_get_attachment_image($image_id, 'large', false, array('class' => 'mb-2.5 md:mb-5'));
                        }  ?>
                        <?php if ($subtitle) : ?>
                            <h3 class="text-body-s md:text-body-l"><?php echo esc_html($subtitle) ?></h3>
                        <?php endif ?>
                        <?php if ($title) : ?>
                            <h2 class="text-body-l mt-2.5 md:text-h2 md:mt-4"><?php echo esc_html($title) ?></h2>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <?php if ($numbered_items) : ?>
            <ul class="mt-5 flex flex-col gap-2.5 text-body-s md:text-body-l md:gap-5">
                <?php foreach ($numbered_items as $index => $numbered_item) :
                    $text = $numbered_item['text'];
                ?>
                    <li class="flex gap-5 bg-brand-secondary rounded-xl py-4 px-5 md:gap-8 md:py-6 md:px-10">
                        <span><?php echo esc_html($index + 1) ?></span>
                        <?php echo esc_html($text) ?>
                    </li>
                <?php endforeach ?>
            </ul>
        <?php endif ?>

    </div>
</section>