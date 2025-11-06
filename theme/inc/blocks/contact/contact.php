<?php
$logo = get_field('logo', 'option');

$email = get_field('email', 'option');
$social_links = get_field('social_links', 'option');
$address = get_field('address', 'option');
?>

<section class="bg-neutral-grey-1 min-h-screen pt-35 pb-12 md:pt-27">
    <div class="container md:px-18">
        <div class="bg-neutral-white rounded-lg p-5 pt-10 md:p-14 md:pt-16">
            <?php if ($logo) : ?>
                <div class="w-full md:max-w-143">
                    <?php echo file_get_contents($logo) ?>
                </div>
            <?php endif ?>

            <?php if ($email || $social_links || $address) : ?>
                <div class="flex flex-col gap-12 mt-16 md:mt-32 md:gap-16">
                    <?php if ($email) : ?>
                        <div class="flex flex-col gap-2.5 md:gap-4">
                            <h2 class="text-body-s uppercase"><?php _e("Say what's up", "andstudio") ?></h2>
                            <span class="text-h3 uppercase font-medium md:text-h1"><?php echo esc_html($email) ?></span>
                        </div>
                    <?php endif ?>

                    <div class="flex flex-col gap-12 md:flex-row md:justify-between md:max-w-219.5">
                        <?php if ($social_links) : ?>
                            <div class="flex flex-col gap-2.5 md:gap-4">
                                <h2 class="text-body-s uppercase"><?php _e("Connect with us", "andstudio") ?></h2>
                                <ul>
                                    <?php foreach ($social_links as $link) : ?>
                                        <li>
                                            <a class="text-h3 uppercase font-medium md:text-h2" href="<?php echo esc_url($link['link']['url']) ?>" target="<?php echo esc_attr($link['link']['target'] ? $link['link']['target'] : '_self') ?>"><?php echo esc_html($link['link']['title']) ?></a>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>

                        <?php if ($address) : ?>
                            <div class="flex flex-col gap-2.5 md:gap-4">
                                <h2 class="text-body-s uppercase"><?php _e("Visit us", "andstudio") ?></h2>
                                <span class="text-h3 uppercase font-medium md:text-h2"><?php echo wp_kses_post($address) ?></span>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>