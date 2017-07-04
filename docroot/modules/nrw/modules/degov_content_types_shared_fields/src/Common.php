<?php

namespace Drupal\degov_content_types_shared_fields;
use phpDocumentor\Reflection\Types\String_;

/**
 * Class Common.
 *
 * Contains all common function implementations.
 *
 * @package Drupal\degov_content_types_shared_fields
 */
class Common {

  /**
   * Adds template suggestions and library implementations.
   *
   * Add this to the HOOK_preprocess() of your module. The first 3 arguments
   * are equal to the ones from the parent HOOK_preprocess().
   *
   * @param array &$variables
   *   Original $variables from the hook_preprocess() function.
   * @param string $hook
   *   Original $hook from the hook_preprocess() function.
   * @param array &$info
   *   Original $info from the hook_preprocess() function.
   * @param array $options
   *   A key named array of options, including:
   *   - module_name: name of the module.
   *   - entity_type: the entity type created by the module (node, paragraph,..)
   *   - entity_bundles: array of entity bundles created.
   *   - entity_view_modes: array of entity view modes that need templates.
   *
   * TODO: media entities do not work here, something like below needs to be added
   * if ($hook === 'media') {
   *   $variables['media'] = $variables['elements']['#media'];
   * }
   *
   */
  public static function addThemeSuggestions(&$variables, $hook, &$info, $options) {
    /* @var $entity_type string */
    /* @var $entity_bundles array */
    /* @var $module_name string*/
    /* @var $entity_view_modes array */
    extract($options);
    // Add module overwritten template suggestions for each entity bundle.
    if ($hook == $entity_type) {
      $entity_bundle = $variables[$entity_type]->bundle();
      // Overwrite the core/contrib template with our module template in case no custom theme has overwritten the template.
      if (in_array($entity_bundle, $entity_bundles)) {
        $template_path = substr($info['theme path'], 0, 14);
        if ($template_path == 'themes/contrib' || $template_path != 'themes/custom/') {
          $info['theme path'] = $module_path = drupal_get_path('module', $module_name);
          $info['path'] = $module_path . '/templates';
          // Add a template for every defined view mode else add it for the default view mode.
          if (in_array($variables['view_mode'], $entity_view_modes)) {
            $info['template'] = $entity_type . '--' . $entity_bundle . '--' . $variables['view_mode'];
          } else {
            $info['template'] = $entity_type . '--' . $entity_bundle . '--default' ;
          }
        }
        // Include defined entity bundle libraries.
        $library = \Drupal::service('library.discovery')->getLibraryByName($module_name, $entity_bundle);
        if ($library) {
          $variables['#attached']['library'][] = $module_name . '/' . $entity_bundle;
        }
      }
    }
  }

  /**
   * Remove content of a given entity type and its bundles.
   *
   * @param array $options
   *   A key named array of options, including:
   *     - entity_type: entity type of the bundles.
   *     - entity_bundles: an array of entity bundle names.
   */
  public static function removeContent($options) {
    /* @var $entity_type string */
    /* @var $entity_bundles array */
    extract($options);
    // Retrieve the bundle name of the entity type.
    $entity_bundle_name = 'type';
    if ($entity_type == 'media') {
      $entity_bundle_name = 'bundle';
    }
    if ($entity_type == 'paragraph') {
      // TODO: There is still a problem with orphaned paragraph references.
      //       Although the paragraph has been removed, the references (on the node) still exist.
      //
      // select * from paragraphs_item_field_data;
      // select * from paragraphs_item;
      // e.g. field - select * from node__field_normal_page_header_pars;
      // 1. Retrieve an array with `parent_type__parent_field_name` of all entity_ids above.
      // 2. Remove all rows with `parent_field_name`_target_id with above entity_ids.
      //    from tables with the name `parent_type__parent_field_name`
      // 3. Do the same for revision tables.
    }
    foreach ($entity_bundles as $entity_bundle) {
      \Drupal::logger($entity_bundle)->notice(t('Removing all content of type @bundle', array('@bundle' => $entity_bundle)));
      $entity_ids = \Drupal::entityQuery($entity_type)
        ->condition($entity_bundle_name, $entity_bundle)
        ->execute();
      $controller = \Drupal::entityTypeManager()->getStorage($entity_type);
      $entities = $controller->loadMultiple($entity_ids);
      $controller->delete($entities);
    }
  }

}
