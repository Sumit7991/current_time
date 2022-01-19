<?php

namespace Drupal\current_time\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\current_time\Services\GetCurrentTime;

/**
 * Provides a 'Current Location and Time' Block.
 *
 * @Block(
 *   id = "current_time_block",
 *   admin_label = @Translation("Current Location and Time"),
 * )
 */
class CurrentTimeBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * Class UpdateTime member variable.
   *
   * @var \Drupal\current_time\Services\GetCurrentTime
   */
  protected $currentDateTime;
  /**
   * Class UpdateTime member variable.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * CurrentTimeBlock class constructor.
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   * @param \Drupal\current_time\Services\GetCurrentTime $current_date_time
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, GetCurrentTime $current_date_time) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory->get('current_time.settings');
    $this->currentDateTime = $current_date_time;
  }

  /**
   * Class create method.
   *
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
      $container->get('config.factory'),
      $container->get('current_time.get_current_time')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'current_location_and_time',
      '#attached' => [
        'library' => [
          'current_time/current-time-script',
        ],
      ],
      '#country' => $this->configFactory->get('country'),
      '#city' => $this->configFactory->get('city'),
      '#time' => $this->currentDateTime->getCurrentTime(),
      '#cache' => [
          // Url context seems not needed,
          // values(except time) will be same until config update,
          // and we are also updating time on page load using JS.
        'contexts' => [
          'url',
        ],
        'tags' => [
          'config:current_time.settings',
        ],
      ],
    ];
  }

}
