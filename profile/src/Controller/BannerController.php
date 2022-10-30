<?php
/**
 * @file
 * Contains \Drupal\profile\Controller\BannerController.
 */

namespace Drupal\profile\Controller;
 
use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;
 
class BannerController extends ControllerBase {

  public function content() {
   
    $banner = "/themes/custom/kmportal/images/Banner1.jpg"; 
    return $banner;
    
  }
}