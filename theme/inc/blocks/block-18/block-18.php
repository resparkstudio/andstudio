<?php
$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$title = get_field('title');
$description = get_field('description');
$link = get_field('link');
$button = get_field('button');
$image = get_field('image');
$mobile_image = get_field('mobile_image');

andstudio_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">
    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <?php if ($title) : ?>
            <h2 class="text-h1-mobile md:text-h1 md:max-w-135"><?php echo esc_html($title) ?></h2>
        <?php endif ?>

        <?php if ($description) : ?>
            <div class="andstudio-wysiwyg-container text-body-s mt-6 md:mt-8 md:max-w-145.5">
                <?php echo wp_kses_post($description) ?>
            </div>
        <?php endif ?>

        <?php if ($button || $link) : ?>
            <div class="mt-6 flex flex-col md:mt-8 md:flex-row md:items-center md:gap-6">
                <?php if ($button) :
                    $target_attr = $button['target'] ? $button['target'] : '_self'; ?>
                    <a class="text-body-s text-center bg-brand-primary text-neutral-white rounded-lg p-5 md:hover:bg-brand-secondary md:hover:text-neutral-black md:transition-colors duration-200" href="<?php echo esc_url($button['url']) ?>" target="<?php echo esc_attr($target_attr) ?>"><?php echo esc_html($button['title']) ?></a>
                <?php endif ?>

                <?php if ($link) :
                    $link_target = $link['target'] ? $link['target'] : '_self'; ?>
                    <a class="hidden text-body-s text-brand-primary underline md:inline-block" href="<?php echo esc_url($link['url']) ?>" target="<?php echo esc_attr($link_target) ?>"><?php echo esc_html($link['title']) ?></a>
                <?php endif ?>
            </div>
        <?php endif ?>

        <?php if ($image) {
            echo wp_get_attachment_image($image['id'], 'full', false, array(
                'class' => 'hidden md:block md:w-full md:mt-16'
            ));
        } ?>

        <?php if ($mobile_image) {
            echo wp_get_attachment_image($mobile_image['id'], 'full', false, array(
                'class' => 'w-full mt-8 md:hidden'
            ));
        } ?>
    </div>
</section>