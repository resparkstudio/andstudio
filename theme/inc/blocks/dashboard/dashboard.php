<?php
$image = get_field('image');
$mobile_image = get_field('mobile_image');
$banner = get_field('banner');
$pages = get_field('pages');
$sub_brands = get_field('sub_brands');
?>

<?php if ($mobile_image) : ?>
    <img class="w-full aspect-[393/264] object-cover md:hidden" src="<?php echo esc_url($mobile_image['url']) ?>" alt="<?php echo esc_attr($mobile_image['alt']) ?>">
<?php endif ?>
<?php if ($image) : ?>
    <img class="hidden md:block md:w-full md:aspect-[1440/458] md:object-cover" src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($image['alt']) ?>">
<?php endif ?>

<section class="bg-neutral-grey-1 pb-12 md:pb-16">
    <div class="container md:px-32 -mt-34 relative z-10 md:-mt-50">
        <!-- Banner -->
        <?php if ($banner) : ?>
            <div class="bg-neutral-white rounded-lg p-5 pt-10 md:flex md:justify-between md:p-10 md:rounded-xl md:gap-8">
                <div class="md:flex md:flex-col md:justify-between md:items-start">
                    <?php if ($banner['logo']) : ?>
                        <img class="h-14.5 w-auto max-w-full md:h-22" src="http://localhost:10030/wp-content/uploads/2025/09/venipak-logo.svg" alt="">
                    <?php endif ?>

                    <?php if ($banner['description']) : ?>
                        <div class="andstudio-wysiwyg-container mt-8 text-body-s md:max-w-135">
                            <?php echo wp_kses_post($banner['description']) ?>
                        </div>
                    <?php endif ?>
                </div>

                <?php if ($banner['download_link']) : ?>
                    <div class="mt-8 p-5 rounded-lg bg-brand-primary md:mt-0 md:flex md:flex-col md:justify-between md:min-w-[20.25rem] md:rounded-xl">
                        <div>
                            <?php if ($banner['download_title']) : ?>
                                <h2 class="text-body-m text-neutral-white md:text-h3"><?php echo esc_html($banner['download_title']) ?></h2>
                            <?php endif ?>

                            <?php if ($banner['download_items']) : ?>
                                <ul class="hidden md:flex md:flex-col md:gap-1 md:mt-4">
                                    <?php foreach ($banner['download_items'] as $item) : ?>
                                        <li class="text-neutral-white text-body-xs"><?php echo esc_html($item['title']) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            <?php endif ?>
                        </div>

                        <a class="text-body-s text-neutral-white mt-4 pt-3 flex items-center justify-between border-t border-neutral-white md:mt-6" target="<?php echo esc_attr($banner['download_link']['target'] ? $banner['download_link']['target'] : '_self') ?>" href="<?php echo esc_url($banner['download_link']['url']) ?>">
                            <?php echo esc_htmL($banner['download_link']['title']) ?>
                            <svg class="w-8 h-8 text-neutral-white" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.9997 5.3335V20.0002M15.9997 20.0002L9.33301 13.3335M15.9997 20.0002L22.6663 13.3335" stroke="currentColor" />
                                <path d="M6.66699 24H25.3337" stroke="currentColor" />
                            </svg>
                        </a>
                    </div>
                <?php endif ?>
            </div>
        <?php endif ?>

        <!-- Pages -->
        <?php if ($pages) : ?>
            <div class="mt-10 flex flex-col gap-2.5 md:mt-16 md:grid md:grid-cols-2 md:gap-5">
                <?php foreach ($pages as $page) : ?>
                    <div class="group relative p-5 flex justify-between items-center rounded-lg bg-neutral-white md:py-8 md:pl-6 md:pr-14 md:rounded-xl md:hover:bg-brand-primary md:hover:text-neutral-white md:transition-colors md:duration-200 md:flex-col md:items-start md:gap-4">
                        <?php if ($page['link']) : ?>
                            <a class="absolute inset-0 z-10" href="<?php echo esc_url($page['link']) ?>"></a>
                        <?php endif ?>

                        <?php if ($page['title']) : ?>
                            <h2 class="text-body-m md:text-h2"><?php echo esc_html($page['title']) ?></h2>
                        <?php endif ?>

                        <?php if ($page['description']) : ?>
                            <div class="andstudio-wysiwyg-container hidden md:block md:text-body-s md:group-hover:opacity-0 md:transition-opacity duration-100">
                                <?php echo wp_kses_post($page['description']) ?>
                            </div>
                        <?php endif ?>

                        <?php if ($page['download_links']) : ?>
                            <div class="hidden md:z-20 md:absolute md:left-6 md:bottom-6 md:flex md:gap-2 md:opacity-0 md:group-hover:opacity-100 md:transition-opacity duration-100">
                                <?php foreach ($page['download_links'] as $link) :
                                    $link_target = $link['link']['target'] ? $link['link']['target'] : '_self'; ?>
                                    <a class="text-body-s text-neutral-white flex gap-1 px-4 py-1.5 items-center rounded-lg hover:bg-neutral-grey-1 hover:text-neutral-black transition-colors duration-200"
                                        href="<?php echo esc_url($link['link']['url']) ?>"
                                        target="<?php echo esc_attr($link_target) ?>">
                                        <?php echo esc_html($link['link']['title']) ?>
                                        <svg class="w-4 h-4" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.00033 2.66602V9.99935M8.00033 9.99935L4.66699 6.66602M8.00033 9.99935L11.3337 6.66602" stroke="currentColor" />
                                            <path d="M3.33301 12H12.6663" stroke="currentColor" />
                                        </svg>
                                    </a>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>

                        <div class="w-6 h-6 rounded-full bg-neutral-grey-1 flex items-center justify-center md:w-8 md:h-8 md:absolute md:bottom-4 md:right-4 md:group-hover:bg-neutral-white transition-colors duration-200">
                            <svg class="w-1.5 h-1.5 text-neutral-black md:w-2 md:h-2 md:group-hover:text-brand-primary transition-colors duration-200" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.375 0.375001L6.375 6.375M6.375 6.375L0.375 6.375M6.375 6.375L0.375 0.375" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>

        <!-- Subbrands -->
        <?php if ($sub_brands) : ?>
            <div class="mt-12 flex flex-col gap-6 md:mt-16">
                <?php if ($sub_brands['title']) : ?>
                    <h2 class="text-h3 md:text-h2"><?php echo esc_html($sub_brands['title']) ?></h2>
                <?php endif ?>

                <?php if ($sub_brands['brands']) : ?>
                    <div class="flex flex-col gap-2.5 md:grid md:grid-cols-2 md:gap-5">
                        <?php foreach ($sub_brands['brands'] as $brand) :
                            $page_id = $brand['page'];
                            $primary_color = get_field('brand_primary_color', $page_id);
                            $secondary_color = get_field('brand_secondary_color', $page_id);
                        ?>
                            <a class="relative rounded-xl p-5 bg-brand-primary text-neutral-white flex flex-col gap-5 md:p-10 md:justify-between md:gap-12 md:hover:bg-brand-secondary md:hover:text-neutral-black md:transition-colors md:duration-200"
                                href="<?php echo esc_url(get_permalink($page_id)) ?>"
                                style="--color-brand-primary: <?php echo esc_attr($primary_color); ?>; --color-brand-secondary: <?php echo esc_attr($secondary_color); ?>;">
                                <?php if ($brand['title']) : ?>
                                    <h3 class="text-body-m md:hidden"><?php echo esc_html($brand['title']) ?></h3>
                                <?php endif ?>

                                <?php if ($brand['logo']) :
                                    // Get the SVG content
                                    $svg_content = file_get_contents($brand['logo']);
                                    $formated_svg = andstudio_format_svg_for_output($svg_content, true, true);
                                ?>
                                    <div class="hidden md:inline-block md:h-15"><?php echo $formated_svg ?></div>
                                <?php endif ?>
                                <?php if ($brand['description']) : ?>
                                    <div class="andstudio-wysiwyg-container text-body-s max-w-67.5 md:max-w-85.5">
                                        <?php echo wp_kses_post($brand['description']) ?>
                                    </div>
                                <?php endif ?>

                                <div class="w-6 h-6 absolute top-5 right-5 bg-neutral-grey-1 text-brand-primary rounded-full flex items-center justify-center md:bottom-6 md:right-6 md:top-auto md:w-8 md:h-8">
                                    <svg class="w-1.5 h-1.5 md:w-2 md:h-2" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.375 0.375001L6.375 6.375M6.375 6.375L0.375 6.375M6.375 6.375L0.375 0.375" stroke="currentColor" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                </div>
                            </a>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            </div>
        <?php endif ?>

    </div>
</section>