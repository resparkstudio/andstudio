<?php
$anchor_title = get_field('anchor_title') ?? false;
$boxed = get_field('boxed') ?? false;
$subtitle = get_field('subtitle') ?? false;
$title = get_field('title') ?? false;
$description = get_field('description') ?? false;

andstudion_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-32">
        <?php if ($subtitle) : ?>
            <h3 class="text-body-m mb-8 md:text-body-l"><?php echo esc_html($subtitle) ?></h3>
        <?php endif ?>
        <?php if ($title) : ?>
            <h2 class="text-h1-mobile mb-8 md:text-h2 md:mb-16"><?php echo esc_html($title) ?></h2>
        <?php endif ?>
        <?php if ($description) : ?>
            <div class="andstudio-wysiwyg-container text-body-s md:max-w-120">
                <?php echo wp_kses_post($description) ?>
            </div>
        <?php endif ?>
    </div>
</section>