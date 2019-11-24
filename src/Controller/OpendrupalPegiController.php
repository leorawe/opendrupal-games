<?php

/**
 * @file
 * Contains \Drupal\od_pegi\Controller\OpendrupalPegiController.
 */

namespace Drupal\opendrupal_pegi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;

use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Returns responses for OpenDrupal Pegi module routes.
 */
class OpendrupalPegiController extends ControllerBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  
    /**
   * 
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }


  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Content controller callback: View games overview page.
   *
   **/

  // protected function getLoadGames() {
  //   $gameids = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'game']);
  //   return ($gameids);
  // }
/**
   * Returns a page title.
   */
  public function getTitle() {
    $config = $this->config('opendrupal_pegi.settings');
    return $config->get('page_title_setting');
  }

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
    $config = $this->config('opendrupal_pegi.settings');
    $limit = $config->get('page_link_limit');
    $limit > 0 ? $limit : 3;
    //$limit = 3;

    //$pagenum = \Drupal::request()->query->get('page');

    $build = [];
    //  $games = \Drupal::entityTypeManager()->getStorage('node')
    //  ->loadByProperties(['type' => 'game', 'status' => 1]);
    //$pagetitle = $config->get('opendrupal_pegi.page_title_setting');
    $result = \Drupal::entityQuery('node')
    ->condition('type', 'game')
    ->condition('status', 1)
    ->sort('created', 'DESC')
    ->pager($limit)
    ->execute();
    //$games = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($result);

   $games = $this->entityTypeManager()->getStorage('node')->loadMultiple($result);
   $count_games = count($games);
   if ($count_games !== 0) {
      foreach ($games as $game) {
        $build['games'][] = $this->entityTypeManager()->getViewBuilder('node')
        ->view($game, 'teaser');
        }

    $build['pager'] = array(
      '#type' => 'pager',
    );

  }
    else {
      
      $build['top'] = ['#markup' => '<p>no published game reviews found</p>'];
    }

    $build['footer'] = ['#markup' => 'My Footer: test experiment : '. $count_games];
   
    return $build;
  }

}
