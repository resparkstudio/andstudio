<?php
$anchor_title = get_field('anchor_title') ?? false;
$is_full_width = get_field('full-width') ?? false;
$image = get_field('image') ?? false;
$title = get_field('title') ?? false;
$description = get_field('description') ?? false;
$download_title = get_field('download_title') ?? false;
$download_url = get_field('download_url') ?? false;
$download_contents = get_field('download_contents') ?? false;

?>
<?php if ($image) : ?>
    <div class="hero-block_image w-full aspect-[393/264] md:sticky md:top-0 md:aspect-[1440/720] md:w-full md:h-full md:overflow-hidden">
        <?php echo wp_get_attachment_image($image['id'], 'full', false, array(
            'class' => 'object-cover w-full h-full',
            'data-hero-reveal' => 'image'
        )); ?>
    </div>
<?php endif ?>
<section data-hero-scroll="hero-section" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>" class="bg-neutral-grey-1 pb-12 overflow-hidden md:absolute md:top-0 md:aspect-[1440/720] md:w-full md:pb-0 md:bg-transparent">

    <div class="container-lg -mt-32 relative z-10 md:pb-12 md:mt-0 md:h-full md:flex md:flex-col md:justify-end overflow-hidden">
        <div data-hero-reveal="banner" class="bg-neutral-white will-change-transform rounded-lg p-5 pt-10 md:rounded-xl md:p-10 md:pl-14 md:flex md:justify-between md:gap-10">
            <?php if ($title && $description) : ?>
                <div class="text-neutral-black">
                    <?php if ($title) : ?>
                        <h1 class="text-h1-mobile md:text-h1"><?php echo esc_html($title) ?></h1>
                    <?php endif ?>
                    <?php if ($description) : ?>
                        <div class="andstudio-wysiwyg-container mt-6 text-body-s md:mt-8 md:max-w-xl">
                            <?php echo wp_kses_post($description) ?>
                        </div>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <?php if ($download_url) : ?>
                <div class="mt-8 p-5 rounded-lg bg-brand-primary md:mt-0 md:flex md:flex-col md:justify-between md:min-w-[20.25rem]">
                    <?php if ($download_title) : ?>
                        <h2 class="text-body-m text-neutral-white md:text-h3"><?php echo esc_html($download_title) ?></h2>
                    <?php endif ?>
                    <a class="text-body-s text-neutral-white mt-4 pt-3 flex items-center justify-between border-t border-neutral-white" target="_blank" href="<?php echo esc_url($download_url) ?>">
                        <?php esc_html_e('Download', 'andstudio') ?>
                        <svg class="w-8 h-8 text-neutral-white" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.9997 5.3335V20.0002M15.9997 20.0002L9.33301 13.3335M15.9997 20.0002L22.6663 13.3335" stroke="currentColor" />
                            <path d="M6.66699 24H25.3337" stroke="currentColor" />
                        </svg>
                    </a>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>