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

    //Using entity query & loadMultiple
     $gameids = \Drupal::entityTypeManager()->getStorage('node')->getQuery()
     ->condition('type', 'game')
     ->execute();
     $gamereviews = Node::loadMultiple($gameids);
    //$entities = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'page']);
    //current(\Drupal::entityTypeManager()->getStorage('node') ->loadByProperties( [ 'title' => $title, 'type' => 'authority' ] ) ); 
    
    //Using the storage object
    $games = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'game']);
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
