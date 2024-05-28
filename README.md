# DrupalX Bootswatch Module

The DrupalX Bootswatch module adds a custom Drush command to apply Bootswatch.com templates to a [DrupalX-compatible theme](https://github.com/drupalninja/drupalx_theme).

## Usage

This module is already included and enabled by default in the [DrupalX distribution](https://github.com/drupalninja/drupalx-project).

To apply a Bootswatch theme run the following command:
```bash
ddev . drush x-apply-bootswatch
```

This Drush command will prompt you for the Bootswatch & Drupal theme to apply the styles selected.

After your local _variables.css and _bootswatch files have been updated, run the following commands to recompile your SASS files and clear Drupal caches.

```bash
npm run build && ddev . drush cr
```

Following these commands you should now see your updated styles within your local Drupal instance.
