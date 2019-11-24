<?php

namespace Drupal\opendrupal_pegi\Plugin\Block;

//use Drupal\Core\Block\Annotation\Block;

//use Drupal\config_override_integration_test\CacheabilityMetadataConfigOverride;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\node\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;
//use Drupal\Core\Cache\CacheableDependencyInterface;

/**
 * Provides a 'Opendrupal Pegi' block.
 *
 * @Block(
 *   id = "opendrupal_pegi_block",
 *   admin_label = @Translation("Opendrupal Pegi"),
 * )
 */

class GamesList extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * 
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(array $configuration, $plugin_id,$plugin_definition,EntityTypeManagerInterface $entity_type_manager, RendererInterface $renderer) {
    parent::__construct($configuration, $plugin_id,$plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id,$plugin_definition) {
    return new static($configuration, $plugin_id,$plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('renderer')
    );
  }

 /**
   * Gets game review nodes .
   *
   * @return array
   *   
   */
  protected function getGameNodes() {
     $config = \Drupal::config('opendrupal_pegi.settings');
    //  $maxitems= intval($config->get('opendrupal_pegi.block_link_limit'));
    //  $max = is_int($maxitems)? $maxitems : 5;
    $max = $config->get('block_link_limit');
    //$max = 5;
      $gameids = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'game')
      ->condition('status', 1)
      ->sort('nid', 'DESC')
      ->range(0, $max)
      ->execute();
      //$gamereviews = Node::loadMultiple($gameids);
     //$entities = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'page']);
     //current(\Drupal::entityTypeManager()->getStorage('node') ->loadByProperties( [ 'title' => $title, 'type' => 'authority' ] ) ); 
     
     //Using the storage object
     //$games = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'game']);
    //return ($gamereviews);
    return $this->entityTypeManager->getStorage('node')->loadMultiple($gameids);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    //$config = \Drupal::config('opendrupal_pegi.settings');
    //$foo = $config->get('opendrupal_pegi.block_link_limit');
    $gamereviews = $this->getGameNodes();
    $gamelist = [];
    foreach ($gamereviews as $game) {
        // $gamelist[]=$game->title->value;
        //$gamelist[]= $foo;
        $gamelist[]=$game->toLink();
     }
    
     //addCacheableDependency
    $cachableMetadata = new CacheableMetadata();
    $cachableMetadata->setCacheContexts(['user.permissions']);
    $cachableMetadata->setCacheTags(['node_list']);
    $cachableMetadata->setCacheTags(['config:opendrupal_pegi.settings']);
    //$items = ["this is one","another item", "oh, my","item this is"];
    $build = [
      '#theme' => 'item_list',
      '#items' => $gamelist,
    ];
    //$build['#cache']['tags']= $config->getCacheTags();
    //$build['#cache']['contexts'][] = 'user.permissions';

    $cachableMetadata->applyTo($build);
    return $build;
  }
}
