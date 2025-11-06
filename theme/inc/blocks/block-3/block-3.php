<?php
$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$subtitle = get_field('subtitle');
$title = get_field('title');
$text = get_field('text');
$link = get_field('link');
$image = get_field('image');

andstudio_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14 md:flex md:justify-between">
        <div class="md:max-w-120">
            <?php if ($subtitle) : ?>
                <h3 class="text-body-s md:text-body-l"><?php echo esc_html($subtitle) ?></h3>
            <?php endif ?>
            <?php if ($title) : ?>
                <h2 class="text-h1-mobile mt-6 md:text-h1 md:mt-8"><?php echo esc_html($title) ?></h2>
            <?php endif ?>
            <?php if ($text) : ?>
                <div class="andstudio-wysiwyg-container text-body-s mt-6 md:mt-16">
                    <?php echo wp_kses_post($text) ?>
                </div>
            <?php endif ?>
            <?php if ($link) :
                $link_target = $link['target'] ? $link['target'] : '_self'; ?>
                <a class="hidden md:block mt-8 text-brand-primary underline" href="<?php echo esc_url($link['url']) ?>" target="<?php echo esc_attr($link_target) ?>"><?php echo esc_html($link['title']) ?></a>
            <?php endif ?>
        </div>

        <?php if ($image) : ?>
            <div class="mt-8 md:w-1/2">
                <?php echo wp_get_attachment_image($image['id'], 'full', false, array(
                    'class' => 'w-full object-cover aspect-[353/380] md:aspect-[580/600]'
                )); ?>
            </div>
        <?php endif ?>
    </div>
</section>