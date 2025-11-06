<?php
$title = get_field('title');
$image = get_field('image');
$mobile_image = get_field('mobile_image');
$faq_groups = get_field('faq_groups', 'option');
?>

<section class="bg-neutral-grey-1 pb-12 md:pb-23" x-data='{"expanded": null}'>
    <?php if ($mobile_image) : ?>
        <img class="w-full aspect-[393/264] object-cover md:hidden" src="<?php echo esc_url($mobile_image['url']) ?>" alt="<?php echo esc_attr($mobile_image['alt']) ?>">
    <?php endif ?>
    <?php if ($image) : ?>
        <img class="hidden md:block md:w-full md:aspect-[1440/418] md:object-cover" src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($image['alt']) ?>">
    <?php endif ?>

    <div class="container -mt-30 md:px-18">
        <div class="relative z-20 bg-neutral-white rounded-lg pt-10 pb-5 px-5 md:rounded-xl md:p-14 md:pt-16">
            <?php if ($title) : ?>
                <h1 class="text-h1-mobile md:text-h1"><?php echo esc_html($title) ?></h1>
            <?php endif ?>

            <?php if ($faq_groups) : ?>
                <div class="mt-8 flex flex-col gap-12 md:mt-16 md:gap-16">
                    <?php foreach ($faq_groups as $group_index => $group) : ?>
                        <div class="flex flex-col gap-4 md:gap-8">
                            <?php if ($group['title']) : ?>
                                <h2 class="text-h3"><?php echo esc_html($group['title']) ?></h2>
                            <?php endif ?>

                            <?php if ($group['items']) : ?>
                                <div class="flex flex-col gap-2.5 md:gap-4">
                                    <?php foreach ($group['items'] as $item_index => $item) :
                                        $unique_id = $group_index . '-' . $item_index;
                                    ?>
                                        <div class="rounded-xl transition-colors duration-200"
                                            :class="expanded === '<?php echo esc_attr($unique_id) ?>' ? 'bg-brand-secondary' : 'bg-neutral-grey-1'">
                                            <!-- Trigger -->
                                            <button @click="expanded = expanded === '<?php echo esc_attr($unique_id) ?>' ? null : '<?php echo esc_attr($unique_id) ?>'"
                                                class="p-5 w-full flex justify-between items-center gap-2.5 md:py-4 md:px-8">
                                                <?php if ($item['question']) : ?>
                                                    <h3 class="text-body-s text-left md:text-body-m"><?php echo esc_html($item['question']) ?></h3>
                                                <?php endif ?>
                                                <div class="shrink-0 rounded-full relative w-7 h-7 flex items-center justify-center bg-brand-primary text-neutral-white">
                                                    <svg class="w-3 h-3" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path x-show="expanded !== '<?php echo esc_attr($unique_id) ?>'" d="M5.66699 1V10.3333" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        <path d="M1 5.66724H10.3333" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                </div>
                                            </button>

                                            <!-- Expand -->
                                            <div x-show="expanded === '<?php echo esc_attr($unique_id) ?>'" x-collapse.duration.600ms>
                                                <div class="px-5 pb-5 pt-1 md:px-8 md:pt-2 md:pb-8">
                                                    <div class="w-full h-px bg-neutral-white md:hidden"></div>
                                                    <?php if ($item['answer']) : ?>
                                                        <div class="andstudio-wysiwyg-container text-body-s mt-6 md:mt-0 md:max-w-160">
                                                            <?php echo wp_kses_post($item['answer']) ?>
                                                        </div>
                                                    <?php endif ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            <?php endif ?>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>