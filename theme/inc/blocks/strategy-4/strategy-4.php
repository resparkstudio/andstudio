<?php
$anchor_title = get_field('anchor_title') ?? false;
$boxed = get_field('boxed') ?? false;
$subtitle = get_field('subtitle') ?? false;
$title = get_field('title') ?? false;
$text = get_field('text') ?? false;
$first_image = get_field('first_image') ?? false;
$first_image_mobile = get_field('first_image_mobile') ?? false;
$second_image = get_field('second_image') ?? false;
$second_image_mobile = get_field('second_image_mobile') ?? false;

?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <div class="flex flex-col gap-6 md:gap-8">
            <?php if ($subtitle) : ?>
                <h3 class="text-body-s md:text-body-l"><?php echo esc_html($subtitle) ?></h3>
            <?php endif ?>
            <?php if ($title) : ?>
                <h2 class="text-h1-mobile md:text-h2"><?php echo esc_html($title) ?></h2>
            <?php endif ?>
        </div>

        <div class="flex flex-col gap-8 mt-8 md:grid md:grid-cols-12 md:mt-16 md:items-end md:gap-5">

            <?php if ($first_image_mobile) {
                echo wp_get_attachment_image($first_image_mobile['id'], 'full', false, array(
                    'class' => 'w-full object-cover aspect-[353/305] md:hidden'
                ));
            } ?>

            <?php if ($text) : ?>
                <div class="andstudio-wysiwyg-container text-body-s md:col-span-4 md:pb-16">
                    <?php echo wp_kses_post($text) ?>
                </div>
            <?php endif ?>

            <?php if ($second_image_mobile) {
                echo wp_get_attachment_image($second_image_mobile['id'], 'full', false, array(
                    'class' => 'w-full object-cover aspect-[353/380] md:hidden'
                ));
            } ?>

            <?php if ($first_image) {
                echo wp_get_attachment_image($first_image['id'], 'full', false, array(
                    'class' => 'hidden w-full object-cover aspect-[382/488] md:block md:col-span-4'
                ));
            } ?>

            <?php if ($second_image) {
                echo wp_get_attachment_image($second_image['id'], 'full', false, array(
                    'class' => 'hidden w-full object-cover aspect-[382/600] md:block md:col-span-4'
                ));
            } ?>
        </div>
    </div>
</section>