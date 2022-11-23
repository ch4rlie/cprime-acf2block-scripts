<?php
set_time_limit(500);
require_once('wp-load.php');
define('WP_USE_THEMES', false);
remove_action('pre_post_update', 'wp_save_post_revision');
global $wpdb;

$args = array(
    'meta_key' => '_wp_page_template',
    'meta_value' => '',
    'post_status' => ['publish', 'draft'],
    'hierarchical' => false,

);

$pages = get_pages($args);
foreach ($pages as $page) :
    $thisPageId = $page->ID;
    $hero_background = get_field('hero_background', $page->ID);
    $hero_icon = get_field('hero_icon', $page->ID);
    $hero_short_title = get_field('hero_short_title', $page->ID);
    $hero_main_title = get_field('hero_main_title', $page->ID);
    $text_above_form = get_field('text_above_form', $page->ID);

    $intro_paragraph = get_field('intro_paragraph', $page->ID);

    $graphic_area_title = get_field('graphic_area_title', $page->ID);
    $graphic = get_field('graphic', $page->ID);

    $organizations_title = get_field('organizations_title', $page->ID);
    $resources_title = get_field('resources_title', $page->ID);

    $mkto_form_id = get_field('mkto_form_id', $page->ID);

    if (empty($mkto_form_id)) :
        $mkto_form_id = 4431;
    endif;
    $content = '';






    $content = '
    
    <!-- wp:group {"className":"hero-bg-area"} --><div class="wp-block-group hero-bg-area">
    <!-- wp:group {"className":"container"} --><div class="wp-block-group container">
    
    <!-- wp:group {"className":"flexed section-one"} --><div class="wp-block-group flexed section-one">
    <!-- wp:group {"className":"intro-text"} --><div class="wp-block-group intro-text">';

    if (empty($hero_short_title) && !empty($hero_icon)) :
        $content .= '<!-- wp:image -->
        <figure class="wp-block-image"><img src="'.$hero_icon['url'].'" alt="'.$hero_icon['alt'].'" height="'.$hero_icon['sizes']['height'].'" width="'.$hero_icon['sizes']['width'].'" /></figure>
        <!-- /wp:image -->
        <!-- wp:heading {"level":1} --><h1>'.$hero_main_title.'</h1><!-- /wp:heading -->';
    else :
        $content .= '<!-- wp:group {"className":"flexed"} --><div class="wp-block-group flexed">
    
    <!-- wp:group {"className":"icon"} --><div class="wp-block-group icon">
    <!-- wp:image -->
        <figure class="wp-block-image"><img src="'.$hero_icon['url'].'" alt="'.$hero_icon['alt'].'" height="'.$hero_icon['sizes']['height'].'" width="'.$hero_icon['sizes']['width'].'" /></figure>
        <!-- /wp:image -->
    </div><!-- /wp:group -->

    <!-- wp:group {"className":"text"} -->
    <div class="wp-block-group text">
    <!-- wp:heading {"level":3} --><h3>'.$hero_short_title.'</h3><!-- /wp:heading -->
 <!-- wp:heading {"level":1} --><h1>'.$hero_main_title.'</h1><!-- /wp:heading -->
    </div><!-- /wp:group -->
    
    </div><!-- /wp:group -->';
    endif;

    $content .= '
    
    </div><!-- /wp:group -->
    </div><!-- /wp:group -->';

    if (have_rows('four_items', $thisPageId)) :
        $content .= '<!-- wp:group {"className":"section-two"} --><div class="wp-block-group section-two">';
        $content .= '<!-- wp:paragraph {"className":"section-intro"} --><p class="section-intro">'.$intro_paragraph.'</p><!-- /wp:paragraph -->';

        $content .= '<!-- wp:group {"className":"boxes"} --><div class="wp-block-group boxes">';
        while (have_rows('four_items', $thisPageId)) : the_row();
            $icon = get_sub_field('icon');
            $title = get_sub_field('title');
            $text = get_sub_field('text');

            $content .= '<!-- wp:group {"className":"box"} --><div class="wp-block-group box">';
            if ($icon) :
                $content .= '<!-- wp:image {"sizeSlug":"thumbnail"} --><figure class="wp-block-image size-thumbnail"><img src="'.$icon['sizes']['thumbnail'].'" alt=""/></figure><!-- /wp:image -->';
            endif;
            if ($title) :
                $content .= '<!-- wp:heading {"level":4} --><h4>'.$title.'</h4><!-- /wp:heading -->';
            endif;
            if ($text) :
                $content .= '<!-- wp:paragraph --><p>'.$text.'</p><!-- /wp:paragraph -->';
            endif;
            $content .= '</div><!-- /wp:group -->';
        endwhile;
        $content .= '</div><!-- /wp:group -->';
    endif;

    $content .= '</div><!-- /wp:group -->';

    if ($hero_background) :
        $content .= '<!-- wp:image {"id":'.$hero_background['ID'].',"linkDestination":"none","className":"abs-hero"} -->
<figure class="wp-block-image size-large abs-hero"><img src="'.$hero_background['url'].'" alt="'.$hero_background['alt'].'" class="wp-image-'.$hero_background['ID'].'"/></figure>
<!-- /wp:image -->';
    endif;

    $content .= '</div><!-- /wp:group -->';


    if (!empty($graphic) ) :
        $content .= '<!-- wp:acf/cprime-default-block {"name":"acf/cprime-default-block","data":{"background_color":"beige","_background_color":"field_636beb1228350","background_image":"","_background_image":"field_636bebb928352","container":"container","_container":"field_636beb7d28351"},"mode":"preview"} -->
<!-- wp:heading -->
<h2>'.$graphic_area_title.'</h2>
<!-- /wp:heading -->

<!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img src="'.$graphic['sizes']['large'].'" alt="'.$graphic['alt'].'"/></figure>
<!-- /wp:image -->
<!-- /wp:acf/cprime-default-block -->';
    endif;




    if (have_rows('products_services', $thisPageId)) :
        $content .= '<!-- wp:acf/cprime-default-block {"name":"acf/cprime-default-block","data":{"background_color":"white","_background_color":"field_636beb1228350","background_image":"","_background_image":"field_636bebb928352","container":"full-width","_container":"field_636beb7d28351"},"mode":"preview"} -->';

        $hide_section_title = get_field('hide_section_title', $thisPageId);
        if (!$hide_section_title) :
            if (!empty($alternating_boxes_title)) :
                $abt_title = $alternating_boxes_title;
            else :
                $abt_title = "Our Approach";
            endif;

            $content .= '<!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">'.$abt_title.'</h2><!-- /wp:heading -->';
        endif;

        $i = 0;
        while(have_rows('products_services', $thisPageId)) : the_row();

        $i++;
            if($i % 2 == 0) :
                $variation = "a";
            else :
                $variation = "b";
            endif;

            $image = get_sub_field('image');
            $title = get_sub_field('title');
            $text = get_sub_field('text');
            $link_text = get_sub_field('link_text');
            $link_url = get_sub_field('link_url');

            $content .= '<!-- wp:acf/alternating-content {"name":"acf/alternating-content","data":{"image":'.$image['sizes']['large'].',"_image":"field_6376de4592b0d","variation":"variation-'.$variation.'","_variation":"field_6376df8892b0e"},"mode":"preview"} -->
<!-- wp:heading {"level":4} -->
<h4>'.$title.'</h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>'.$text.'</p>
<!-- /wp:paragraph -->';

            if ($link_url && $link_text) :
                $content .= '<!-- wp:paragraph -->
<p><a href="'.$link_url.'" target="_blank">'.$link_text.'</a></p>
<!-- /wp:paragraph -->';
            endif;


        $content .= '<!-- /wp:acf/alternating-content -->';
        endwhile;

        $content .= '<!-- /wp:acf/cprime-default-block -->';
    endif;


    if (have_rows('organizations', $thisPageId)) :
        $content .= '<!-- wp:acf/cprime-default-block {"name":"acf/cprime-default-block","data":{"background_color":"beige","_background_color":"field_636beb1228350","background_image":"","_background_image":"field_636bebb928352","container":"full-width","_container":"field_636beb7d28351"},"mode":"preview"} --><!-- wp:group {"className":"basic-grey-three-item"} --><div class="wp-block-group basic-grey-three-item">
<!-- wp:group {"className":"container"} --><div class="wp-block-group container">
<!-- wp:group {"className":"flexed"} --><div class="wp-block-group flexed">';

        while (have_rows('organizations', $thisPageId)) : the_row();
            $company_logo = get_sub_field('company_logo');
            $title = get_sub_field('title');
            $text = get_sub_field('text');
            $url = get_sub_field('url');

            $content .= '<!-- wp:group {"className":"item"} --><div class="wp-block-group item">';
            if ($company_logo) :
            $content .= '<!-- wp:image {"sizeSlug":"thumbnail"} -->
<figure class="wp-block-image size-thumbnail"><img src="'.$company_logo['sizes']['thumbnail'].'" alt="'.$company_logo['alt'].'"/></figure>
<!-- /wp:image -->';
            endif;

            $content .= '
<!-- wp:heading {"level":4} --><h4>'.$title.'</h4><!-- /wp:heading -->

<!-- wp:paragraph --><p>'.$text.'</p><!-- /wp:paragraph -->';
            if ($url) :
    $content .= '<!-- wp:paragraph --><p><a href="'.$url.'">Read their story</a></p><!-- /wp:paragraph -->
    </div><!-- /wp:group -->';
            endif;

        endwhile;

        $content .= '<!-- /wp:acf/cprime-default-block --></div><!-- /wp:group -->
</div><!-- /wp:group -->
</div><!-- /wp:group -->';
    endif;

    /**
     * Resources
     */
    $i=0;

    $content = '<!-- wp:acf/resource-picker {"name":"acf/resource-picker","data":{';
    if (have_rows('resources', $thisPageId)) : while (have_rows('resources', $thisPageId)) : the_row();
        $resource = get_sub_field('resource');
        if ($resource) :
            $content .= '"resources_'.$i.'_resource":'.$resource.',"_resources_'.$i.'_resource":"field_63658c67f6bef",';
            $i++;
        endif;
    endwhile;
    endif;

    $content .= '"resources":'.$i.',"_resources":"field_63658adf3a188"},"mode":"preview"} -->';
    if ($resources_title) : $content .= '<!-- wp:heading {"level":2} -->
        <h2>'.$resources_title.'</h2>
        <!-- /wp:heading -->';
    endif;
    $content .= '<!-- /wp:acf/resource-picker -->';



    $cta_title = get_field('text_above_form', $thisPageId);
    $content .= '<!-- wp:acf/contact-form {"name":"acf/contact-form","data":{"field_636499ebf8c41":"","field_63740040a9d38":"full-width"},"mode":"preview"} -->';
    if ($cta_title) :
        $content .= '<!-- wp:heading -->
        <h2>'.$cta_title.'</h2>
        <!-- /wp:heading -->';
    endif;
    $content .= '<!-- /wp:acf/contact-form -->';

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
        delete_field('hero_icon', $thisPageId);
        delete_field('hero_short_title', $thisPageId);
        delete_field('hero_main_title', $thisPageId);
        delete_field('text_above_form', $thisPageId);
        delete_field('intro_paragraph', $thisPageId);
        delete_field('graphic_area_title', $thisPageId);
        delete_field('graphic', $thisPageId);
        delete_field('organizations_title', $thisPageId);
        delete_field('resources_title', $thisPageId);
        delete_field('mkto_form_id', $thisPageId);

        // Delete Repeaters
        delete_field('resources', $thisPageId);
        delete_field('organizations', $thisPageId);
        delete_field('products_services', $thisPageId);
        delete_field('four_items', $thisPageId);
    }
endforeach;