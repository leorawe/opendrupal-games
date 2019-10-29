<?php

/**
 * @file
 * Contains \Drupal\od_pegi\Controller\OpendrupalPegiController.
 */

namespace Drupal\opendrupal_pegi\Controller;

use Drupal\Core\Controller\ControllerBase;
//use Drupal\Core\Entity\EntityTypeManager;

/**
 * Returns responses for OpenDrupal Pegi module routes.
 */
class OpendrupalPegiController extends ControllerBase {

  /**
   * Content controller callback: View games overview page.
   *
   **/

  // protected function getLoadGames() {
  //   $gameids = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'game']);
  //   return ($gameids);
  // }
  /** 
   * @return array
   *   Render array of page output.
   */
  public function gamesOverview() {
  //   $gamelist = [];
  //   $gameids = $this->getLoadGames();
    
  //   foreach ($gameids as $game) {
  //     $gamelist[]=$game->toLink();
  //     //$gamelist[]=$game->title->value;
  //  }
  
    //$items = ["test","test2"];

    // $build['games'] = array(
    //   '#theme' => 'item_list',
    //   '#items' => $gamelist,
    // );
    $build = [];
    $games = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'game']);
    // if ($entity = reset($entities)) {
    //   $build = \Drupal::entityTypeManager()->getViewBuilder('node')->view($entity);
    // }
    foreach ($games as $game) {
      $build['games'][] = \Drupal::entityTypeManager()->getViewBuilder('node')->view($game);
    }

    return $build;
  }

}
