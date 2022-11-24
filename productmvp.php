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


   $ft_title = get_field('feature_title', $thisPageId);
   $ft_text = get_field('feature_text', $thisPageId);
    $ft_image = get_field('feature_image', $thisPageId);

    if ($ft_image || $ft_text || $ft_title) :
$content .= '<!-- wp:group {"className":"container-beige-section"} --><div class="wp-block-group container-beige-section">
<!-- wp:group {"className":"container"} --><div class="wp-block-group container">';
    if ($ft_title) $content .= '<!-- wp:heading {"level":2} --><h2>'.$ft_title.'</h2><!-- /wp:heading -->';
    if ($ft_text) $content .= '<!-- wp:paragraph --><p>'.$ft_text.'</p><!-- /wp:paragraph -->';
    if ($ft_image) $content .= '<!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img src="'.$ft_image['sizes']['large'].'" alt="'.$ft_image['alt'].'"/></figure>
<!-- /wp:image -->';

$content .= '</div><!-- /wp:group -->
</div><!-- /wp:group -->';

endif;

    /**
     * Resources
     */
    $i=0;
    $content .= '<!-- wp:acf/resource-picker {"name":"acf/resource-picker","data":{';
    if (have_rows('related_resources', $thisPageId)) : while (have_rows('related_resources', $thisPageId)) : the_row();
        $resource = get_sub_field('resource');
        if ($resource) :
            $content .= '"resources_'.$i.'_resource":'.$resource.',"_resources_'.$i.'_resource":"field_63658c67f6bef",';
            $i++;
        endif;
    endwhile;
    endif;
    $content .= '"resources":'.$i.',"_resources":"field_63658adf3a188"},"mode":"preview"} -->';
    $content .= '<!-- /wp:acf/resource-picker -->';

    /**
     * CTA
     */
    $mkto_form_id = get_field('mkto_form_id', $thisPageId);
    if (empty($mkto_form_id)) :
        $mkto_form_id = 4431;
    endif;
    $cta_title = get_field('form_title', $thisPageId);
    $content .= '<!-- wp:acf/contact-form {"name":"acf/contact-form","data":{"marketo_form_id":"'.$mkto_form_id.'","_marketo_form_id":"field_636499ebf8c41"},"mode":"preview"} -->';
    if ($cta_title) :
        $content .= get_field('pre_form_content)');
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
        delete_field('hero_title', $thisPageId);
        delete_field('hero_sub_title', $thisPageId);
        delete_field('hero_button_text', $thisPageId);
        delete_field('hero_button_url', $thisPageId);
        delete_field('mkto_form_id', $thisPageId);
        delete_field('open_content', $thisPageId);
        delete_field('three_item', $thisPageId);
        delete_field('feature_title', $thisPageId);
        delete_field('feature_text', $thisPageId);
        delete_field('feature_image', $thisPageId);
        delete_field('related_resources', $thisPageId);
        delete_field('pre_form_content', $thisPageId);
        delete_field('form_title', $thisPageId);
        delete_field('mkto_form_id', $thisPageId);
    }
endforeach;