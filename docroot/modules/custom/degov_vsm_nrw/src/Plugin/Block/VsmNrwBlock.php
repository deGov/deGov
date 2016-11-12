<?php

namespace Drupal\degov_vsm_nrw\Plugin\Block;

use Drupal\Core\Url;
use Drupal\Core\Link;
use Drupal\Core\Block\BlockBase;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides a 'article' block.
 *
 * @Block(
 *   id = "degov_vsm_nrw_block",
 *   admin_label = @Translation("VSM NRW Block"),
 *   category = "deGov",
 * )
 */
class VsmNrwBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */

  public function build() {

    $q_area = 'land';
    $q_search = NULL;

    // Module Path
    $modulePath = sprintf('modules/custom/degov_vsm_nrw/assets', \Drupal::root());
    $moduleRealPath = \Drupal::service('file_system')->realpath($modulePath);

    // Load Communes
    $areas = NULL;
    $areas = Yaml::parse(file_get_contents($moduleRealPath . '/areas.yml'));

    // retrieve GET variables
    $request = NULL;
    $request = Request::createFromGlobals();

    // Query Parameter
    $q = NULL;
    $q = $request->query->get('keys');

    // Clean Query Parameter
    $q_arr = NULL;
    $q_arr = explode(' ', mb_ereg_replace('[^\w\d]', ' ', mb_strtolower($q, 'UTF-8')));

    // Check each Areas
    foreach ($areas as &$area) {

      // Result of Compare
      $area['result'] = 0;

      // Clean Area Name
      $area_clean_arr = NULL;
      $area_clean_arr = explode(' ', mb_ereg_replace('[^\w\d]', ' ', mb_strtolower($area['name'], 'UTF-8')));

      // Check Words in Area Name with Words in Query Parameter
      foreach ($area_clean_arr as $area_clean_val) {
        foreach ($q_arr as $q_val) {

          $perc = NULL;
          similar_text($area_clean_val, $q_val, $perc);
          if ($perc >= 80) {
            $q_search[] = $q_val;
            $area['result'] += ($perc / 100);
          }

        }
      }

      $area['result'] /= count($area_clean_arr);

    }

    // Hole eine Liste von Spalten
    $tmp_result = NULL;
    foreach ($areas as $key => $row) {
      $tmp_result[$key] = $row['result'];
    }

    // sort the best match to top
    array_multisort($tmp_result, SORT_DESC, $areas);

    if ($areas[0]['result'] > 0) {
      $q_area = $areas[0]['key'];
    }

    if ($q_search != NULL) {
      $q_search = array_diff($q_arr, array_unique($q_search));
    }
    else {
      $q_search = $q_arr;
    }

    // VSM NRW Seach
    $result = NULL;
    $result = degov_vsm_nrw_search(join(' ', $q_search), $q_area);
    if (($result) && (!empty($result['resources']))) {

      // Generate HTML List
      $list = NULL;
      $list .= '<h2>' . t('Suchergebnisse der Verwaltungssuchmaschine NRW') . '</h2>';
      $list .= '<ol>';
      foreach ($result['resources'] as $entry) {
        $renderableLink = Link::fromTextAndUrl(
        strip_tags($entry['title']),
        Url::fromUri($entry['url'],
                      array(
                        'attributes' => array('target' => array('_blank')),
                        'external'   => TRUE,
                      )
                    )
        )->toRenderable();

        $renderableLink2 = Link::fromTextAndUrl(
        strip_tags($entry['url']),
        Url::fromUri($entry['url'],
                      array(
                       'attributes' => array('target' => array('_blank')),
                       'external'   => TRUE,
                      )
                    )
        )->toRenderable();
        $list .= '<li>';
        $list .= '<h3>' . render($renderableLink) . '</h3>';
        $list .= '<p>' . $entry['description'] . '</p>';
        $list .= '<p><i>' . render($renderableLink2) . '</i></p>';
        $list .= '</li>';
      }
      $list .= '</ol>';

      // Output Results as HTML
      return array(
        '#type'   => 'markup',
        '#markup' => $list,
        '#cache'  => [
          'contexts' => [
            'url.query_args:keys',
          ],
          'max-age'  => 86400,
        ],
      );

    }

    // No Results
    return array(
      '#type'   => 'markup',
      '#markup' => '<h3>' . t('Die Verwaltungssuchmaschine NRW lieferte keine Ergebnisse.') . '</h3>',
      '#cache'  => [
        'contexts' => [
          'url.query_args:keys',
        ],
        'max-age'  => 86400,
      ],
    );

  }

}
