<?php
$anchor_title = get_field('anchor_title') ?? false;
$boxed = get_field('boxed') ?? false;
$title = get_field('title') ?? false;
$small_image = get_field('small_image') ?? false;
$description = get_field('description') ?? false;
$link = get_field('link') ?? false;
$image = get_field('image') ?? false;

andstudion_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <?php if ($title) : ?>
            <h2 class="text-h1-mobile md:text-h1"><?php echo esc_html($title) ?></h2>
        <?php endif ?>

        <div class="mt-6 md:mt-16 md:flex md:justify-between">
            <div class="md:max-w-121">
                <?php if ($small_image) {
                    echo wp_get_attachment_image($small_image['id'], 'full', false, array(
                        'class' => 'object-cover hidden md:block md:h-35 md:mb-10'
                    ));
                } ?>

                <?php if ($description) : ?>
                    <div class="andstudio-wysiwyg-container text-body-s mb-6 md:text-body-l md:mb-5">
                        <?php echo wp_kses_post($description) ?>
                    </div>
                <?php endif ?>

                <?php if ($link) :
                    $link_target = $link['target'] ? $link['target'] : '_self'; ?>
                    <a class="text-body-s text-brand-primary underline inline-block" href="<?php echo esc_url($link['url']) ?>" target="<?php echo esc_attr($link_target) ?>"><?php echo esc_html($link['title']) ?></a>
                <?php endif ?>
            </div>

            <?php if ($image) {
                echo wp_get_attachment_image($image['id'], 'full', false, array(
                    'class' => 'w-full object-cover aspect-square mt-8 md:mt-0 md:w-1/2'
                ));
            } ?>
        </div>
    </div>
</section>