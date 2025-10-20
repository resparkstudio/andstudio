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
    register_block_type(__DIR__ . '/content-wrap');
    register_block_type(__DIR__ . '/hero');
    register_block_type(__DIR__ . '/page-transition');
    register_block_type(__DIR__ . '/strategy-1');
    register_block_type(__DIR__ . '/strategy-2');
    register_block_type(__DIR__ . '/strategy-3');
    register_block_type(__DIR__ . '/strategy-4');
    register_block_type(__DIR__ . '/strategy-5');
    register_block_type(__DIR__ . '/strategy-6');
    register_block_type(__DIR__ . '/strategy-7');
    register_block_type(__DIR__ . '/strategy-8');
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
        'slug'  => 'strategy',
        'title' => 'Strategy',
    ));

    return $categories;
}
add_filter('block_categories_all', 'andstudio_register_block_category');


/**
 * Disable all default wordpress blocks and register custom blocks
 */
function andstudio_allowed_block_types($allowed_blocks, $editor_context) {

    return array(
        'andstudio/content-wrap',
        'andstudio/hero',
        'andstudio/page-transition',
        'andstudio/strategy-1',
        'andstudio/strategy-2',
        'andstudio/strategy-3',
        'andstudio/strategy-4',
        'andstudio/strategy-5',
        'andstudio/strategy-6',
        'andstudio/strategy-7',
        'andstudio/strategy-8',
    );
}
add_filter('allowed_block_types_all', 'andstudio_allowed_block_types', 25, 2);
