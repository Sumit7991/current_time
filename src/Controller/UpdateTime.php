<?php

namespace Drupal\current_time\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\current_time\Services\GetCurrentTime;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UpdateTime responsible for returning updated datetime string as json.
 */
class UpdateTime extends ControllerBase {
  /**
   * Class UpdateTime member variable.
   *
   * @var \Drupal\current_time\Services\GetCurrentTime
   */
  protected $currentDateTime;

  /**
   * GetCurrentTime class constructor.
   *
   *   GetCurrentTime class object.
   *
   * @param \Drupal\current_time\Services\GetCurrentTime $current_date_time
   */
  public function __construct(GetCurrentTime $current_date_time) {
    $this->currentDateTime = $current_date_time;
  }

  /**
   * Class create method.
   *
   *   ContainerInterface class object.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *
   * @return static
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_time.get_current_time')
    );
  }

  /**
   * Returns updated date.
   */
  public function getUpdatedTime() {
    $current_time = $this->currentDateTime->getCurrentTime();
    return new JsonResponse($current_time);
  }

}
