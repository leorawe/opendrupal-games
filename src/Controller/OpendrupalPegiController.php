<?php

/**
 * @file
 * Contains \Drupal\od_pegi\Controller\OpendrupalPegiController.
 */

namespace Drupal\opendrupal_pegi\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for OpenDrupal Pegi module routes.
 */
class OpendrupalPegiController extends ControllerBase {

  /**
   * Content controller callback: View games overview page.
   *
   * @return array
   *   Render array of page output.
   */
  public function gamesOverview() {
    //$entities = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'game']);
    $items = ["test","test2"];

    $build['games'] = array(
      '#theme' => 'item_list',
      '#items' => $items,
    );

    return $build;
  }

}
