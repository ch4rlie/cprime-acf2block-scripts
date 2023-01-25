<?php
set_time_limit(500);
require_once('wp-load.php');
define('WP_USE_THEMES', false);
remove_action('pre_post_update', 'wp_save_post_revision');
global $wpdb;

$args = array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'page.php',
    'post_status' => ['publish', 'draft'],
    'hierarchical' => false,
);

$pages = get_pages($args);
foreach ($pages as $page) :
    $thisPageId = $page->ID;



    $content = '';
    $content .= '<!-- wp:acf/cprime-default-block {"name":"acf/cprime-default-block","data":{"field_636beb1228350":"transparent","field_636bebb928352":"","field_636beb7d28351":"container"},"mode":"preview"} -->
     <!-- wp:html -->';
    $content .= get_the_content();

     $content .= '<!-- /wp:html --><!-- /wp:acf/cprime-default-block -->';
    






    /**
     * Manually remove everything from this posts the_content
     */
    $delete_content = $wpdb->update ( 'wp_posts', ['post_content' => ''], ['ID' => $thisPageId] );
    $data = array(
        'ID' => $thisPageId,
        'post_content' => $content,
    );
    /**
     * Update the_content for this post
     */
    $update_post = wp_update_post($data, true, false);

    /**
     * Update the use_gutenberg field for this post
     */
    update_field('use_gutenberg', 1, $thisPageId);

    if (is_wp_error($update_post)) {
        $errors = $update_post->get_error_messages();
        foreach ($errors as $error) {
            echo "ERROR ON $thisPageId";
            //echo $error;
        }
    }
    else {
        echo "Success on $thisPageId";
    }
endforeach;