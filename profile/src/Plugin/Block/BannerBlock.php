<?php

namespace Drupal\profile\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockManager;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Utility\LinkGenerator;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\file\FileStorageInterface;
use Drupal\pfmyclinicalexpcom_profile\GlobalService;
use Drupal\block_content\Entity\BlockContent;
use Drupal\media\OEmbed\ResourceFetcherInterface;
use Drupal\media\OEmbed\UrlResolverInterface;
use Drupal\media\IFrameMarkup;
use Drupal\Core\Render\Markup;
use Drupal\file\Entity\File;
/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "my_banner_block",
 *   admin_label = @Translation("Banner block"),
 * )
 */
class BannerBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $node = \Drupal::routeMatch()->getParameter('node');
     if ($node instanceof \Drupal\node\NodeInterface) {
      if ($node && $node->getType() == 'article') {
        $imageUrl = '';
        $banner_image = $node->get("field_banner_images")->value;
        $field_image = $node->get("field_image")->target_id;
        if($field_image){
          $imageLoad = File::load($field_image);
          if($imageLoad){
            $imageUrl = $imageLoad->createFileUrl();
          }
        }
    }
    return[
    '#theme' => 'banner_block',
    '#banner_image' => $banner_image,
    '#article_image' => $imageUrl,
    ];
  }
}
  public function getCacheMaxAge() {  
    return 0;
  }
  public function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }
}