<?php
set_time_limit(500);
require_once('wp-load.php');
define('WP_USE_THEMES', false);

$args = array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'template_capabilities.php',
    'post_status' => ['publish', 'draft'],
);

$pages = get_pages($args);
foreach ($pages as $page) :
    $thisPageId = $page->ID;
    $content = '';

    /**
     * Process the hero
     */

    $hero = '<!-- wp:group {"className":"capabilities-hero"} -->
<div class="wp-block-group capabilities-hero">';
    $hero .= '<!-- wp:group {"className":"left"} --><div class="wp-block-group left">';

    $hero_product_logo = get_field('hero_product_logo', $thisPageId);
    if (!empty($hero_product_logo)) :
    $hero .= '<!-- wp:group {"className":"top-logo"} --><div class="wp-block-group top-logo"><!-- wp:image {"id":'.$hero_product_logo['ID'].',"height":'.$hero_product_logo['sizes']['medium-height'].',width:'.$hero_product_logo['sizes']['medium-width'].',sizeSlug":"medium"} --><figure class="wp-block-image size-medium"><img src="'.$hero_product_logo['sizes']['medium'].'" height="'.$hero_product_logo['sizes']['medium-height'].'" width="'.$hero_product_logo['sizes']['medium-width'].'" alt="'.$hero_product_logo['alt'].'" class="wp-image-'.$hero_product_logo['ID'].'"/></figure><!-- /wp:image --></div><!-- /wp:group -->';
    endif;

    $hero_title = get_field('hero_title', $thisPageId);
    if (!empty($hero_title)) :
        $hero .= '
        <!-- wp:group {"className":"text"} -->
        <div class="wp-block-group text"><!-- wp:heading {"level":1} -->
        <h1>'.$hero_title.'</h1>
        <!-- /wp:heading -->';
    endif;

    $hero_sub_title = get_field('hero_sub_title', $thisPageId);
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
    $intro_image = get_field('intro_image', $thisPageId);
    $intro_video = get_field('intro_video', $thisPageId);
    $intro_title = get_field('intro_title', $thisPageId);
    $intro_sub_title = get_field('intro_sub_title', $thisPageId);
    $half = '';

    if ($intro_image || $intro_video || $intro_title || $intro_sub_title) :

    $half = '<!-- wp:group {"className":"half-half-sm"} --><div class="wp-block-group half-half-sm">
<!-- wp:group {"className":"container"} --><div class="wp-block-group container">

<!-- wp:group {"className":"half"} --><div class="wp-block-group half">';
    if (!empty($intro_video)) :
        $half .= '<!-- wp:embed {"url":"https://www.youtube.com/watch?v='.$intro_video.'","type":"video","providerNameSlug":"youtube","responsive":true,"className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} -->
<figure class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper">
https://www.youtube.com/watch?v='.$intro_video.'
</div></figure>
<!-- /wp:embed -->';
    elseif ($intro_image) :
        $half .= '<!-- wp:image {"id":'.$intro_image['ID'].',"sizeSlug":"large"} -->
    <figure class="wp-block-image size-large"><img src="'.$intro_image['sizes']['large'].'" alt="'.$intro_image['alt'].'"/></figure>
    <!-- /wp:image --></div>';
    endif;

$half .= '<!-- /wp:group -->';

if ($intro_title || $intro_sub_title) :
$half .= '
<!-- wp:group {"className":"half"} -->
<div class="wp-block-group half">
<!-- wp:heading {"level":3} -->
<h3>'.$intro_title.'</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>'.$intro_sub_title.'</p>
<!-- /wp:paragraph --></div>

<!-- /wp:group --></div>';
endif;

$half .= '<!-- /wp:group --></div>
<!-- /wp:group -->';

endif;


    /**
     * Feat Three
     */
    $featThree = '';
    if (have_rows('intro_three_columns', $thisPageId)) :
    $featThree = '<!-- wp:group {"className":"feat-three"} --><div class="wp-block-group feat-three">';
        while (have_rows('intro_three_columns', $thisPageId)) : the_row();
            $title = get_sub_field('title');
            $text = get_sub_field('text');

$featThree .= '<!-- wp:group {"className":"item"} -->
<div class="wp-block-group item"><!-- wp:heading {"level":3} -->
<h3>'.$title.'</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>'.$text.'</p>
<!-- /wp:paragraph --></div>

<!-- /wp:group -->';
endwhile;


$featThree .= '<!-- /wp:group -->';

    endif;


    /**
     * Solutions
     */
    $solutions = '';
    $solutions_title = get_field('solutions_title', $thisPageId);
    $solutions_sub_title = get_field('solutions_sub_title', $thisPageId);
    $solutions_fixed_image = get_field('solutions_fixed_image', $thisPageId);

    if (have_rows('solutions_items')) :
    $solutions = '<!-- wp:acf/solutions-content {
    "name":"acf/solutions-content",
    "data":{
    "solutions_title":"'.$solutions_title.'",
    "_solutions_title":"field_6364303f92155",
    "solutions_sub_title":"'.$solutions_sub_title.'",
    "_solutions_sub_title":"field_636430f192156",
    "solutions_fixed_image":'.$solutions_fixed_image['ID'].',
    "_solutions_fixed_image":"field_6364312192157",';

    while (have_rows('solutions_items', $thisPageId)): the_row();
        $title = get_sub_field('title');
        $text = get_sub_field('text');
        $link_text = get_sub_field('link_text');
        $link_url = get_sub_field('link_url');
    $solutions .= '
    "solutions_items_0_title":"'.$title.'",
    "_solutions_items_0_title":"field_6364318f9215a",
    "solutions_items_0_text":"'.$text.'",
    "_solutions_items_0_text":"field_636431ae9215b",
    "solutions_items_0_link_text":"'.$link_text.'",
    "_solutions_items_0_link_text":"field_636431c79215c",
    "solutions_items_0_link_url":"'.$link_url.'",
    "_solutions_items_0_link_url":"field_636431d79215d",';
    endwhile;

    $solutions .=
        '"solutions_items":'.count(get_field('solutions_items', $thisPageId)).',"_solutions_items":"field_6364314092159"},"mode":"edit"} /-->';

    endif;

    /**
     * Expertise / Quick Facts
     */
    $quickFacts = '';
    if (have_rows('quick_facts_items', $thisPageId)) :
        $quick_facts_title = get_field('quick_facts_title', $thisPageId);
        $quick_facts_desc = get_field('quick_facts_desc', $thisPageId);

        $quickFacts .= '<!-- wp:acf/quick-facts {"name":"acf/quick-facts","data":{"quick_facts_title":"'.$quick_facts_title.'","_quick_facts_title":"field_63648aa5720eb","quick_facts_desc":"'.$quick_facts_desc.'","_quick_facts_desc":"field_63648adc720ec",';


        while (have_rows('quick_facts_items', $thisPageId)) : the_row();
            $text = get_sub_field('text');
            $image = get_sub_field('image');
            $link = get_sub_field('link');

            $quickFacts .= '"quick_facts_items_0_image":'.$image['ID'].',"_quick_facts_items_0_image":"field_63648afe720ee","quick_facts_items_0_text":"'.$text.'","_quick_facts_items_0_text":"field_63648b16720ef","quick_facts_items_0_link":"'.$link.'","_quick_facts_items_0_link":"field_63648b29720f0",';
        endwhile;

        $quickFacts .= '"quick_facts_items":'.count(get_field('quick_facts_items', $thisPageId)).',"_quick_facts_items":"field_63648ae5720ed"},"mode":"edit"} /-->';
    endif;


    /**
     * Resources
     */



    /**
     * CTA
     */
    $mkto_form_id = get_field('mkto_form_id', $thisPageId);
    if (empty($mkto_form_id)) :
        $mkto_form_id = 4431;
    endif;
    $cta_title = get_field('cta_title', $thisPageId);
    $cta = '<!-- wp:acf/contact-form-full-width {"name":"acf/contact-form-full-width","data":{"cta_title":"'.$cta_title.'","_cta_title":"field_636499cef8c40","marketo_form_id":"'.$mkto_form_id.'","_marketo_form_id":"field_636499ebf8c41"},"mode":"edit"} /-->';


    $content = $hero.$half.$featThree.$solutions.$quickFacts.$cta;
    /**
     * Replace all content with the previous content from above
     */
    $data = array(
        'ID' => $thisPageId,
        'post_content' => $content,
    );
    $update_post = wp_update_post($data, true, false);

    /**
     * Check the box to use Gutenberg
     */
    update_field('use_gutenberg', ['true'], [$thisPageId]);

    echo htmlentities($update_post);
    echo '<br>';

    if (is_wp_error($update_post)) {
        $errors = $update_post->get_error_messages();
        foreach ($errors as $error) {
            echo $error;
        }
    }

endforeach;