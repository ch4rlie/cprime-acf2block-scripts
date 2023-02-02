<?php
set_time_limit(500);
require_once('wp-load.php');
define('WP_USE_THEMES', false);
remove_action('pre_post_update', 'wp_save_post_revision');
global $wpdb;

$args = array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'template_solution.php',
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


         $hero_background = get_field('hero_background', $thisPageId);
         $hero_icon = get_field('hero_icon', $thisPageId);
         $hero_short_title = get_field('hero_short_title', $thisPageId);
         $hero_main_title = get_field('hero_main_title', $thisPageId);
         $text_above_form = get_field('text_above_form', $thisPageId);

         $intro_paragraph = get_field('intro_paragraph', $thisPageId);

         $graphic_area_title = get_field('graphic_area_title', $thisPageId);
         $graphic = get_field('graphic', $thisPageId);

         $organizations_title = get_field('organizations_title', $thisPageId);
         $resources_title = get_field('resources_title', $thisPageId);

          $mkto_form_id = 4431;
         
         /**
          * Solutions Hero
          */
         $content = '
          <!-- wp:group {"className":"hero-bg-area-block"} -->
          <div class="wp-block-group hero-bg-area-block">
               <!-- wp:group {"className":"container"} -->
               <div class="wp-block-group container">
                    <!-- wp:group {"className":"flexed section-one"} -->
                    <div class="wp-block-group flexed section-one">
                         <!-- wp:group {"className":"intro-text"} -->
                         <div class="wp-block-group intro-text">
                              <!-- wp:group {"className":"flexed"} -->
                              <div class="wp-block-group flexed">';

                                   if (!empty($hero_icon)): 
                                        $content .= '<!-- wp:group {"className":"icon"} -->
                                        <div class="wp-block-group icon">
                                             <!-- wp:image -->
                                             <figure class="wp-block-image"><img src="'. $hero_icon['sizes']['thumbnail'] .'" alt="'. $hero_icon['alt'] .'" /></figure>
                                             <!-- /wp:image -->
                                        </div>
                                        <!-- /wp:group -->';
                                   endif;

                                   if (!empty($hero_main_title) || !empty($hero_short_title)) {
                                        # code...
                                   }
                                   $content .= '<!-- wp:group {"className":"text"} -->
                                   <div class="wp-block-group text">';
                                        if (!empty($hero_short_title)):
                                             $content .= '<!-- wp:heading {"level":3} --><h3>'. strip_tags($hero_short_title) .'</h3><!-- /wp:heading -->';
                                        endif;

                                        if (!empty($hero_main_title)):
                                             $content .= '<!-- wp:heading {"level":1} --><h1>'. strip_tags($hero_main_title) .'</h1><!-- /wp:heading -->';
                                        endif;
                                  $content .= ' 
                                  </div>
                                   <!-- /wp:group -->

                              </div>
                              <!-- /wp:group -->
                         </div>
                         <!-- /wp:group -->
                    </div>
                    <!-- /wp:group -->';

                    // Four Items
                    if (have_rows('four_items', $thisPageId)) :
                         $content .= '
                         <!-- wp:group {"className":"section-two"} -->
                         <div class="wp-block-group section-two">';

                              if (!empty($intro_paragraph)):
                                   $content .'<!-- wp:paragraph {"className":"section-intro"} -->
                                   <p class="section-intro">'. strip_tags($intro_paragraph) .'</p>
                                   <!-- /wp:paragraph -->';
                              endif;

                              $content .= '
                              <!-- wp:group {"className":"boxes"} -->
                              <div class="wp-block-group boxes">';
                                 while (have_rows('four_items', $thisPageId)) : the_row();
                                     $icon = get_sub_field('icon');
                                     $title = get_sub_field('title');
                                     $text = get_sub_field('text');

                                     $content .= '<!-- wp:group {"className":"box"} --><div class="wp-block-group box">';
                                     if ($icon) :
                                         $content .= '<!-- wp:image {"sizeSlug":"thumbnail"} --><figure class="wp-block-image size-thumbnail"><img src="'.$icon['sizes']['thumbnail'].'" alt=""/></figure><!-- /wp:image -->';
                                     endif;
                                     if ($title) :
                                         $content .= '<!-- wp:heading {"level":4} --><h4>'.strip_tags($title).'</h4><!-- /wp:heading -->';
                                     endif;
                                     if ($text) :
                                         $content .= '<!-- wp:paragraph --><p>'.strip_tags($text).'</p><!-- /wp:paragraph -->';
                                     endif;
                                     $content .= '</div><!-- /wp:group -->';
                                 endwhile;

                              $content .= '
                              </div>
                              <!-- /wp:group -->
                         </div>
                         <!-- /wp:group -->';
                    endif;

               $content .= '
               </div>
               <!-- /wp:group -->';

               if($hero_background):
                    $content .= '
                    <!-- wp:image {"id":'.$hero_background['ID'].',"linkDestination":"none","className":"abs-hero"} -->
                         <figure class="wp-block-image size-large abs-hero"><img src="'.$hero_background['url'].'" alt="'.$hero_background['alt'].'" class="wp-image-'.$hero_background['ID'].'"/></figure>
                    <!-- /wp:image -->';
               endif;

          $content .= '</div>
          <!-- /wp:group -->';


         /**
          *  Graphic Section
          */
          if (!empty($graphic) ) :
                  $content .= '
                    <!-- wp:acf/cprime-default-block {"name":"acf/cprime-default-block","data":{"background_color":"beige","_background_color":"field_636beb1228350","background_image":"","_background_image":"field_636bebb928352","container":"container","_container":"field_636beb7d28351"},"mode":"preview"} -->
                         <!-- wp:heading -->
                         <h2>'.strip_tags($graphic_area_title).'</h2>
                         <!-- /wp:heading -->

                         <!-- wp:image {"align":"center", "sizeSlug":"large"} -->
                         <figure class="wp-block-image aligncenter size-large"><img src="'.$graphic['sizes']['large'].'" alt="'.$graphic['alt'].'"/></figure>
                         <!-- /wp:image -->
                    <!-- /wp:acf/cprime-default-block -->';
          endif;


         /**
          *  Alternating Product Services
          */
          $alternating_boxes_title = get_field('alternating_boxes_title', $thisPageId);
          if (have_rows('products_services', $thisPageId)) :
               $content .= '
               <!-- wp:acf/cprime-default-block {"name":"acf/cprime-default-block","data":{"background_color":"white","_background_color":"field_636beb1228350","background_image":"","_background_image":"field_636bebb928352","container":"full-width","_container":"field_636beb7d28351"},"mode":"preview"} -->';

                    // Section Title
                    $hide_section_title = get_field('hide_section_title', $thisPageId);
                    if (!$hide_section_title) :
                      if (!empty($alternating_boxes_title)) :
                          $abt_title = strip_tags($alternating_boxes_title);
                      else :
                          $abt_title = "Our Approach";
                      endif;

                      $content .= '<!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">'.$abt_title.'</h2><!-- /wp:heading -->';
                    endif;

                    //Alternating Boxes
                    $i=1;
                    while(have_rows('products_services', $thisPageId)) : the_row();

                         
                         if($i % 2 == 0) :
                              $variation = "a";
                         else :
                              $variation = "b";
                         endif;
                         $i++;

                         $image = get_sub_field('image');
                         $title = get_sub_field('title');
                         $text = get_sub_field('text');
                         $link_text = get_sub_field('link_text');
                         $link_url = get_sub_field('link_url');

                         $content .= '
                         <!-- wp:acf/alternating-content {"name":"acf/alternating-content","data":{"field_6376de4592b0d":"'. $image["id"] .'","field_6376df8892b0e":"variation-'. $variation .'"},"mode":"preview"} -->
                         <!-- wp:heading {"level":4} -->
                         <h4>'.strip_tags($title).'</h4>
                         <!-- /wp:heading -->

                         <!-- wp:paragraph -->
                         <p>'.strip_tags($text).'</p>
                         <!-- /wp:paragraph -->';

                         if ($link_url && $link_text) :
                         $content .= '
                              <!-- wp:paragraph -->
                              <p><a href="'.$link_url.'" target="_blank">'.strip_tags($link_text).'</a></p>
                              <!-- /wp:paragraph -->';
                         endif;


                         $content .= '<!-- /wp:acf/alternating-content -->';
                    endwhile;

               $content .= '
               <!-- /wp:acf/cprime-default-block -->';
          endif;


         /**
          *  Organizations
          */

         if (have_rows('organizations', $thisPageId)) :
          $content .='
          <!-- wp:acf/cprime-default-block {"name":"acf/cprime-default-block","data":{"background_color":"beige","_background_color":"field_636beb1228350","background_image":"","_background_image":"field_636bebb928352","container":"full-width","_container":"field_636beb7d28351"},"mode":"preview"} -->
          <!-- wp:group {"className":"basic-grey-three-item"} -->
          <div class="wp-block-group basic-grey-three-item">
               <!-- wp:group {"className":"container"} -->
               <div class="wp-block-group container">
                    <!-- wp:group {"className":"flexed"} -->
                    <div class="wp-block-group flexed">';

                    while (have_rows('organizations', $thisPageId)) : the_row();
                         $company_logo = get_sub_field('company_logo');
                         $title = get_sub_field('title');
                         $text = get_sub_field('text');
                         $url = get_sub_field('url');

                         $content .='
                         <!-- wp:group {"className":"item"} -->
                         <div class="wp-block-group item">';

                              if (!empty($company_logo)) :
                                   $content .='
                                   <!-- wp:image {"sizeSlug":"thumbnail"} -->
                                   <figure class="wp-block-image size-thumbnail"><img src="'. $company_logo['sizes']['thumbnail'] .'" alt="'.$company_logo['alt'].'" /></figure>
                                   <!-- /wp:image -->';
                              endif;

                              if (!empty($title)) :
                              $content .='
                                   <!-- wp:heading {"level":4} -->
                                   <h4>'. strip_tags($title) .'</h4>
                                   <!-- /wp:heading -->';
                              endif;

                              if (!empty($text)) :
                              $content .='
                                   <!-- wp:paragraph -->
                                   <p>'. strip_tags($text) .'</p>
                                   <!-- /wp:paragraph -->';
                              endif;

                              if (!empty($url)) :
                              $content .='
                                   <!-- wp:paragraph -->
                                   <p><a href="'. $url .'">Read their story &gt;</a></p>
                                   <!-- /wp:paragraph -->';
                              endif;

                         $content .='
                         </div>
                         <!-- /wp:group -->';

                    endwhile;

          $content .='
                    </div>
                    <!-- /wp:group -->
               </div>
               <!-- /wp:group -->
          </div>
          <!-- /wp:group -->
          <!-- /wp:acf/cprime-default-block -->';
         endif;



          /**
          * Content Above Resources
          */    
          if (get_field('content_above_resources', $thisPageId)) : 
               $abv_res_content = get_field('content_above_resources', $thisPageId); 
               $content .= '<!-- wp:acf/cprime-default-block {"name":"acf/cprime-default-block","data":{"field_636beb1228350":"white","field_636bebb928352":"","field_636beb7d28351":"container"},"mode":"preview"} -->
               <!-- wp:html -->'. $abv_res_content .'<!-- /wp:html -->
               <!-- /wp:acf/cprime-default-block -->';
          endif;


          /**
          * Resources
          */
          $i=0;

          $content .= '<!-- wp:acf/resource-picker {"name":"acf/resource-picker","data":{"background_image":"","_background_image":"field_6375230758cd9",';
          if (have_rows('resources', $thisPageId)) : while (have_rows('resources', $thisPageId)) : the_row();
             $resource = get_sub_field('resource');
             if ($resource) :
                 $content .= '"resources_'.$i.'_resource":'.$resource->ID.',"_resources_'.$i.'_resource":"field_63658c67f6bef",';
                 $i++;
             endif;
          endwhile;
          endif;

          $content .= '"resources":'.$i.',"_resources":"field_63658adf3a188"},"mode":"preview"} -->';
          if ($resources_title) : $content .= '<!-- wp:heading {"level":2} -->
             <h2>'.strip_tags($resources_title).'</h2>
             <!-- /wp:heading -->';
          endif;
          $content .= '<!-- /wp:acf/resource-picker -->';


         /**
          * Contact 
          */
         $cta_title = get_field('text_above_form', $thisPageId);
         $content .= '<!-- wp:acf/contact-form {"name":"acf/contact-form","data":{"field_636499ebf8c41":"'. $mkto_form_id .'","field_63740040a9d38":"full-width"},"mode":"preview"} -->';
         if ($cta_title) :
             $content .= '<!-- wp:heading -->
             <h2>'.strip_tags($cta_title).'</h2>
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
          * Update to Page.php
          */
          update_post_meta( $thisPageId, '_wp_page_template', sanitize_text_field( 'default' ) );


         /**
          * Update the use_gutenberg field for this post
          */
         update_field('use_gutenberg', 1, $thisPageId);

         if (is_wp_error($update_post)) {
             $errors = $update_post->get_error_messages();
             foreach ($errors as $error) {
                 echo "ERROR ON $thisPageId";
                 echo "<br />";
                 echo $error;
             }
         }
         else {
             echo "Success on ". $thisPageId;
             echo "<br />";
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
             delete_field('content_above_resources', $thisPageId);
             

             // Delete Repeaters
             delete_field('resources', $thisPageId);
             delete_field('organizations', $thisPageId);
             delete_field('products_services', $thisPageId);
             delete_field('four_items', $thisPageId);
         }
     } //End of Gutenberg Check
endforeach;