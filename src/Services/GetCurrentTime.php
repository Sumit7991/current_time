<?php

namespace Drupal\current_time\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DateFormatter;

/**
 * Class GetCurrentTime for services which return current datetime.
 */
class GetCurrentTime {
  /**
   * Class UpdateTime member variable.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Class UpdateTime member variable.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * Constructor for GetCurrentTime class.
   *
   *   ConfigFactoryInterface class object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *
   *   DateFormatter class object.
   *
   * @param \Drupal\Core\Datetime\DateFormatter $date_formatter
   */
  public function __construct(ConfigFactoryInterface $config_factory, DateFormatter $date_formatter) {
    $this->configFactory = $config_factory;
    $this->dateFormatter = $date_formatter;
  }

  /**
   * Returns a formatted date.
   */
  public function getCurrentTime() {
    $selected_timezone = $this->configFactory->get('current_time.settings')->get('timezone');
    $current_time = $this->dateFormatter->format(time(), 'custom', 'jS M Y - g:i A', $selected_timezone);
    return $current_time;
  }

}
