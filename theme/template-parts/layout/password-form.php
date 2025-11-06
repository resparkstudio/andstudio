<?php

/**
 * Template part for displaying password form
 *
 * @package andstudio
 */

global $post;
$label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);

$page_id = get_the_ID();

?>

<form data-page-password-form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
    <input type="hidden" name="action" value="andstudio_page_password_auth">
    <input type="hidden" name="page_id" value="<?php echo esc_attr($page_id) ?>">
    <label for="<?php echo esc_attr($label); ?>" class="hidden">
        <?php _e('Password:', 'andstudio'); ?>
    </label>
    <div class="group" data-page-password-input-wrap>
        <span class="text-body-xs text-system-error mx-2 opacity-0 group-[.error]:opacity-100 transition-opacity">Incorrect password</span>
        <input
            name="page_password"
            id="<?php echo esc_attr($label); ?>"
            type="password"
            class="input w-full mt-1 group-[.error]:border-system-error"
            required />
    </div>

    <button
        type="submit"
        name="Submit"
        class="w-full mt-4 bg-neutral-black text-neutral-white border rounded-lg py-3 px-8">
        <?php _e('Enter', 'andstudio'); ?>
    </button>
</form>