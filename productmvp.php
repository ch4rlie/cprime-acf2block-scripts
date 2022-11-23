<?php
set_time_limit(500);
require_once('wp-load.php');
define('WP_USE_THEMES', false);
remove_action('pre_post_update', 'wp_save_post_revision');
global $wpdb;

$args = array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'template_product-mvp.php',
    'post_status' => ['publish', 'draft'],
    'hierarchical' => false,
);

$pages = get_pages($args);
foreach ($pages as $page) :
    $thisPageId = $page->ID;

    $mkto_form_id = get_field('mkto_form_id', $thisPageId);
    if (empty($mkto_form_id)) :
        $mkto_form_id = 4431;
    endif;


    $content = '';

    $hero_background = get_field('hero_background', $thisPageId);
    $hero_title = get_field('hero_title', $thisPageId);
    $hero_sub_title = get_field('hero_sub_title', $thisPageId);
    $hero_button_text = get_field('hero_button_text', $thisPageId);
    $hero_button_url = get_field('hero_button_url', $thisPageId);
    $hero = '<!-- wp:group {"className":"product-hero-mvp"} --><div class="wp-block-group product-hero-mvp">';

        if ($hero_background) :
            $hero .= '<!-- wp:image {"sizeSlug":"large","className":"bg-img"} -->
            <figure class="wp-block-image size-large bg-img"><img src="'.$hero_background.'" alt=""/></figure>
            <!-- /wp:image -->';
        endif;
            
         $hero .= '<!-- wp:group {"className":"holder"} --><div class="wp-block-group holder">';
            if ($hero_title) :
                $hero .= '<!-- wp:heading {"level":1} -->
                <h1>'.$hero_title.'</h1>
                <!-- /wp:heading -->';
            endif;
            if ($hero_sub_title) :
                $hero .= '<!-- wp:paragraph -->
                <p>'.$hero_sub_title.'</p>
                <!-- /wp:paragraph -->';
            endif;
            if ($hero_button_text) :
                if (empty($hero_button_url)) :
                    $hero_button_url = '#cta';
                endif;
                $hero .= '<!-- wp:buttons -->
                <div class="wp-block-buttons"><!-- wp:button {"className":"is-style-fill"} -->
                <div class="wp-block-button is-style-fill"><a class="wp-block-button__link" href="'.$hero_button_url.'">'.$hero_button_text.'</a></div>
                <!-- /wp:button --></div>
                <!-- /wp:buttons --></div>';
            endif;



        $hero .= '<!-- /wp:group --></div>';
    
    $hero .= '<!-- /wp:group -->';

    $open_content = get_field('open_content', $thisPageId);
    if ($open_content) :
    $info = '<!-- wp:acf/cprime-default-block {"name":"acf/cprime-default-block","data":{"field_636beb1228350":"white","field_636bebb928352":"","field_636beb7d28351":"container"},"mode":"preview"} -->';
    $info .= '<!-- wp:paragraph -->'.$open_content.'<!-- /wp:paragraph -->';
    $info .= '<!-- /wp:acf/cprime-default-block -->';
    endif;

    '.$.'

    if (have_rows('three_item', $thisPageId)) :
    $items = '<!-- wp:group {"className":"basic-grey-three-item"} --><div class="wp-block-group basic-grey-three-item">
<!-- wp:group {"className":"container"} --><div class="wp-block-group container">
<!-- wp:group {"className":"flexed"} --><div class="wp-block-group flexed">';
    while (have_rows('three_item', $thisPageId)) : the_row();
        $icon = get_sub_field('icon');
        $title = get_sub_field('title');
        $text = get_sub_field('text');
    $items .= '<!-- wp:group {"className":"item"} --><div class="wp-block-group item">';

        $items .= '<!-- wp:heading {"level":4} -->
<h4>'.$title.'</h4>
<!-- /wp:heading -->';

        $items .= '<!-- wp:paragraph -->
<p>'.$text.'</p>
<!-- /wp:paragraph -->';
        $items .= '</div><!-- /wp:group -->';


    endwhile;
    $items .= '</div><!-- /wp:group -->
</div><!-- /wp:group -->
</div><!-- /wp:group -->';


    endif;

$content = '










<!-- wp:group {"className":"container-beige-section"} -->
<div class="wp-block-group container-beige-section"><!-- wp:group {"className":"container"} -->
<div class="wp-block-group container"><!-- wp:paragraph -->
<p>Cprime provides Structure training that enables your team to quickly organize Jira issues with flexible hierarchies that map to your way of doing things. Individual or whole-team training is available. Our Structure course focuses on core concepts, administration, best practices, and key Structure features such as automation, transformations, custom views, and more! To learn more about receiving official Structure training from Cprime fill out the form on this page and our team will contact you shortly.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Reach out to the Cprime Training Team and well set your team on a path to success with Structure for Jira.</p>
<!-- /wp:paragraph -->

<!-- wp:embed {"url":"https://www.youtube.com/embed/80TPtalUCp8","type":"rich","providerNameSlug":"embed-handler","responsive":true,"className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} -->
<figure class="wp-block-embed is-type-rich is-provider-embed-handler wp-block-embed-embed-handler wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">
https://www.youtube.com/embed/80TPtalUCp8
</div></figure>
<!-- /wp:embed -->

<!-- wp:image {"id":73496,"sizeSlug":"medium","linkDestination":"media"} -->
<figure class="wp-block-image size-medium"><a href="http://localhost/wp-content/uploads/2022/07/Agile_Team_Facilitator_4.png"><img src="http://localhost/wp-content/uploads/2022/07/Agile_Team_Facilitator_4-300x300.png" alt="" class="wp-image-73496"/></a></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:acf/resource-picker {"name":"acf/resource-picker","data":{"resources_0_resource":39573,"_resources_0_resource":"field_63658c67f6bef","resources_1_resource":56300,"_resources_1_resource":"field_63658c67f6bef","resources_2_resource":56325,"_resources_2_resource":"field_63658c67f6bef","resources":3,"_resources":"field_63658adf3a188"},"mode":"preview"} -->
<!-- wp:heading -->
<h2>Related Resources<a href="http://localhost/resource/infographics/be-a-better-programmer/"></a></h2>
<!-- /wp:heading -->
<!-- /wp:acf/resource-picker -->

<!-- wp:acf/contact-form {"name":"acf/contact-form","data":{"marketo_form_id":"4724","_marketo_form_id":"field_636499ebf8c41"},"mode":"preview"} -->
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="has-text-align-center">TEST TITLE</h2>
<!-- /wp:heading -->
<!-- /wp:acf/contact-form -->';

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
        /**
         * TODO: Delete all data for these acf fields on the page to clear out wp_postmeta
         */
        delete_field('hero_background', $thisPageId);
        delete_field('hero_title', $thisPageId);
        delete_field('hero_sub_title', $thisPageId);
        delete_field('hero_button_text', $thisPageId);
        delete_field('hero_button_url', $thisPageId);
        delete_field('mkto_form_id', $thisPageId);
        delete_field('open_content', $thisPageId);
        delete_field('three_item', $thisPageId);
    }
endforeach;