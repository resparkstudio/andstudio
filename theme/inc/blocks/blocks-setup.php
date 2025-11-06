<?php

/**
 * Block registration and setup
 *
 * Handles all ACF block registration and block-related configuration
 *
 * @package andstudio
 */

/**
 * Register all ACF blocks
 */
function andstudio_register_acf_blocks() {
    register_block_type(__DIR__ . '/dashboard');
    register_block_type(__DIR__ . '/content-wrap');
    register_block_type(__DIR__ . '/hero');
    register_block_type(__DIR__ . '/page-transition');
    register_block_type(__DIR__ . '/faq');
    register_block_type(__DIR__ . '/contact');
    register_block_type(__DIR__ . '/page-end');
    register_block_type(__DIR__ . '/block-1');
    register_block_type(__DIR__ . '/block-2');
    register_block_type(__DIR__ . '/block-3');
    register_block_type(__DIR__ . '/block-4');
    register_block_type(__DIR__ . '/block-5');
    register_block_type(__DIR__ . '/block-6');
    register_block_type(__DIR__ . '/block-7');
    register_block_type(__DIR__ . '/block-8');
    register_block_type(__DIR__ . '/block-9');
    register_block_type(__DIR__ . '/block-10');
    register_block_type(__DIR__ . '/block-11');
    register_block_type(__DIR__ . '/block-12');
    register_block_type(__DIR__ . '/block-13');
    register_block_type(__DIR__ . '/block-14');
    register_block_type(__DIR__ . '/block-15');
    register_block_type(__DIR__ . '/block-16');
    register_block_type(__DIR__ . '/block-17');
    register_block_type(__DIR__ . '/block-18');
    register_block_type(__DIR__ . '/block-19');
    register_block_type(__DIR__ . '/block-20');
    register_block_type(__DIR__ . '/block-21');
    register_block_type(__DIR__ . '/block-22');
    register_block_type(__DIR__ . '/block-23');
    register_block_type(__DIR__ . '/block-24');
    register_block_type(__DIR__ . '/block-25');
    register_block_type(__DIR__ . '/block-26');
}
add_action('init', 'andstudio_register_acf_blocks');

/**
 * Register custom block category for andstudio blocks
 */
function andstudio_register_block_category($categories) {
    // Add the new category to the beginning of the categories array
    array_push($categories, array(
        'slug'  => 'global',
        'title' => 'Global',
    ));

    array_push($categories, array(
        'slug'  => 'content',
        'title' => 'Content',
    ));

    return $categories;
}
add_filter('block_categories_all', 'andstudio_register_block_category');


/**
 * Disable all default wordpress blocks and register custom blocks
 */
function andstudio_allowed_block_types($allowed_blocks, $editor_context) {

    return array(
        'andstudio/dashboard',
        'andstudio/content-wrap',
        'andstudio/hero',
        'andstudio/page-transition',
        'andstudio/faq',
        'andstudio/contact',
        'andstudio/page-end',
        'andstudio/block-1',
        'andstudio/block-2',
        'andstudio/block-3',
        'andstudio/block-4',
        'andstudio/block-5',
        'andstudio/block-6',
        'andstudio/block-7',
        'andstudio/block-8',
        'andstudio/block-9',
        'andstudio/block-10',
        'andstudio/block-11',
        'andstudio/block-12',
        'andstudio/block-13',
        'andstudio/block-14',
        'andstudio/block-15',
        'andstudio/block-16',
        'andstudio/block-17',
        'andstudio/block-18',
        'andstudio/block-19',
        'andstudio/block-20',
        'andstudio/block-21',
        'andstudio/block-22',
        'andstudio/block-23',
        'andstudio/block-24',
        'andstudio/block-25',
        'andstudio/block-26',
    );
}
add_filter('allowed_block_types_all', 'andstudio_allowed_block_types', 25, 2);
