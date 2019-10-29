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
    $limit = 5;
    $pagenum = \Drupal::request()->query->get('page');
    $build = [];
    $games = \Drupal::entityTypeManager()->getStorage('node')
    ->loadByProperties(['type' => 'game', 'status' => 1]);
    if($games){
      $count = 0;
      foreach ($games as $game) {
        if($count < $limit){
        $build['games'][] = \Drupal::entityTypeManager()->getViewBuilder('node')
        ->view($game, 'teaser');
        $count++;
        }
      }
    pager_default_initialize(count($games), 5);
    $build['pager'] = array(
      '#type' => 'pager',
    );
       }
    else {
      $build['top'] = ['#markup' => '<p>no published game reviews found</p>'];
    }

    $build['footer'] = ['#markup' => 'My Footer: xyz experiment on page: '.$pagenum];
   
    return $build;
  }

}
