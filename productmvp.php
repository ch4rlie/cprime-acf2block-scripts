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

    $use_gutenberg = get_field('use_gutenberg', $thisPageId);
    if ($use_gutenberg) {
      echo $thisPageId . ' already converted<br />';
    }else{

         $mkto_form_id = get_field('mkto_form_id', $thisPageId);
         if (empty($mkto_form_id)) :
             $mkto_form_id = 4431;
         endif;


         $content = '';

         /**
          * Hero
          */
         $hero_background = get_field('hero_background', $thisPageId);
         $hero_title = get_field('hero_title', $thisPageId);
         $hero_sub_title = get_field('hero_sub_title', $thisPageId);
         $hero_button_text = get_field('hero_button_text', $thisPageId);
         $hero_button_url = get_field('hero_button_url', $thisPageId);
         $content .= '<!-- wp:group {"className":"product-hero-mvp"} --><div class="wp-block-group product-hero-mvp">';

             if ($hero_background) :
                 $content .= '<!-- wp:image {"sizeSlug":"large","className":"bg-img"} -->
                 <figure class="wp-block-image size-large bg-img"><img src="'.$hero_background.'" alt=""/></figure>
                 <!-- /wp:image -->';
             endif;
                 
              $content .= '<!-- wp:group {"className":"holder"} --><div class="wp-block-group holder">';
                 if ($hero_title) :
                     $content .= '<!-- wp:heading {"level":1} -->
                     <h1>'.strip_tags($hero_title).'</h1>
                     <!-- /wp:heading -->';
                 endif;
                 if ($hero_sub_title) :
                     $content .= '<!-- wp:paragraph -->
                     <p>'.strip_tags($hero_sub_title).'</p>
                     <!-- /wp:paragraph -->';
                 endif;
                 if ($hero_button_text) :
                     if (empty($hero_button_url)) :
                         $hero_button_url = '#cta';
                     endif;
                     $content .= '<!-- wp:buttons -->
                     <div class="wp-block-buttons"><!-- wp:button {"className":"is-style-fill"} -->
                     <div class="wp-block-button is-style-fill"><a class="wp-block-button__link" href="'.$hero_button_url.'">'.strip_tags($hero_button_text).'</a></div>
                     <!-- /wp:button --></div>
                     <!-- /wp:buttons -->';
                 endif;



             $content .= '</div><!-- /wp:group -->';
         
         $content .= '</div><!-- /wp:group -->';


         /**
          * Open Content
          */
         $open_content = get_field('open_content', $thisPageId);
         if ($open_content) :
         $content .= '<!-- wp:acf/cprime-default-block {"name":"acf/cprime-default-block","data":{"field_636beb1228350":"white","field_636bebb928352":"","field_636beb7d28351":"container"},"mode":"preview"} -->';
         $content .= '<!-- wp:paragraph -->'.$open_content.'<!-- /wp:paragraph -->';
         $content .= '<!-- /wp:acf/cprime-default-block -->';
         endif;




         /**
          * Three item section
          */
         if (have_rows('three_item', $thisPageId)) :
         $content .= '<!-- wp:group {"className":"basic-grey-three-item"} --><div class="wp-block-group basic-grey-three-item">
          <!-- wp:group {"className":"container"} --><div class="wp-block-group container">
          <!-- wp:group {"className":"flexed"} --><div class="wp-block-group flexed">';
              while (have_rows('three_item', $thisPageId)) : the_row();
                  $icon = get_sub_field('icon');
                  $title = get_sub_field('title');
                  $text = get_sub_field('text');
              $content .= '<!-- wp:group {"className":"item"} --><div class="wp-block-group item">';

                  $content .= '<!-- wp:heading {"level":4} -->
                    <h4>'.strip_tags($title).'</h4>
                    <!-- /wp:heading -->';

                  $content .= '<!-- wp:html -->'. $text .'<!-- /wp:html -->';
                  $content .= '</div><!-- /wp:group -->';


              endwhile;
              $content .= '</div><!-- /wp:group -->
          </div><!-- /wp:group -->
          </div><!-- /wp:group -->';


         endif;




         /**
          * Featured Section
          */
          $ft_title = get_field('feature_title', $thisPageId);
          $ft_text = get_field('feature_text', $thisPageId);
          $ft_image = get_field('feature_image', $thisPageId);

          if ($ft_image || $ft_text || $ft_title) :
               $content .= '<!-- wp:group {"className":"container-beige-section"} --><div class="wp-block-group container-beige-section">
               <!-- wp:group {"className":"container"} --><div class="wp-block-group container">';
               if ($ft_title): 
                    $content .= '<!-- wp:heading {"level":2} --><h2>'.strip_tags($ft_title).'</h2><!-- /wp:heading -->';
               endif;
               if ($ft_text):
                    $content .= '<!-- wp:html -->'.$ft_text.'<!-- /wp:html -->';
               endif;
               if ($ft_image):
                    $content .= '<!-- wp:image {"sizeSlug":"large"} -->
               <figure class="wp-block-image size-large"><img src="'.$ft_image['sizes']['large'].'" alt="'.$ft_image['alt'].'"/></figure>
               <!-- /wp:image -->';
               endif;

               $content .= '</div><!-- /wp:group -->
               </div><!-- /wp:group -->';

          endif;




          /**
          * Resources
          */
          $i=0;
          $resources_title = "Related Resources";
          $content .= '<!-- wp:acf/resource-picker {"name":"acf/resource-picker","data":{"background_image":"","_background_image":"field_6375230758cd9",';
          if (have_rows('related_resources', $thisPageId)) : while (have_rows('related_resources', $thisPageId)) : the_row();
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
          * CTA
          */
         $cta_title = get_field('form_title', $thisPageId);
         if (empty($cta_title)) {
              $cta_title = "Let's Talk";
         }
         $content .= '<!-- wp:acf/contact-form {"name":"acf/contact-form","data":{"field_636499ebf8c41":"'. $mkto_form_id .'","field_63740040a9d38":"full-width"},"mode":"preview"} -->';
         if ($cta_title) :
             $content .= '<!-- wp:heading --><h2>'. $cta_title .'</h2><!-- /wp:heading -->';
             $content .= get_field('pre_form_content');
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
          // update_post_meta( $thisPageId, '_wp_page_template', sanitize_text_field( 'default' ) );


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
             echo "Success on $thisPageId<br />";
             /**
              * TODO: Delete all data for these acf fields on the page to clear out wp_postmeta
              */
             // delete_field('hero_background', $thisPageId);
             // delete_field('hero_title', $thisPageId);
             // delete_field('hero_sub_title', $thisPageId);
             // delete_field('hero_button_text', $thisPageId);
             // delete_field('hero_button_url', $thisPageId);
             // delete_field('mkto_form_id', $thisPageId);
             // delete_field('open_content', $thisPageId);
             // delete_field('three_item', $thisPageId);
             // delete_field('feature_title', $thisPageId);
             // delete_field('feature_text', $thisPageId);
             // delete_field('feature_image', $thisPageId);
             // delete_field('related_resources', $thisPageId);
             // delete_field('pre_form_content', $thisPageId);
             // delete_field('form_title', $thisPageId);
             // delete_field('mkto_form_id', $thisPageId);
         }
     } //End of gutenberg check
endforeach;