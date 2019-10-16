<?php

namespace Drupal\opendrupal_pegi\Plugin\Block;

//use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
//use Drupal\Core\Annotation\Translation;
use Drupal\Core\Entity\EntityTypeManager;
//use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'Opendrupal Pegi' block.
 *
 * @Block(
 *   id = "opendrupal_pegi_block",
 *   admin_label = @Translation("Opendrupal Pegi"),
 * )
 */

class NewGames extends BlockBase {

 /**
   * Gets game review nodes .
   *
   * @return array
   *   
   */
  protected function getGameNodes() {
    //$this->entityTypeManager = $container->get('entity_type.manager');
    //$entities = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'article']);
    $nodes = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'game')
      ->execute();
    return ($nodes);
  }


  /**
   * {@inheritdoc}
   */
  public function build() {
    // $gameids = \Drupal::entityTypeManager()->getStorage('node')->getQuery()
    // ->condition('type', 'game')
    // ->execute();
    //$games = $node_storage->loadMultiple($gameids);
    // foreach ($gameids as $game) {
    //   echo $game->title->value;
    // }
    //$entities = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'page']);
    //current(\Drupal::entityTypeManager()->getStorage('node') ->loadByProperties( [ 'title' => $title, 'type' => 'authority' ] ) ); 
    $games = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'game']);
    $gamelist = [];
    foreach ($games as $game) {
         $gamelist[]=$game->title->value;
     }
    
    $items = ["this is one","another item", "oh, my","item this is"];
    $build = [
      '#theme' => 'item_list',
      '#items' => $gamelist,
    ];
    return $build;
  }
}
