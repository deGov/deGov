<?php

namespace Drupal\degov_content_types_shared_fields\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SidebarParagraphs
 *
 * @Block(
 *   id = "sidebar_paragraphs",
 *   admin_label = @Translation("Sidebar paragraphs from Node entity"),
 *   category = @Translation("Blocks")
 * )
 */
class SidebarParagraphs extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatcher;

  /**
   * SidebarParagraphs constructor.
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Routing\RouteMatchInterface $routeMatch
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RouteMatchInterface $routeMatch) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->routeMatcher = $routeMatch;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => 'hidden'];
  }

  /**
   * Builds and returns the renderable array for this block plugin.
   *
   * If a block should not be rendered because it has no content, then this
   * method must also ensure to return no content: it must then only return an
   * empty array, or an empty array with #cache set (with cacheability metadata
   * indicating the circumstances for it being empty).
   *
   * @return array
   *   A renderable array representing the content of the block.
   *
   * @see \Drupal\block\BlockViewBuilder
   */
  public function build() {
    $build = [];
    // try to get the node from the route
    $node = $this->routeMatcher->getParameter('node');
    if ($node && $node instanceof NodeInterface) {
      if ($node->hasField('field_sidebar_right_paragraphs') && !$node->get('field_sidebar_right_paragraphs')->isEmpty()) {
        $build['sidebar_paragraphs'] = $node->get('field_sidebar_right_paragraphs')->view('full');
        $build['sidebar_paragraphs']['#cache'] = [
          'tags' => [
            'node:'.$node->id(),
            'node_view',
          ],
          'keys' => [
            'entity_view',
            'node',
            $node->id(),
            'default',
          ]
        ];
      }
    }
    if (empty($build)) {
      return NULL;
    }
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    $cache_tags = parent::getCacheTags();
    $node = $this->routeMatcher->getParameter('node');
    if ($node && $node instanceof NodeInterface) {
      $cache_tags[] = 'node:' . $node->id();
    }
    return $cache_tags;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), ['url.path']);
  }
}