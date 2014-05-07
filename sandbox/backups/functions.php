<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 22.01.14
 * Time: 18:42
 */
// Get Bones and Core Up & Running!
require_once('library/bones.php');
require_once('library/admin.php');
//require_once('library/custom-post-type-ui.php');
require_once('library/queries.php');
require_once('library/menus.php');
require_once('library/extras.php');
require_once('library/extras.php');
require_once('library/helper.php');


// Set content width
if ( ! isset( $content_width ) ) $content_width = 580;

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size('slider', 940, 340, true); // slider images with crop
add_image_size('programmbild', 940, 940, false); // ohne crop
add_image_size('prod-thumbnail', 293, 234, true); // mit crop



// Add Thumbnail Support

//add_theme_support('prod-thumbnail', array ('post','produktion','presse','custom_post'));
//set_post_thumbnail_size( 293, 234, true );

/*
//link all post-thumbnails to permalink
add_filter( 'post_thumbnail_html', 'my_post_image_html', 10, 3 );

function my_post_image_html( $html, $post_id, $post_image_id ) {
    $html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . $html . '</a>';
    return $html;

}*/



/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

// ADD DEFAULT TWITTER BOOTSTRAP ACTIVE CLASS

add_filter('nav_menu_css_class', 'add_my_active_class', 10, 2);
add_filter('page_css_class', 'add_my_active_class', 10, 5);

function add_my_active_class($classes, $item)
{
  if (in_array('current-menu-item', $classes) ||
    in_array('current-menu-ancestor', $classes) ||
    in_array('current-menu-parent', $classes) ||
    in_array('current-page-parent', $classes) ||
    in_array('current-page-item', $classes) ||
    in_array('current_page_item', $classes) ||
    in_array('current-page-ancestor', $classes)
  ) {

    $classes[] = "active";
  }

  return $classes;

}

/*// CUSTOM HEADER IMAGE THEME SUPPORT
$args = array(
  //'flex-width'    => true,
  'width' => 940,
  //'flex-height'   => true,
  'height' => 360,
  'default-image' => get_template_directory_uri() . '/images/header.jpg',
);
add_theme_support('custom-header', $args);*/


//THEME STYLES
if (!function_exists("theme_styles")) {
  function theme_styles(){
    wp_register_style('bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css?', array(), null);
    wp_register_style('font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css?', array(), null);
    wp_register_style('lightbox', get_stylesheet_directory_uri() . '/css/jquery.lightbox.min.css?', array(), null);
    wp_register_style('style', get_stylesheet_directory_uri() . '/style.css?', array(), null);

    wp_enqueue_style('bootstrap');
    wp_enqueue_style('lightbox');
    wp_enqueue_style('font-awesome');
    wp_enqueue_style('style');
  }
}

add_action('wp_enqueue_scripts', 'theme_styles');

// enqueue javascript
if (!function_exists("theme_scripts")) {
  function theme_scripts()
  {
      //echo(get_stylesheet_directory_uri());

      wp_register_script('modernizer',get_stylesheet_directory_uri() . '/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js', array('jquery'), null, true);
      wp_register_script('bootstrap-js',get_stylesheet_directory_uri() . '/js/vendor/bootstrap.min.js', array('jquery'), null, true);
      wp_register_script('jquery-lightbox',get_stylesheet_directory_uri() . '/js/jquery.lightbox.min.js', array('jquery'), null, true);
      wp_register_script('main',get_stylesheet_directory_uri() . '/js/main.js', array('jquery', 'jquery-lightbox'), null, true);
//      wp_register_script('fittext',get_stylesheet_directory_uri() . '/js/jquery.fittext.js', array('jquery'), null, true);

      wp_enqueue_script('modernizer');
      wp_enqueue_script('bootstrap-js');
      wp_enqueue_script('jquery-lightbox');
      wp_enqueue_script('main');

  }
}
add_action('wp_enqueue_scripts', 'theme_scripts');


function mr_footer_menu()
{
  // display the wp3 menu if available
  wp_nav_menu(
    array(
      'menu' => 'footer_links', /* menu name */
      'menu_class' => 'nav nav-stacked nav-pills', /*menu class*/
      'menu_id' => 'footer-main-menu',
      'theme_location' => 'footer_links', /* where in the theme it's assigned */
      'container_class' => 'footer-links clearfix', /* container class */
      'fallback_cb' => 'wp_bootstrap_footer_links_fallback' /* menu fallback */
    )
  );
}


// Disable jump in 'read more' link
function remove_more_jump_link( $link ) {
  $offset = strpos($link, '#more-');
  if ( $offset ) {
    $end = strpos( $link, '"',$offset );
  }
  if ( $end ) {
    $link = substr_replace( $link, '', $offset, $end-$offset );
  }
  return $link;
}
add_filter( 'the_content_more_link', 'remove_more_jump_link' );

// Remove height/width attributes on images so they can be responsive
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
  $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
  return $html;
}





/*
 EDITOR CUSTOM QUICKTAGS
*/


// add more buttons to the html editor
function appthemes_add_quicktags() {
    if (wp_script_is('quicktags')){
        ?>
        <script type="text/javascript">
            QTags.addButton( 'PDF_SYMBOL', 'pdf-symbol', '<span class="icon-file-pdf"></span>', '', 'q', 'Pdf Symbol', 111 );
            /*QTags.addButton( 'eg_paragraph', 'p', '<p>', '</p>', 'p', 'Paragraph tag', 1 );
            QTags.addButton( 'eg_hr', 'hr', '<hr />', '', 'h', 'Horizontal rule line', 201 );
            QTags.addButton( 'eg_pre', 'pre', '<pre lang="php">', '</pre>', 'q', 'Preformatted text tag', 111 );*/
        </script>
    <?php
    }
}
add_action( 'admin_print_footer_scripts', 'appthemes_add_quicktags' );




