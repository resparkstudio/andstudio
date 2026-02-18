<?php

/**
 * Template part for displaying intro page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package andstudio
 */

global $post;

$parent_id = andstudio_get_brand_parent_id($post);

$hasPassword = $post->post_password ? true : false;

$logo = get_field('intro_logo', $parent_id);
$images = get_field('intro_images', $parent_id);


$image_classes_config = [
    6 => [
        'md:w-[30.6%] md:aspect-[440/461] md:left-[-0.7%] md:top-[-9.2%] z-40',
        'md:w-[28.9%] md:aspect-[416/550] md:left-[35.6%] md:top-[-59.2%] z-20',
        'w-full h-full md:h-auto md:w-[27.7%] md:aspect-[399/203] md:right-[-4.9%] md:top-[-1.9%] z-60', // Main animation image
        'md:w-[29.8%] md:aspect-[429/571] md:right-[0%] md:bottom-[-21.1%] z-10',
        'md:w-[24.1%] md:aspect-[347/230] md:left-[38%] md:bottom-[-16%] z-5  0',
        'md:w-[16.9%] md:aspect-[244/256] md:left-[6%] md:bottom-[-3.9%] z-30',
    ],
    8 => [
        'md:w-[30.5%] md:aspect-[440/461] md:left-[-9.9%] md:top-[-3.5%] z-60',
        'md:w-[29%] md:aspect-[416/550] md:left-[22.7%] md:top-[-45.6%] z-40',
        'w-full h-full md:h-auto md:w-[25.5%] md:aspect-[371/188] md:right-[17.4%] md:top-[-13.1%] z-80', // Main animation image
        'md:w-[20.5%] md:aspect-[296/196] md:right-[1.3%] md:top-[14.9%] z-20',
        'md:w-[24.5%] md:aspect-[350/367] md:right-[-5.1%] md:bottom-[2.8%] z-10',
        'md:w-[17%] md:aspect-[244/256] md:right-[21.6%] md:bottom-[-7.4%] z-30',
        'md:w-[25%] md:aspect-[361/481] md:left-[31.7%] md:bottom-[-44.2%] z-70',
        'md:w-[31%] md:aspect-[447/299] md:left-[-2.9%] md:bottom-[-13.3%] z-50',
    ],
];
?>

<section class="pt-35 h-screen bg-neutral-black relative overflow-hidden md:flex md:justify-center md:items-center md:pt-0">

    <div class="absolute inset-0 z-10">
        <?php foreach ($images as $index => $image) :
            // General classes
            $classes = 'absolute object-cover';

            // plane value for floatingImagesEffect() animation
            $floating_plane_index = $index % 2 ? 1 : 2;

            // Hide all except main animation image with index 2
            if ($index !== 2) {
                $classes .= ' hidden md:block';
            }

            // Get remaining classes from the config array
            $classes .= ' ' . $image_classes_config[count($images)][$index] . '';
        ?>

            <img class="<?php echo esc_attr($classes) ?>" src="<?php echo esc_url($image['url']) ?>" alt="" data-intro-image data-floating-plane="<?php echo esc_attr($floating_plane_index) ?>">
        <?php endforeach ?>
    </div>

    <div class="bg-neutral-black opacity-30 absolute inset-0 pointer-events-none z-20"></div>

    <div data-intro-content class="container relative z-30 md:w-auto">
        <div class="px-5 pb-8 pt-10 md:px-8 md:pt-16 bg-neutral-white flex flex-col items-center rounded-lg md:max-w-sm">
            <img class="h-12 mb-5 md:mb-10 md:h-14" src="<?php echo esc_url($logo['url']) ?>" alt="">
            <!-- Display intro content -->
            <?php if ($hasPassword) :
                echo get_the_password_form();
            else : ?>
                <button class="w-full mt-4 bg-neutral-black text-neutral-white border rounded-lg py-3 px-8" data-intro-enter-btn="<?php echo esc_attr($post->ID) ?>">Enter</button>
            <?php endif ?>
        </div>
    </div>
</section>