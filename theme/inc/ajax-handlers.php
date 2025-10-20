<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package andstudio
 */

function andstudio_page_password_auth() {
    check_ajax_referer('ajax_nonce', 'nonce');

    $post = get_post($_POST['page_id']);
    $submitted_password = $_POST['password'];

    if (!$post) {
        wp_send_json_error("Invalid post");
        return;
    }

    // Check if the submitted password matches the post's password
    if ($submitted_password === $post->post_password) {
        // Password is correct - set the cookie
        andstudio_set_intro_cookie($post);

        wp_send_json_success('Password correct');
    } else {
        // Password is wrong - return error
        wp_send_json_error('Incorrect password');
    }
}
add_action('wp_ajax_nopriv_andstudio_page_password_auth', 'andstudio_page_password_auth');
add_action('wp_ajax_andstudio_page_password_auth', 'andstudio_page_password_auth');



function andstudio_unprotected_page_entry_cookie() {
    check_ajax_referer('ajax_nonce', 'nonce');

    $post = get_post($_POST['page_id']);

    if (!$post) {
        wp_send_json_error("Invalid post");
        return;
    }

    andstudio_set_intro_cookie($post);
    wp_send_json_success('Cookie set');
}
add_action('wp_ajax_nopriv_andstudio_unprotected_page_entry_cookie', 'andstudio_unprotected_page_entry_cookie');
add_action('wp_ajax_andstudio_unprotected_page_entry_cookie', 'andstudio_unprotected_page_entry_cookie');
