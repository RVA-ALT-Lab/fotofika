<?php
/**
 * Understrap functions and definitions
 *
 * @package understrap
 */

/**
 * Initialize theme default settings
 */
require get_template_directory() . '/inc/theme-settings.php';

/**
 * Theme setup and custom theme supports.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Register widget area.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom pagination for this theme.
 */
require get_template_directory() . '/inc/pagination.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Comments file.
 */
require get_template_directory() . '/inc/custom-comments.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
require get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

/**
 * Load WooCommerce functions.
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Load Editor functions.
 */
require get_template_directory() . '/inc/editor.php';


//ADD FONTS and VCU Brand Bar
add_action('wp_enqueue_scripts', 'alt_lab_scripts');
function alt_lab_scripts() {
  $query_args = array(
    'family' => 'Oswald:400,500,700|Roboto+Regular:100,300',
    'subset' => 'latin,latin-ext',
  );
  wp_enqueue_style ( 'google_fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );

  wp_enqueue_script( 'vcu_brand_bar', 'https:///branding.vcu.edu/bar/academic/latest.js', array(), '1.1.1', true );

  wp_enqueue_script( 'alt_lab_js', get_template_directory_uri() . '/js/alt-lab.js', array(), '1.1.1', true );
    }

//add footer widget areas
if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name' => 'Footer - far left',
    'id' => 'footer-far-left',    
    'before_widget' => '<div class = "widgetizedArea">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  )
);

if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name' => 'Footer - medium left',
    'id' => 'footer-med-left',    
    'before_widget' => '<div class = "widgetizedArea">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  )
);


if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name' => 'Footer - medium right',
    'id' => 'footer-med-right',    
    'before_widget' => '<div class = "widgetizedArea">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  )
);

if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name' => 'Footer - far right',
    'id' => 'footer-far-right',
    'before_widget' => '<div class = "widgetizedArea">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  )
);

//set a path for IMGS

  if( !defined('THEME_IMG_PATH')){
   define( 'THEME_IMG_PATH', get_stylesheet_directory_uri() . '/imgs/' );
  }


function bannerMaker(){
  global $post;
   if ( get_the_post_thumbnail_url( $post->ID ) ) {
      //$thumbnail_id = get_post_thumbnail_id( $post->ID );
      $thumb_url = get_the_post_thumbnail_url($post->ID);
      //$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

        return '<div class="jumbotron custom-header-img" style="background-image:url('. $thumb_url .')"></div>';

    } 
}



//get challenge submissions from gravity forms
function get_challenges($page, $tag){
    $search_criteria = array(
      'status'        => 'active',
      'key' => 'date_created', 
      'field_filters' => array(
          'mode' => 'any',
          array(
              'key'   => '5',
              'value' => $tag
          ),     
      )
  );

   $sorting = array(
    'key' => "date_created", 
    'direction' => "ASC",
    "type" => "info");   
    $paging          = array( 'offset' => 0, 'page_size' => 55 );
     

  $entries  = GFAPI::get_entries( 1, $search_criteria, $sorting, $paging );
  if ( !empty($entries) ){
 // var_dump($entries);
      echo '<div class="submitted-work col-md-12"><h3>Submitted Work</h3><ol>';
        foreach ($entries as $entry) {   
          $date = $entry['date_created'];  
          if (current_user_can('administrator')){
            $author = fieldThere($entry['1.3'] . ' ' . $entry['1.6']);
            $email = fieldThere($entry['2']);
            $author_link = '<span class="author"><a href="mailto:' . $email . '">' . $author . ' <i class="fa fa-envelope-o" aria-hidden="true"></i></a></span>';
          } else {
            $author_link = '';           
          }
          $album = fieldThere($entry['3']);
          $tag = fieldThere($entry['5']);
          $insta = clean_insta(fieldThere($entry['6']));
          echo '<li class="challenge-sub">' . $author_link . '<span class="album"> <a href="' . $album . '">album link <i class="fa fa-external-link" aria-hidden="true"></i></a></span><span class="date"> ' . $date . '</span><span class="insta"><a href="https://instagram.com/' . $insta .' "><i class="fa fa-instagram" aria-hidden="true"></i> ' . $insta . '</a></span></li>';
    }
      echo '</ol></div>';
  }
}


function clean_insta($insta){
  $clean_insta = preg_replace('/@/', '', $insta);
  return $clean_insta;
}

function fieldThere($field){
  if($field){
    return $field;
  } else {
    return 'not submitted';
  }
}

function acf_fetch_instagram_shortcode(){
  global $post;
  $html = '';
  $instagram_shortcode = get_field('instagram_shortcode');

    if( $instagram_shortcode) {      
      return $instagram_shortcode;  
    }

}


function acf_fetch_daily_challenge_description($tag){
  global $post;
   $tag = clean_tag($tag);
  $html = '<h2>Daily Practice</h2>';
  $daily_challenge_description = get_field('daily_challenge_description');

    if( $daily_challenge_description) {      
      $html .= '<div class="row"><div class="daily-description challenge col-md-6">' . $daily_challenge_description . '</div>';  
      $html .= '<div class="challenge-hashtag col-md-6"><h4>The Instagram hashtag for this assignment is</h4> <a class="main-hashtag" href="https://www.instagram.com/explore/tags/' . $tag . '">#' . $tag . '</a></div>';  
     return $html;    
    }

}



function acf_fetch_weekly_challenge_description($tag){
  global $post;
  $tag = clean_tag($tag);
  $html = '<h2>Weekly Assignment</h2>';
  $weekly_challenge_description = get_field('weekly_challenge_description');

    if( $weekly_challenge_description) {      
      $html .= '<div class="weekly-description challenge">' . $weekly_challenge_description . '</div>'; 
       $html .= '<div class="challenge-hashtag">The Instagram hashtag for this assignment is <a class="main-hashtag" href="https://www.instagram.com/explore/tags/' . $tag . '">#' . $tag . '</a>';
     return $html;    
    }

}



function acf_fetch_daily_challenge_hashtag(){
  global $post;
  $html = '<h2>Daily Practice</h2>';
  $daily_challenge_hashtag = get_field('daily_challenge_hashtag');

    if( $daily_challenge_hashtag) {      
      $html = $daily_challenge_hashtag;  
     return $html;    
    }

}



function acf_fetch_weekly_challenge_hashtag(){
  global $post;
  $html = '';
  $weekly_challenge_hashtag = get_field('weekly_challenge_hashtag');

    if( $weekly_challenge_hashtag) {      
      $html = $weekly_challenge_hashtag; 
      clean_tag($html); 
     return $html;    
    }

}



function acf_fetch_daily_challenge_hashtag_tag(){
  global $post;
  $html = '';
  $daily_challenge_hashtag = get_field('daily_challenge_hashtag');

    if( $daily_challenge_hashtag) {      
      $html = $daily_challenge_hashtag; 
      clean_tag($html); 
     return $html;    
    }

}

function challenge_submission_structure($tag){
  if($tag){
    $html  = '<button type="button" class="submit-work btn-photo" data-tag="' . $tag . '" data-toggle="modal" data-target="#submissionModal">Submit ' . $tag . ' Work </button>';
    return $html;
  }
}


function clean_tag($tag){
  $hash = substr($tag,0,1);
  if($hash == '#'){
    return substr($tag,1,strlen($tag));
  } else {
    return $tag;
  }
}


function get_the_artists(){
    // check if the repeater field has rows of data
  if( have_rows('artists') ):

    // loop through the rows of data
    echo '<h2 id="artists" class="magic-topics">Artists</h2>';
    echo '<div class="row">';
      while ( have_rows('artists') ) : the_row();

          // display a sub field value
          echo '<div class="col-md-4 artist"><div class="the-artist">';
          echo '<a href="' . get_sub_field('main_link') . '">';
          echo '<div class="artist-img"><img src="' . get_sub_field('artist_image') . '" alt="A photo of '. get_sub_field('artist_name') .'."></div></a>';
          echo '<h3>' . get_sub_field('artist_name') . '</h3>';
          echo  get_sub_field('artist_description');
          echo '</div></div>';

      endwhile;
    echo '</div>';

  else :

      // no rows found

  endif;
}

function get_the_tutorials(){
    // check if the repeater field has rows of data
  if( have_rows('tutorials') ):

    // loop through the rows of data
    echo '<h2 id="tutorials" class="magic-topics">Tutorials & Resources</h2>';
    echo '<div class="row tutorial-box">';
      while ( have_rows('tutorials') ) : the_row();
          $clean_title = sanitize_title_with_dashes(get_sub_field('tutorial_title'));
          // display a sub field value
          echo '<div class="tutorial col-md-9">';
          echo collapse_button(get_sub_field('tutorial_title'));
          echo  '<div class="collapse" id="' . $clean_title . '">' . get_sub_field('tutorial_description') . '</div>';
          echo '</div>';

      endwhile;
    echo '</div>';

  else :

      // no rows found

  endif;
}


function collapse_button($title){
  $clean_title = sanitize_title_with_dashes($title);
  return '<a data-toggle="collapse" class="tutorial-title" href="#' . $clean_title . '" role="button" aria-expanded="false" aria-controls="' . $clean_title . '"><div class="tutorial-icon"></div><h3>' . $title . ' </h3></a>';
}

//Vocab

function get_the_vocab_words(){
    global $post;
    $html = '';
    if( have_rows('vocabulary_bank', $post->ID) ):
        $html = '<h2 class="alt-dictionary-title magic-topics">Terms</h2><div class="row tutorial-box"><div class="alt-dictionary col-md-9">';
    while ( have_rows('vocabulary_bank') ) : the_row();
        // Your loop code
      $html .= '<button type="button" class="dictionary">' . get_sub_field('target_language_word');
      $html .= '<span class="tooltip tip-top" role="tooltip">' . get_sub_field('english_equivalent') . '</span></button>';
    endwhile;
      $html .=  '</div></div>';
    else :
        // no rows found
    endif;
    return $html;
}



//add acf stuff if you have ACF pro running (based on repeater field so you need pro) -- will remove option to edit it though which might be confusing
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
    'key' => 'group_5b562549618d1',
    'title' => 'Vocabulary Builder',
    'fields' => array (
        array (
            'key' => 'field_5b5625749e430',
            'label' => 'Vocabulary Bank',
            'name' => 'vocabulary_bank',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'block',
            'button_label' => 'Add a new word pair',
            'sub_fields' => array (
                array (
                    'key' => 'field_5b5626ba63e37',
                    'label' => 'Topic Word',
                    'name' => 'target_language_word',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '30',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                array (
                    'key' => 'field_5b5625939e432',
                    'label' => 'Definition',
                    'name' => 'english_equivalent',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array (
                        'width' => '70',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
            ),
        ),
    ),
    'location' => array (
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
            ),
        ),
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'part',
            ),
        ),
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'post',
            ),
        ),
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'front-matter',
            ),
        ),
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'back-matter',
            ),
        ),
    ),
    'menu_order' => 1,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));

endif;

