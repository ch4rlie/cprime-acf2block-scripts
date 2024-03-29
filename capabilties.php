<?php
set_time_limit(500);
require_once('wp-load.php');
define('WP_USE_THEMES', false);
remove_action('pre_post_update', 'wp_save_post_revision');
global $wpdb;

$args = array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'template_capabilities.php',
    'post_status' => ['publish', 'draft'],
    'hierarchical' => false,

);

$pages = get_pages($args);
foreach ($pages as $page) :
    $thisPageId = $page->ID;
    $content = '';
    $use_gutenberg = get_field('use_gutenberg', $thisPageId);
    if ($use_gutenberg) {
      echo $thisPageId . ' already converted<br />';
    }else{
         /**
          * Process the hero
          */

         $hero = '<!-- wp:group {"className":"capabilities-hero"} --><div class="wp-block-group capabilities-hero">';
         $hero .= '<!-- wp:group {"className":"left"} --><div class="wp-block-group left">';

         $hero_product_logo = get_field('hero_product_logo', $thisPageId);
         if (!empty($hero_product_logo)) :
         $hero .= '<!-- wp:group {"className":"top-logo"} --><div class="wp-block-group top-logo"><!-- wp:image {className":"size-medium"} --><figure class="wp-block-image size-medium"><img src="'.$hero_product_logo['sizes']['medium'].'" alt="'.$hero_product_logo['alt'].'" /></figure><!-- /wp:image --></div><!-- /wp:group -->';
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

         $cta_button = get_field('cta_button', $thisPageId);
         $cta_link = '#cta';
         $cta_class = 'scroll-offset';
         $cta_override = get_field('cta_link_override', $thisPageId);
         if (!empty($cta_override)) :
             $cta_link = $cta_override;
             $first_char_link = mb_substr($cta_override, 0, 1, 'utf-8');
             if ( $first_char_link != '#' ) :
                 $cta_class = '';
             endif;
         endif;

         if (!empty($cta_button)) :
             $hero .= '<!-- wp:buttons -->
             <div class="wp-block-buttons"><!-- wp:button {"className":"is-style-fill '.$cta_class.'"} -->
             <div class="wp-block-button is-style-fill '.$cta_class.'"><a href="'.$cta_link.'" class="wp-block-button__link">'.$cta_button.'</a></div>
             <!-- /wp:button --></div>
             <!-- /wp:buttons -->';
         endif;


     $hero .= '</div><!-- /wp:group -->';
     $hero .= '</div><!-- /wp:group -->';

     $hero .= '<!-- wp:group {"className":"right"} -->
     <div class="wp-block-group right">';


     $main_hero_image = get_field('main_hero_image', $thisPageId);

     if (!empty($main_hero_image)) :
     $hero .= '<!-- wp:image {"id":'.$main_hero_image['ID'].',"width":'.$main_hero_image['sizes']['large-width'].',"height":'.$main_hero_image['sizes']['large-height'].',"sizeSlug":"large"} -->
     <figure class="wp-block-image size-large"><img src="'.$main_hero_image['sizes']['large'].'" alt="'.$main_hero_image['alt'].'" class="wp-image-'.$main_hero_image['ID'].'" height="'.$main_hero_image['sizes']['large-height'].'" width="'.$main_hero_image['sizes']['large-width'].'"/></figure>
     <!-- /wp:image -->';
     endif;

     $hero .= '</div><!-- /wp:group -->';
     $hero .= '</div><!-- /wp:group -->';







         /**
          * Feat Two
          *
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
         <!-- /wp:image -->';
         endif;

     $half .= '</div><!-- /wp:group -->';

     if ($intro_title || $intro_sub_title) :
     $half .= '
     <!-- wp:group {"className":"half"} -->
     <div class="wp-block-group half">
     <!-- wp:heading {"level":3} -->
     <h3>'.$intro_title.'</h3>
     <!-- /wp:heading -->
     <!-- wp:paragraph -->
     '.$intro_sub_title.'
     <!-- /wp:paragraph -->
     </div><!-- /wp:group -->';
     endif;

     $half .= '</div><!-- /wp:group -->
     </div><!-- /wp:group -->';

     endif;


         /**
          * Feat Three
          */
         $featThree = '';
         if (have_rows('intro_three_columns', $thisPageId)) :
         $featThree = '<!-- wp:group {"className":"feat-three-block"} --><div class="wp-block-group feat-three-block">';
             while (have_rows('intro_three_columns', $thisPageId)) : the_row();
                 $title = get_sub_field('title');
                 $text = get_sub_field('text');

                 $featThree .= '<!-- wp:group {"className":"item"} --><div class="wp-block-group item"><!-- wp:heading {"level":3} -->
                 <h3>'.$title.'</h3>
                 <!-- /wp:heading -->
                 <!-- wp:paragraph -->
                 '.$text.'
                 <!-- /wp:paragraph --></div><!-- /wp:group -->';
             endwhile;


     $featThree .= '</div><!-- /wp:group -->';

         endif;


         /**
          * Solutions
          */
         $solutions = '';
         $solutions_title = get_field('solutions_title', $thisPageId);
         $solutions_sub_title = get_field('solutions_sub_title', $thisPageId);
         $solutions_fixed_image = get_field('solutions_fixed_image', $thisPageId);

         if (have_rows('solutions_items', $thisPageId)) :
         $solutions = '<!-- wp:acf/cprime-default-block {"name":"acf/cprime-default-block","data":{"background_color":"beige","_background_color":"field_636beb1228350","background_image":"","_background_image":"field_636bebb928352","container":"full-width","_container":"field_636beb7d28351"},"mode":"preview"} -->';

          if (!empty($solutions_title)) :
               $solutions .= '<!-- wp:heading {"textAlign":"center","className":"section-title"} --><h2 class="has-text-align-center section-title">'. $solutions_title .'</h2><!-- /wp:heading -->';
          endif;
          if (!empty($solutions_sub_title)) :
               $solutions .= '<!-- wp:paragraph {"align":"center","className":"sub"} --><p class="has-text-align-center sub">'. $solutions_sub_title .'</p><!-- /wp:paragraph -->';
          endif;

         $solutions .= '<!-- wp:acf/solutions-content {"name":"acf/solutions-content","data":{"solutions_fixed_image":'.$solutions_fixed_image['ID'].',"_solutions_fixed_image":"field_6364312192157"},"mode":"preview"} -->';
         $i=0;
         while (have_rows('solutions_items', $thisPageId)): the_row();
             $title = get_sub_field('title');
             $text = get_sub_field('text');
             $link_text = get_sub_field('link_text');
             $link_url = get_sub_field('link_url');

             if ($title) : $solutions .= '<!-- wp:heading {"level":3} --><h3>'.$title.'</h3><!-- /wp:heading -->'; endif;

             if ($text) :  $solutions .= '<!-- wp:paragraph -->'.$text.'<!-- /wp:paragraph -->'; endif;

             if ($link_url && $link_text) : $solutions .= '<!-- wp:paragraph --><p><a target="_blank" href="'.$link_url.'">'.$link_text.'</a></p><!-- /wp:paragraph -->'; endif;

             $i++;
         endwhile;

         $solutions .=  '<!-- /wp:acf/solutions-content --><!-- /wp:acf/cprime-default-block -->';

         endif;

         /**
          * Expertise / Quick Facts
          */
         $quickFacts = '';
         if (have_rows('quick_facts_items', $thisPageId)) :
             $quick_facts_title = get_field('quick_facts_title', $thisPageId);
             $quick_facts_desc = get_field('quick_facts_desc', $thisPageId);

             $quickFacts .= '<!-- wp:acf/quick-facts {"name":"acf/quick-facts","data":{';

             $i = 0;
             while (have_rows('quick_facts_items', $thisPageId)) : the_row();
                 $text = get_sub_field('text');
                 $image = get_sub_field('image');
                 $link = get_sub_field('link');

                 if (is_array($image)) $quickFacts .= '"quick_facts_items_'.$i.'_image":'.$image['ID'].',';
                 $quickFacts .= '"_quick_facts_items_'.$i.'_image":"field_63648afe720ee","quick_facts_items_'.$i.'_text":"'.$text.'","_quick_facts_items_'.$i.'_text":"field_63648b16720ef","quick_facts_items_'.$i.'_link":"'.$link.'","_quick_facts_items_'.$i.'_link":"field_63648b29720f0",';

                 $i++;
             endwhile;

             $quickFacts .= '"quick_facts_items":'.count(get_field('quick_facts_items', $thisPageId)).',"_quick_facts_items":"field_63648ae5720ed"},"mode":"edit"} -->';
             if ($quick_facts_title) $quickFacts .= '<!-- wp:heading --><h2>'.$quick_facts_title.'</h2><!-- /wp:heading -->';
             if ($quick_facts_desc) $quickFacts .= '<!-- wp:paragraph --><p>'.$quick_facts_desc.'</p><!-- /wp:paragraph -->';
             $quickFacts .= '<!-- /wp:acf/quick-facts -->';
         endif;


         /**
          * Resources
          */
         $resources_title = get_field('resources_title', $thisPageId);
         $ft_r_id = get_field('featured_resource', $thisPageId);
         $i=0;

         $resources = '<!-- wp:acf/resource-picker {"name":"acf/resource-picker","data":{';

         if ($ft_r_id) :
             $resources .= '"resources_0_resource":'.$ft_r_id.',"_resources_0_resource":"field_63658c67f6bef",';
             $i++;
         endif;

         if (have_rows('three_resources', $thisPageId)) : while (have_rows('three_resources', $thisPageId)) : the_row();
             $resource = get_sub_field('resource');
             if ($resource) :
                 $resources .= '"resources_'.$i.'_resource":'.$resource.',"_resources_'.$i.'_resource":"field_63658c67f6bef",';
                 $i++;
             endif;
             endwhile;
         endif;
         
         $resources .= '"resources":'.$i.',"_resources":"field_63658adf3a188"},"mode":"preview"} -->';
         if ($resources_title) : $resources .= '<!-- wp:heading {"level":2} -->
             <h2>'.$resources_title.'</h2>
             <!-- /wp:heading -->';
         endif;
         $resources .= '<!-- /wp:acf/resource-picker -->';

         /**
          * CTA
          */
         $mkto_form_id = get_field('mkto_form_id', $thisPageId);
         if (empty($mkto_form_id)) :
             $mkto_form_id = 4431;
         endif;
         $cta_title = get_field('cta_title', $thisPageId);
         $cta = '<!-- wp:acf/contact-form {"name":"acf/contact-form","data":{"field_636499ebf8c41":"'.$mkto_form_id.'","field_63740040a9d38":"full-width"},"mode":"preview"} -->';
         if ($cta_title) :
             $cta .= '<!-- wp:heading -->
             <h2>'.$cta_title.'</h2>
             <!-- /wp:heading -->';
         endif;
         $cta .= '<!-- /wp:acf/contact-form -->';

         /**
          * Manually remove everything from this posts the_content
          *
          */
         $delete_content = $wpdb->update ( 'wp_posts', ['post_content' => ''], ['ID' => $thisPageId] );

         $content = $hero.$half.$featThree.$solutions.$quickFacts.$resources.$cta;
         /**
          * Replace all content with the previous content from above
          */
         $data = array(
             'ID' => $thisPageId,
             'post_content' => $content,
         );
         $update_post = wp_update_post($data, true, false);


         

         /**
          * Update to Page.php
          */
          update_post_meta( $thisPageId, '_wp_page_template', sanitize_text_field( 'default' ) );

         /**
          * Check the box to use Gutenberg
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
             echo "Success on " . $thisPageId;
             echo "<br />";

             
              /**
               * Delete ACF Post Data
               */
               delete_field( 'logo_max_height', $thisPageId );
               delete_field( 'hero_product_logo', $thisPageId );
               delete_field( 'main_hero_image', $thisPageId );
               delete_field( 'hero_title', $thisPageId );
               delete_field( 'hero_sub_title', $thisPageId );
               delete_field( 'cta_button', $thisPageId );
               delete_field( 'cta_link_override', $thisPageId );
               delete_field( 'intro_image', $thisPageId );
               delete_field( 'intro_video', $thisPageId );
               delete_field( 'intro_title', $thisPageId );
               delete_field( 'intro_sub_title', $thisPageId );
               delete_field( 'intro_three_columns', $thisPageId );
               delete_field( 'solutions_title', $thisPageId );
               delete_field( 'solutions_sub_title', $thisPageId );
               delete_field( 'solutions_fixed_image', $thisPageId );
               delete_field( 'solutions_items', $thisPageId );
               delete_field( 'quick_facts_title', $thisPageId );
               delete_field( 'quick_facts_desc', $thisPageId );
               delete_field( 'quick_facts_items', $thisPageId );
               delete_field( 'resources_title', $thisPageId );
               delete_field( 'featured_resource', $thisPageId );
               delete_field( 'featured_resource_snippet', $thisPageId );
               delete_field( 'featured_resource_link_text', $thisPageId );
               delete_field( 'three_resources', $thisPageId );
               delete_field( 'cta_title', $thisPageId );
               delete_field( 'cta_form_url', $thisPageId );
               delete_field( 'mkto_form_id', $thisPageId );



         }
     } //End of gutenberg check

endforeach;