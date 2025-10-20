<?php
$anchor_title = get_field('anchor_title') ?? false;
$boxed = get_field('boxed') ?? false;
$subtitle = get_field('subtitle') ?? false;
$title = get_field('title') ?? false;
$text = get_field('text') ?? false;
$image = get_field('image') ?? false;
$image_mobile = get_field('image_mobile') ?? false;

?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <div class="flex flex-col gap-6 md:gap-16">
            <?php if ($subtitle) : ?>
                <h3 class="text-body-s md:text-body-l"><?php echo esc_html($subtitle) ?></h3>
            <?php endif ?>
            <?php if ($title) : ?>
                <h2 class="text-h1-mobile md:text-[5rem] md:leading-[5.5rem]"><?php echo esc_html($title) ?></h2>
            <?php endif ?>
        </div>

        <div class="mt-8 flex flex-col gap-8 md:mt-16 md:flex-row-reverse md:justify-between md:items-end">
            <div class="md:max-w-1/2">
                <?php if ($image) {
                    echo wp_get_attachment_image($image['id'], 'full', false, array(
                        'class' => 'w-full object-cover aspect-[353/305] md:hidden'
                    ));
                } ?>
                <?php if ($image_mobile) {
                    echo wp_get_attachment_image($image_mobile['id'], 'full', false, array(
                        'class' => 'hidden w-full object-cover aspect-[580/420] md:block'
                    ));
                } ?>
            </div>

            <?php if ($text) : ?>
                <div class="andstudio-wysiwyg-container text-body-s md:text-body-l md:max-w-120">
                    <?php echo wp_kses_post($text) ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>