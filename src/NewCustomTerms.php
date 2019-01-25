<?php
/**
 * @file
 * Contains \Drupal\sample_custom\NewCustomTerms.
 */

namespace Drupal\sample_custom;

use Drupal\taxonomy\Entity\Term;

// use Drupal\Core\Block\BlockBase;
// use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
// use Symfony\Component\DependencyInjection\ContainerInterface;
// use Drupal\Core\Entity\EntityManager;
// use Drupal\Core\Entity\Query\QueryFactory;


class NewCustomTerms {
  /**
   * Construct.
   *
   * @param string $vocab
   * @param array $terms
   *
   */
  public function __construct(
        $vocab,
        array $terms) {
    $this->vocab = $vocab;
    $this->terms = $terms;
  }

  /**
   * Getters and setters
   */
  protected $vocab;
  protected $terms = array();

  /**
   * Function to add new terms to the custom vocabulary.
   */
  public function addTerms($vocab, $terms) {
    $vocab = 'headings'; // Vocabulary machine name
    $headings = ['Life', 'News', 'Art', 'Chem']; // List of taxonomy terms
    foreach ($this->terms as $heading) {
      $term = Term::create(array(
        'parent' => array(),
        'name' => $heading,
        'vid' => $this->vocab,
      ))->save();
    }
  }

}
