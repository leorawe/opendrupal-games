<?php

namespace Drupal\opendrupal_pegi\Plugin\Block;

//use Drupal\Core\Block\Annotation\Block;
use Drupal\Core\Block\BlockBase;
//use Drupal\Core\Annotation\Translation;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\node\Entity\Node;
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
      //Using entity query & loadMultiple
      $gameids = \Drupal::entityTypeManager()->getStorage('node')->getQuery()
      ->condition('type', 'game')
      ->sort('nid', 'DESC')
      ->range(0, 5)
      ->execute();
      $gamereviews = Node::loadMultiple($gameids);
     //$entities = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'page']);
     //current(\Drupal::entityTypeManager()->getStorage('node') ->loadByProperties( [ 'title' => $title, 'type' => 'authority' ] ) ); 
     
     //Using the storage object
     $games = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'game']);
    return ($gamereviews);
  }


  /**
   * {@inheritdoc}
   */
  public function build() {
    $gamereviews = $this->getGameNodes();
    $gamelist = [];
    foreach ($gamereviews as $game) {
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
