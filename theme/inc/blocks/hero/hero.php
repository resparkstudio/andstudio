<?php
$is_full_width = get_field('full-width') ?? false;
$is_logotype = get_field('logotype') ?? false;
$logo_image = get_field('logo_image') ?? false;
$image = get_field('image') ?? false;
$title = get_field('title') ?? false;
$description = get_field('description') ?? false;
$download_title = get_field('download_title') ?? false;
$download_link = get_field('download_link') ?? false;
$download_contents = get_field('download_contents') ?? false;

$banner_width_class = $is_full_width ? 'md:w-full' : '';
?>
<?php if ($image) : ?>
    <div class="hero-block_image w-full aspect-[393/264] md:sticky md:top-0 md:aspect-[1440/720] md:w-full md:h-full md:overflow-hidden">
        <?php echo wp_get_attachment_image($image['id'], 'full', false, array(
            'class' => 'object-cover w-full h-full will-change-transform',
            'data-hero-reveal' => 'image'
        )); ?>
    </div>
<?php endif ?>
<section data-hero-scroll="hero-section" class="bg-neutral-grey-1 pb-12 md:overflow-hidden md:absolute md:top-0 md:aspect-[1440/720] md:w-full md:pb-0 md:bg-transparent">

    <div class="container-lg -mt-32 relative z-10 md:pb-12 md:mt-0 md:h-full md:flex md:flex-col md:justify-end overflow-hidden md:items-start">
        <div data-hero-reveal="banner" class="flex gap-5 w-full will-change-transform">
            <div class="bg-neutral-white rounded-lg p-5 pt-10 md:rounded-xl md:p-10 md:pl-14 md:flex md:justify-between md:gap-16 <?php echo esc_attr($banner_width_class) ?>">

                <div class="md:flex md:flex-col md:justify-between">
                    <?php if ($title) : ?>
                        <h1 class="text-h1-mobile md:text-h1"><?php echo esc_html($title) ?></h1>
                    <?php endif ?>
                    <?php if ($description) : ?>
                        <div class="flex flex-col gap-2 mt-6 md:flex-row md:gap-10 md:mt-8">
                            <?php foreach ($description as $block) : ?>
                                <div class="andstudio-wysiwyg-container text-body-s md:max-w-135">
                                    <?php echo wp_kses_post($block['text_block']) ?>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                </div>


                <?php if ($download_link && !$is_logotype) : ?>
                    <div class="mt-8 p-5 rounded-lg bg-brand-primary text-text-primary md:mt-0 md:flex md:flex-col md:justify-between md:min-w-[20.25rem] md:rounded-xl">
                        <div>
                            <?php if ($download_title) : ?>
                                <h2 class="text-body-m text-neutral-white md:text-h3"><?php echo esc_html($download_title) ?></h2>
                            <?php endif ?>

                            <?php if ($download_contents) : ?>
                                <ul class="hidden md:flex md:flex-col md:gap-1 md:mt-4">
                                    <?php foreach ($download_contents as $item) : ?>
                                        <li class="text-neutral-white text-body-xs"><?php echo esc_html($item['name']) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            <?php endif ?>
                        </div>

                        <a class="text-body-s text-neutral-white mt-4 pt-3 flex items-center justify-between border-t border-neutral-white md:mt-6" target="<?php echo esc_attr($download_link['target'] ? $download_link['target'] : '_self') ?>" href="<?php echo esc_url($download_link['url']) ?>">
                            <?php echo esc_htmL($download_link['title']) ?>
                            <svg class="w-8 h-8 text-neutral-white" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.9997 5.3335V20.0002M15.9997 20.0002L9.33301 13.3335M15.9997 20.0002L22.6663 13.3335" stroke="currentColor" />
                                <path d="M6.66699 24H25.3337" stroke="currentColor" />
                            </svg>
                        </a>
                    </div>
                <?php endif ?>

                <?php if ($download_link && $is_logotype) : ?>
                    <a class="bg-brand-primary text-body-s text-text-primary flex justify-between items-center rounded-lg mt-8 w-full p-5 md:hidden" target="<?php echo esc_attr($download_link['target'] ? $download_link['target'] : '_self') ?>" href="<?php echo esc_url($download_link['url']) ?>">
                        <?php echo esc_html($download_link['title']) ?>
                        <svg class="w-8 h-8 text-neutral-white" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.9997 5.3335V20.0002M15.9997 20.0002L9.33301 13.3335M15.9997 20.0002L22.6663 13.3335" stroke="currentColor" />
                            <path d="M6.66699 24H25.3337" stroke="currentColor" />
                        </svg>
                    </a>
                <?php endif ?>
            </div>

            <!-- Desktop logo block -->
            <?php if ($download_link && $is_logotype) : ?>
                <div class="hidden md:flex md:flex-col md:gap-5 md:max-w-92.5">
                    <?php if ($logo_image) : ?>
                        <?php echo wp_get_attachment_image($logo_image['id'], 'full', false, array(
                            'class' => 'object-cover w-full rounded-xl',
                        )); ?>
                    <?php endif ?>

                    <?php if ($download_link) : ?>
                        <a class="bg-brand-primary text-body-s text-text-primary flex justify-between items-center rounded-xl w-full p-5 grow md:hover:bg-brand-secondary md:hover:text-text-secondary transition-colors duration-200" target="<?php echo esc_attr($download_link['target'] ? $download_link['target'] : '_self') ?>" href="<?php echo esc_url($download_link['url']) ?>">
                            <?php echo esc_html($download_link['title']) ?>
                            <svg class="w-8 h-8" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.9997 5.3335V20.0002M15.9997 20.0002L9.33301 13.3335M15.9997 20.0002L22.6663 13.3335" stroke="currentColor" />
                                <path d="M6.66699 24H25.3337" stroke="currentColor" />
                            </svg>
                        </a>
                    <?php endif ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>