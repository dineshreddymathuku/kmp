<?php

namespace Drupal\profile\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockManager;
use Drupal\Core\Block\BlockPluginInterface;

/**
 * Provides a block with a Creating Post.
 *
 * @Block(
 *   id = "post_block",
 *   admin_label = @Translation("Post block"),
 * )
 */
class PostBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */

  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\profile\Form\PostForm');
    return $form;
  }

}
