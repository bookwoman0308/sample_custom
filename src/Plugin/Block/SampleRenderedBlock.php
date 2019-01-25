<?php
/**
 * @file
 * Contains \Drupal\sample_custom\Plugin\Block\SampleRenderedBlock.
 */

namespace Drupal\sample_custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityManager;
use Drupal\Core\Entity\Query\QueryFactory;

/**
 * Provides the custom block
 *
 * @Block(
 *   id = "sample_rendered",
 *   admin_label = @Translation("Test Transmission"),
 * )
 */

//Reused a lot of code from repo found here during research: https://github.com/Lullabot/challenge4/blob/master/src/Plugin/Block/DemoBlock.php

class SampleRenderedBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * Drupal\Core\Entity\EntityManager definition.
   *
   * @var Drupal\Core\Entity\EntityManager
   */
  protected $entity_manager;

  /**
   * Drupal\Core\Entity\Query\QueryFactory definition.
   *
   * @var Drupal\Core\Entity\Query\QueryFactory
   */
  protected $entity_query;

  /**
   * Construct.
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param string $plugin_definition
   *
   */
  public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        EntityManager $entity_manager,
        QueryFactory $entity_query) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entity_manager = $entity_manager;
    $this->entity_query = $entity_query;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity.manager'),
      $container->get('entity.query')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $items = array();
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node) {
      //Retrieve items of type sample_custom_article.
      $query = $this->entity_query->get('node')
        ->condition('type', 'sample_custom_article');
      $nids = $query->execute();
      //Load results into an array of node objects.
      $nodes = $this->entity_manager->getStorage('node')->loadMultiple($nids);
      //Create a render array for each title field.
      foreach ($nodes as $node) {  
        $title = $node->title->view('full');
        $items[] = $node->toLink($title);
      }
    }

    //Return a render array for a list.
    return [
        '#theme' => 'item_list',
        '#items' => $items,
        '#region' => 'sidebar_second',
        '#cache' => [
          'contexts' => [
            'route',
          ],
        ],
    ];
  }

}