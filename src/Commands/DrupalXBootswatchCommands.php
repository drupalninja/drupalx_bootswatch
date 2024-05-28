<?php

namespace Drupal\drupalx_bootswatch\Commands;

use Drush\Commands\DrushCommands;

/**
 * A Drush commandfile.
 */
class DrupalXBootswatchCommands extends DrushCommands {

  /**
   * Apply Bootswatch theme.
   *
   * @command drupalx:apply-bootswatch
   * @aliases x-apply-bootswatch
   */
  public function applyBootswatch() {

    $boot_themes = [
      'cerulean' => 'Cerulean',
      'cosmo' => 'Cosmo',
      'cyborg' => 'Cyborg',
      'darkly' => 'Darkly',
      'flatly' => 'Flatly',
      'journal' => 'Journal',
      'litera' => 'Litera',
      'lumen' => 'Lumen',
      'lux' => 'LUX',
      'materia' => 'Materia',
      'minty' => 'Minty',
      'morph' => 'Morph',
      'pulse' => 'Pulse',
      'quartz' => 'Quartz',
      'sandstone' => 'Sandstone',
      'simplex' => 'Simplex',
      'sketchy' => 'Sketchy',
      'slate' => 'Slate',
      'solar' => 'Solar',
      'spacelab' => 'Spacelab',
      'superhero' => 'Superhero',
      'united' => 'United',
      'yeti' => 'Yeti',
      'zephyr' => 'Zephyr',
    ];

    $boot_theme = $this->io()->choice('Select the Bootswatch theme to apply', $boot_themes, 0);

    // Get list of Drupal themes.
    $all_themes = \Drupal::service('theme_handler')->listInfo();

    $themes = $theme_info = [];

    foreach ($all_themes as $theme_name => $info) {
      // Skip core themes.
      if (strpos($info->getPath(), 'core/themes') === FALSE) {
        $themes[$theme_name] = $info->getName();
        $theme_info[$theme_name] = $info;
      }
    }

    $theme = $this->io()->choice('Select DrupalX theme to apply', $themes, 0);

    // Get path to theme.
    $theme_path = $theme_info[$theme]->getPath();

    $this->io()->write("Applying theme: {$boot_themes[$boot_theme]} to DrupalX theme: {$theme}\n");

    // Define paths for Bootswatch and variables files.
    $bootswatch_path = $theme_path . '/src/stories/global/_bootswatch.scss';
    $variables_path = $theme_path . '/src/stories/global/_variables.scss';

    // Define URLs for Bootswatch and variables files.
    $bootswatch_url = 'https://bootswatch.com/5/' . $boot_theme . '/_bootswatch.scss';
    $variables_url = 'https://bootswatch.com/5/' . $boot_theme . '/_variables.scss';

    // Get content of Bootswatch and variables files.
    $bootswatch_content = "\n\n" . @file_get_contents($bootswatch_url);
    $variables_content = "\n\n" . @file_get_contents($variables_url);

    // Add error handling for file_get_contents.
    if ($bootswatch_content === FALSE || $variables_content === FALSE) {
      $this->io()->error('Failed to retrieve content from URLs.');
      return;
    }

    // Append Bootswatch content to the file.
    if (@file_put_contents($bootswatch_path, $bootswatch_content, FILE_APPEND) === FALSE) {
      $this->io()->error('Failed to write content to Bootswatch file.');
      return;
    }

    // Append variables content to the file.
    if (@file_put_contents($variables_path, $variables_content, FILE_APPEND) === FALSE) {
      $this->io()->error('Failed to write content to variables file.');
      return;
    }
  }

}
