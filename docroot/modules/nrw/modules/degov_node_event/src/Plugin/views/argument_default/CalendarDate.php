<?php

namespace Drupal\degov_node_event\Plugin\views\argument_default;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Path\AliasManagerInterface;
use Drupal\Core\Path\CurrentPathStack;
use Drupal\views\Plugin\views\argument_default\Raw;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Default argument plugin to use the raw value from the URL.
 *
 * @ingroup views_argument_default_plugins
 *
 * @ViewsArgumentDefault(
 *   id = "calendar_event_raw",
 *   title = @Translation("Raw value from URL or current date")
 * )
 */
class CalendarDate extends Raw {

  /**
   * {@inheritdoc}
   */
  protected $argFormat = 'Ym';

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * The current Request object.
   *
   * @var \Symfony\Component\HttpFoundation\Request
   */
  protected $request;

  /**
   * Constructs a new Date instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AliasManagerInterface $alias_manager, CurrentPathStack $current_path, DateFormatterInterface $date_formatter, Request $request) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $alias_manager, $current_path);

    $this->dateFormatter = $date_formatter;
    $this->request = $request;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('path.alias_manager'),
      $container->get('path.current'),
      $container->get('date.formatter'),
      $container->get('request_stack')->getCurrentRequest()
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getArgument() {
    // Don't trim the leading slash since getAliasByPath() requires it.
    $path = rtrim($this->currentPath->getPath($this->view->getRequest()), '/');
    if ($this->options['use_alias']) {
      $path = $this->aliasManager->getAliasByPath($path);
    }
    $args = explode('/', $path);
    // Drop the empty first element created by the leading slash since the path
    // component index doesn't take it into account.
    array_shift($args);
    if (isset($args[$this->options['index']]) && $this->isValidDateFromArgument($args[$this->options['index']])) {
      return $args[$this->options['index']];
    } else {

      $request_time = $this->request->server->get('REQUEST_TIME');

      return $this->dateFormatter->format($request_time, 'custom', $this->argFormat);
    }
  }

  /**
   * Check if the string is correct date from format
   *
   * @param $date_string
   *
   * @return bool
   */
  private function isValidDateFromArgument($date_string) {
    $date = \DateTime::createFromFormat($this->argFormat, $date_string);
    if ($date instanceof \DateTime) {
      return TRUE;
    }
    return FALSE;
  }


}