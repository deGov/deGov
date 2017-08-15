<?php

namespace Drupal\nrw_menu;

use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\simplify_menu\MenuItems as SimplifiedMenuItems;


/**
 * Class MenuItems.
 *
 * @package \Drupal\nrw_menu
 */
class MenuItems extends SimplifiedMenuItems {

  /**
   * Map menu tree into an array.
   *
   * @param array $links
   *   The array of menu tree links.
   * @param string $submenuKey
   *   The key for the submenu to simplify.
   *
   * @return array
   *   The simplified menu tree array.
   */
  protected function simplifyLinks(array $links, $submenuKey = 'submenu') {
    $result = [];
    foreach ($links as $item) {
      // get menu item definitions to get the entity id of the menu item
      $menuDefinition = $item->link->getPluginDefinition();
      // load the menu link content entity to get menu_extra valuie
      $menuItem = MenuLinkContent::load($menuDefinition['metadata']['entity_id']);
      $extra = '';
      $class = '';
      

      $classes = $menuItem->getPluginDefinition();
      

      // check if the value is set
      if (!$menuItem->get('menu_extra')->isEmpty()) {
        // create the proper markup with all the filters applied
        $extra = check_markup($menuItem->get('menu_extra')->value, $menuItem->get('menu_extra')->format);
      }
      $simplifiedLink = [
        'text' => $item->link->getTitle(),
        'url' => $item->link->getUrlObject()->toString(),
        'description' => empty($item->link->getDescription()) ? $item->link->getTitle() : $item->link->getDescription(),
        'external' => $item->link->getUrlObject()->isExternal(),
        'menu_extra' => $extra, 
        'class' => $classes
      ];

      if ($item->hasChildren) {
        $simplifiedLink[$submenuKey] = $this->simplifyLinks($item->subtree);
      }
      $result[] = $simplifiedLink;
    }

    return $result;
  }

}

