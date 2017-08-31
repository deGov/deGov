# Howto create configuration feature module

Maybe this Text is a bit outdated. Refer to the exemplary implementation of instead (they are properly documented)

* degov_normal_page "Inhaltsseite" for Nodes
* degov_paragraph_faq "FAQ" for Paragraphs

## How to convert feature to a module
If you have an entity type in the feature and you don't want to track the changes anymore, it is possible to convert the feature to a module. For this one only needs to delete 1 file module_name.features.yml as features module do not even create a dependency on the features modules.

To have your configurations be uninstalled with the module to every configuration file one needs to add the dependency to the module itself like this (example for degov_faq_element):

```
dependencies:
 config:
 - field.field.paragraph.faq_element.field_faq_element_answer
    - field.field.paragraph.faq_element.field_faq_element_question
    - paragraphs.paragraphs_type.faq_element
 module:
 - workbench_moderation
 enforced:
   module:
     - degov_faq_element
```

In this case when uninstalling the module there would be a confirmation page that will ask your confirmation and list the configurations that will be updated/deleted.

By default features module doesn't add this enforced dependency and the module could be easily deleted without any configuration changes, so the developer can decide on what configurations should stay and what should be uninstalled. With field and entity configurations Drupal also deletes the content (data tables).

By default (as features module create feature) all configuration files are located at config/install folder. This way Drupal knows that the configuration must be installed during module install. The configuration files could also be added to config/optional folder. This way Drupal allows to avoid conflicts if the configuration with the same machine name already exists it will not be installed.

## How to use the template for the entity in custom module
There is a hook to alter the theme information. It should be implemented in module_name.module file, current example is for degov_faq_element:

```
/**
 * Implements hook_preprocess().
 */
function degov_paragraph_faq_preprocess(&$variables, $hook, &$info) {
  // Add template suggestions and libraries implemented in this module.
  Common::addThemeSuggestions($variables, $hook, $info, [
    'module_name' => 'degov_paragraph_faq',
    'entity_type' => 'paragraph',
    'entity_bundles' => ['faq', 'faq_list'],
    'entity_view_modes' => [],
  ]);
}
```

To add js and css files to the page the libraries should be defined in module_name.libraries.yml file. Guideline could be found here [https://www.drupal.org/docs/8/creating-custom-modules/adding-stylesheets-css-and-javascript-js-to-a-drupal-8-module](https://www.drupal.org/docs/8/creating-custom-modules/adding-stylesheets-css-and-javascript-js-to-a-drupal-8-module). As example see the implementation from degov_faq_element module:

```
faq_element:
 version: 1.0
  js:
 js/faq_element.js: {}
  css:
 theme:
 css/faq_element.css : {}
  dependencies:
 - core/jquery
    - core/drupal
    - core/drupalSettings
    - core/jquery.once
```

## How to add dependencies
If your module has individual dependencies add a composer.json to your feature/module with your dependencies. 

These will be pulled into the project by the wikimedia merge plugin as well on composer install/update. E.g.

```
{
 "name": "degov_html_mail",
 "type": "drupal-module",
 "description": "Adds default configuration for all HTML mails.",
 "license": "GPL-2.0+",
 "homepage": "https://www.nrwgov.org",
 "require": {
   "drupal/swiftmailer": "^1.0-beta1",
   "drupal/mailsystem": "^4.1"
 }
}
```

Now run at project top level "composer update drupal/package". This will update the composer.lock and also installs all your dependencies.
