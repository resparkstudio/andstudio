<?php
$anchor_title = get_field('anchor_title') ?? false;
$boxed = get_field('boxed') ?? false;
$subtitle = get_field('subtitle') ?? false;
$title = get_field('title') ?? false;
$text = get_field('text') ?? false;
$desktop_image = get_field('desktop_image') ?? false;
$mobile_image = get_field('mobile_image') ?? false;

?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">

    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <?php if ($subtitle || $title) : ?>
            <div class="flex flex-col gap-6 md:gap-8 md:max-w-[57.625rem]">
                <?php if ($subtitle) : ?>
                    <h3 class="text-body-s md:text-body-l"><?php echo esc_html($subtitle) ?></h3>
                <?php endif ?>
                <?php if ($title) : ?>
                    <h2 class="text-h1-mobile md:text-h1"><?php echo esc_html($title) ?></h2>
                <?php endif ?>
            </div>

            <?php if ($text) : ?>
                <div class="andstudio-wysiwyg-container text-body-s mt-4 md:mt-16 md:max-w-[33.125rem] md:ml-auto md:text-body-l">
                    <?php echo wp_kses_post($text) ?>
                </div>
            <?php endif ?>

            <?php if ($desktop_image || $mobile_image) : ?>
                <div class="mt-8 md:mt-10">
                    <?php echo wp_get_attachment_image($mobile_image['id'], 'full', false, array(
                        'class' => 'w-full object-cover aspect-[353/305] md:hidden'
                    )); ?>
                    <?php echo wp_get_attachment_image($desktop_image['id'], 'full', false, array(
                        'class' => 'hidden w-full object-cover aspect-[1184/500] md:block'
                    )); ?>
                </div>
            <?php endif ?>
        <?php endif ?>
    </div>

</section>