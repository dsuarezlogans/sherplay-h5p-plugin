<?php
/**
 * H5P Mods Plugin.
 *
 * Alters the way the H5P plugin works.
 *
 * @package   H5P
 * @author    Danny Suarez <dsuarezlogans@gmail.com>
 * @license   MIT
 * @link      https://github.com/dsuarezlogans
 * @copyright 2019 MIT
 *
 * @wordpress-plugin
 * Plugin Name:       H5P Mods Classnote
 * Plugin URI:        http://h5p.org/
 * Description:       Allows you to alter how the H5P plugin works. Adding a unblock classnote functionality along H5P.Text library.
 * Version:           1.0.0
 * Author:            Danny
 * Author URI:        http://joubel.com
 * Text Domain:       h5pmods
 * License:           MIT
 * License URI:       http://opensource.org/licenses/MIT
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/h5p/h5pmods-wordpress-plugin
 */

require_once dirname( __FILE__ ) .'/includes/classnote-builder.php';
require_once dirname( __FILE__ ) .'/includes/classnote-widget.php';

// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

/**
 * Allows you to alter the H5P library semantics, i.e. changing how the
 * editor looks and how content parameters are filtered.
 *
 * In this example we change the preview label for the collage tool where
 * version is < 1.0.0.
 *
 * @param object &$semantics The same as in semantics.json
 * @param string $name The machine readable name of the library.
 * @param int $majorVersion First part of the version number.
 * @param int $minorVersion Second part of the version number.
 */
function h5pmods_alter_semantics(&$semantics, $name, $majorVersion, $minorVersion) {
  if ($name == 'H5P.Text') {
    $fields = $semantics[1];
    $ajaxurl = $semantics[2];

    $options = getClassnotes();

    $fields->options = $options;
    $ajaxurl->default = admin_url( 'admin-ajax.php' );
  }
}

add_action('h5p_alter_library_semantics', 'h5pmods_alter_semantics', 10, 4);

/**
 * Allows you to alter the parameters of H5P content after it has been filtered
 * through semantics. This is useful for adapting the content to the current
 * context.
 *
 * In this example we add a paragraph to the question text on all the multiple
 * choice tasks.
 *
 * @param object &$paramters The content input used to "start" the library.
 * @param string $name The machine readable name of the library.
 * @param int $majorVersion First part of the version number.
 * @param int $minorVersion Second part of the version number.
 */
function h5pmods_alter_parameters(&$parameters, $name, $majorVersion, $minorVersion) {
  if ($name == 'H5P.Text') {
    $parameters->question = '<p>Generated at ' . time() . '.</p>';
  }
}
add_action('h5p_alter_filtered_parameters', 'h5pmods_alter_parameters', 10, 4);

/**
 * Ajax hook that assing classnote Id to a user metadata.
 *
 * @return object the response object to the client.
 */
function add_classnote() {

  $classnoteId = $_POST['classnoteId'];
  $user_id = get_current_user_id();
  $return = array();
  $return['success'] = false;
  $tranlationID = NULL;

  if(function_exists('icl_object_id')) {
    $tranlationID = icl_object_id($classnoteId, 'post', false, 'es');
  }

  if($user_id && !has_user_classnote($classnoteId, $user_id)) {
    add_user_meta( $user_id, 'allow_classnote', $classnoteId, false );
    $return['success'] = true;
  }

  if($tranlationID && $user_id && !has_user_classnote($tranlationID, $user_id)) {
    add_user_meta( $user_id, 'allow_classnote', $tranlationID, false );
    $return['success'] = true;
  }

	$return['classnoteId'] = $classnoteId;
  $return['translationID'] = $tranlationID;
  $return['userId'] = $user_id;
  
	echo json_encode($return);
  wp_die();

}
add_action('wp_ajax_add_classnote', 'add_classnote');
add_action('wp_ajax_nopriv_add_classnote', 'add_classnote');


function render_classnote() {
  global $post;
  $user_id = get_current_user_id();
  
  if ($post->post_type == 'classnote') {
    
    if(!has_user_classnote($post->ID, $user_id) && !current_user_can('administrator')) {
      wp_redirect( home_url() );
    }
  }

}
add_filter( 'template_redirect', 'render_classnote', -1);

/**
 * Search for classnote to be available for user.
 * 
 * @return boolean is true is user has access, otherwise is false.
 */
function has_user_classnote($postID, $user_id) {
  
  $key = 'allow_classnote';
  $user_classnotes = get_user_meta($user_id, $key);

  foreach($user_classnotes as $classnote) {
    if($classnote == $postID) {
      return true;
    }
  }

  return false;
}
define('has_user_classnote', 'has_user_classnote');

/**
 * returns a list of all classnotes available.
 *
 * @return array[object] an array of classnote object.
 */
function getClassnotes() {

  $classnotes = new WP_Query( array( 'post_type' => 'classnote' ) );
  $options = [];

  if( $classnotes->have_posts() ) {

    while( $classnotes->have_posts() ) {
      $classnotes->the_post();
      
      $value = get_the_ID();
      $label = get_the_title();

      array_push( $options, (object) array(
        'value' => $value,
        'label' => $label
      ));

    }

  }
  return $options;
}
