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
   *   - module_name: mandatory value with the name of the module implementing the method.
   *   - entity_type: mandatory value with mostly the entity type created (E.g. node, paragraph, media, swiftmailer..)
   *   - entity_bundles: optional array of entity bundles created, could be empty.
   *   - entity_view_modes: optional array of entity view modes that need templates, could be empty.
   */
  public static function addThemeSuggestions(&$variables, $hook, &$info, $options) {
    /* @var $entity_type string */
    /* @var $entity_bundles array */
    /* @var $module_name string*/
    /* @var $entity_view_modes array */
    extract($options);
    $add_suggestion = FALSE;

    if ($hook == $entity_type) {
      // Add module overwritten template suggestions for only the entity bundles that are defined.
      if ($entity_bundles) {
        if ($hook === 'media') {
          $entity = $variables['elements']['#media'];
        } else {
          $entity = $variables[$entity_type];
        }
        $entity_bundle = $entity->bundle();
        // Overwrite the core/contrib template with our module template in case no custom theme has overwritten the template.
        if (in_array($entity_bundle, $entity_bundles)) {
          $add_suggestion = TRUE;
        }
      } else {
        // In case no entity bundles are defined, we still include the default template override.
        $add_suggestion = TRUE;
      }
    }

    if ($add_suggestion) {
      $template_path = substr($info['theme path'], 0, 14);
      // Only override templates that are defined by contrib modules.
      if ($template_path == 'themes/contrib' || $template_path != 'themes/custom/') {
        $info['theme path'] = $module_path = drupal_get_path('module', $module_name);
        $info['path'] = $module_path . '/templates';
        // Add a template for every defined view mode else add it for the default view mode.
        if (isset($variables['view_mode']) && in_array($variables['view_mode'], $entity_view_modes)) {
          $info['template'] = $entity_type . '--' . $entity_bundle . '--' . $variables['view_mode'];
        } else {
          if (isset($entity_bundle)) {
            $info['template'] = $entity_type . '--' . $entity_bundle . '--default';
            // Include defined entity bundle libraries.
            $library = \Drupal::service('library.discovery')->getLibraryByName($module_name, $entity_bundle);
            if ($library) {
              $variables['#attached']['library'][] = $module_name . '/' . $entity_bundle;
            }
          } else {
            $info['template'] = $entity_type . '--default';
          }
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
