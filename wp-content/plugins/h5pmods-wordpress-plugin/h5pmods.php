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
 * Plugin Name:       H5P Mods
 * Plugin URI:        http://h5p.org/
 * Description:       Allows you to alter how the H5P plugin works.
 * Version:           0.0.1
 * Author:            Joubel
 * Author URI:        http://joubel.com
 * Text Domain:       h5pmods
 * License:           MIT
 * License URI:       http://opensource.org/licenses/MIT
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/h5p/h5pmods-wordpress-plugin
 */

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
  if ($name == 'H5P.InteractiveVideo') {
    // Find correct field
    $interactiveVideofields = $semantics[0];
    $assetsFields = $interactiveVideofields->fields[1]->fields;
    $interationsFields = $assetsFields[0]->field->fields;

    foreach($interationsFields as $interationField) {
      if($interationField->name == 'label') {
        array_push($interationField->options,"H5P.Apuntes 1.0");
      }
    }

  }
}


add_action('h5p_alter_library_semantics', 'h5pmods_alter_semantics', 10, 4);
