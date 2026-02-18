<?php

use Spatie\Color\Hex;

$anchor_title = get_field('anchor_title');
$boxed = get_field('boxed');
$title = get_field('title');
$description = get_field('description');
$color_groups = get_field('color_groups');

andstudio_display_block_preview_img($block);
?>

<section class="<?php echo esc_attr(andstudio_get_section_classes($boxed)) ?>" id="<?php echo esc_attr(andstudio_construct_anchor_slug($anchor_title)) ?>">
    <div class="container bg-neutral-white md:rounded-xl md:pt-16 md:pb-14">
        <div class="flex flex-col gap-6 md:gap-10 md:max-w-147">
            <?php if ($title) : ?>
                <h2 class="text-h1-mobile md:text-h1"><?php echo esc_html($title) ?></h2>
            <?php endif ?>

            <?php if ($description) : ?>
                <div class="andstudio-wysiwyg-container text-body-s md:text-body-m">
                    <?php echo wp_kses_post($description) ?>
                </div>
            <?php endif ?>
        </div>

        <?php if ($color_groups) : ?>
            <div class="flex flex-col gap-8 mt-8 md:mt-16 md:grid md:grid-cols-12 md:gap-5">
                <?php foreach ($color_groups as $group) :
                    $colors = $group['colors'];
                ?>

                    <?php if ($colors) : ?>
                        <div class="flex flex-col gap-2.5 md:col-span-5 md:even:col-start-7 md:gap-5">
                            <?php foreach ($colors as $color) :
                                $hex_color = Hex::fromString($color['color']);
                                $is_white = $color['color'] === '#ffffff';
                                $pantone_color = $color['pantone_code'];
                                $rgb_override = $color['rgb_override'] ?? null;
                                $cmyk_override = $color['cmyk_override'] ?? null;
                                $additional_info = $color['additional_info'] ?? null;

                                if ($rgb_override) {
                                    $rgb_display = $rgb_override;
                                } else {
                                    $rgb_color = $hex_color->toRgb();
                                    $rgb_display = $rgb_color->red() . ', ' . $rgb_color->green() . ', ' . $rgb_color->blue();
                                }

                                if ($cmyk_override) {
                                    $cmyk_display = $cmyk_override;
                                } else {
                                    $cmyk_color = $hex_color->toCmyk();
                                    $cmyk_display = round($cmyk_color->cyan() * 100) . ', ' .
                                        round($cmyk_color->magenta() * 100) . ', ' .
                                        round($cmyk_color->yellow() * 100) . ', ' .
                                        round($cmyk_color->key() * 100);
                                }
                            ?>
                                <div class="flex gap-5 md:gap-6">
                                    <div style="background-color: <?php echo esc_attr($color['color']) ?>;" class="w-full aspect-square rounded-lg md:rounded-xl md:aspect-[282/144] md:w-2/3"></div>
                                    <div class="w-full flex flex-col pt-2.5 text-body-s md:pt-4 md:w-1/3 md:min-w-42.25">
                                        <?php if ($hex_color) : ?>
                                            <div x-data="copyColor" class="flex justify-between items-center">
                                                <?php echo esc_html($hex_color) ?>
                                                <button x-show="!copied" @click="copy('<?php echo esc_html($hex_color) ?>')">
                                                    <svg class="w-6 h-6 text-neutral-black" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M20 9H11C9.89543 9 9 9.89543 9 11V20C9 21.1046 9.89543 22 11 22H20C21.1046 22 22 21.1046 22 20V11C22 9.89543 21.1046 9 20 9Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M5 15H4C3.46957 15 2.96086 14.7893 2.58579 14.4142C2.21071 14.0391 2 13.5304 2 13V4C2 3.46957 2.21071 2.96086 2.58579 2.58579C2.96086 2.21071 3.46957 2 4 2H13C13.5304 2 14.0391 2.21071 14.4142 2.58579C14.7893 2.96086 15 3.46957 15 4V5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </button>
                                                <div x-show="copied" class="flex gap-1.5">
                                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M18 6L7 17L2 12" stroke="#0EBC7D" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M22 10L14.5 17.5L13 16" stroke="#0EBC7D" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    <span class="text-body-xs"><?php esc_html_e('Copied!', 'andstudio') ?></span>
                                                </div>
                                            </div>
                                        <?php endif ?>

                                        <?php if ($rgb_display) : ?>
                                            <span>RGB: <?php echo esc_html($rgb_display) ?></span>
                                        <?php endif ?>

                                        <?php if ($cmyk_display) : ?>
                                            <span>CMYK: <?php echo esc_html($cmyk_display) ?></span>
                                        <?php endif ?>

                                        <?php if ($pantone_color) : ?>
                                            <span>Pantone: <?php echo esc_html($pantone_color) ?></span>
                                        <?php endif ?>

                                        <?php if ($additional_info) : ?>
                                            <span><?php echo esc_html($additional_info) ?></span>
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
</section>