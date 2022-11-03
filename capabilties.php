<?php

$args = array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'template_capabilities.php'
);

$pages = get_pages($args);
foreach ($pages as $page) :
    $id = $page->ID;
    $content = '';

    /**
     * Process the hero
     */

    $hero = '<!-- wp:group {"className":"capabilities-hero"} -->
<div class="wp-block-group capabilities-hero">';
    $hero .= '<!-- wp:group {"className":"left"} --><div class="wp-block-group left">';

    $hero_product_logo = get_field('hero_product_logo', $id);
    if (!empty($hero_product_logo)) :
    $hero .= '<!-- wp:group {"className":"top-logo"} -->
<div class="wp-block-group top-logo"><!-- wp:image {"id":'.$hero_product_logo['ID'].',"height":'.$hero_product_logo['sizes']['medium-height'].',width:'.$hero_product_logo['sizes']['medium-width'].',sizeSlug":"medium"} -->
<figure class="wp-block-image size-medium"><img src="'.$hero_product_logo['sizes']['medium'].'" height="'.$hero_product_logo['sizes']['medium-height'].'" width="'.$hero_product_logo['sizes']['medium-width'].'" alt="'.$hero_product_logo['alt'].'" class="wp-image-'.$hero_product_logo['ID'].'"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->';
    endif;

    $hero_title = get_field('hero_title', $id);
    if (!empty($hero_title)) :
        $hero .= '
        <!-- wp:group {"className":"text"} -->
        <div class="wp-block-group text"><!-- wp:heading {"level":1} -->
        <h1>'.$hero_title.'</h1>
        <!-- /wp:heading -->';
    endif;

    $hero_sub_title = get_field('hero_sub_title', $id);
    if (!empty($hero_sub_title)) :
        $hero .= '
        <!-- wp:paragraph -->
        <p>'.$hero_sub_title.'</p>
        <!-- /wp:paragraph -->';
    endif;

    $cta_link = '#cta';
    $cta_class = 'scroll-offset';
    $cta_override = get_field('cta_link_override');
    if (!empty($cta_override)) :
        $cta_link = $cta_override;
        $first_char_link = mb_substr($cta_override, 0, 1, 'utf-8');
        if ( $first_char_link != '#' ) :
            $cta_class = '';
        endif;
    endif;

    if (!empty($cta_button)) :
        $hero .= '
        <!-- wp:buttons -->
        <div class="wp-block-buttons"><!-- wp:button {"className":"is-style-fill"} -->
        <div class="wp-block-button is-style-fill"><a href="'.$cta_link.'" class="wp-block-button__link '.$cta_class.'" data-offset="110">'.$cta_button.'</a></div>
        <!-- /wp:button --></div>
        <!-- /wp:buttons --></div>
        ';
    endif;


$hero .= '<!-- /wp:group --></div>';
$hero .= '<!-- /wp:group -->';

$hero .= '<!-- wp:group {"className":"right"} -->
<div class="wp-block-group right">';


$main_hero_image = get_field('main_hero_image');

if (!empty($main_hero_image)) :
$hero .= '<!-- wp:image {"id":73662,"width":'.$hero_product_logo['sizes']['large-width'].',"height":'.$hero_product_logo['sizes']['large-height'].',"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img src="'.$hero_product_logo['sizes']['large'].'" alt="'.$hero_product_logo['alt'].'" class="wp-image-'.$hero_product_logo['ID'].'" height="'.$hero_product_logo['sizes']['large-height'].'" width="'.$hero_product_logo['sizes']['large-width'].'"/></figure>
<!-- /wp:image --></div>';

endif;

$hero .= '<!-- /wp:group --></div>';
$hero .= '<!-- /wp:group -->';


    /**
     * Feat Two
     */


    /**
     * Feat Three
     */


    /**
     * Solutions
     */

    /**
     * Expertise
     */

    /**
     * Resources
     */


    /**
     * CTA
     */


$content = $hero; // add the rest here if exists
    /**
     * Replace all content with the previous content from above
     */
    $data = array(
        'ID' => $id,
        'post_content' => $content,
    );
    wp_update_post($data);
endforeach;