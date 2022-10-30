<?php
/**
 * @file
 * Contains \Drupal\profile\Controller\ProfileController.
 */

namespace Drupal\profile\Controller;
 
use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;
 
class ProfileController extends ControllerBase {

  public function content() {
    $uid = \Drupal::currentUser()->id();
    $user_load = User::load($uid);
    $first_name = $user_load->get('field_first_name')->value;
    $last_name = $user_load->get('field_last_name')->value;
    $field_date_of_birth = $user_load->get('field_date_of_birth')->value;
    $field_role_or_position = $user_load->get('field_role_or_position')->value;

    $field_about = $user_load->get('field_about')->value;
    $build = [
      '#theme' => 'profile_details',
      '#field_first_name' => $first_name,
      '#field_last_name' => $last_name,
      '#field_date_of_birth' => $field_date_of_birth,
      '#field_role_or_position' => $field_role_or_position,
      '#field_about' => $field_about,
      
    ];
    return $build;
 
  }
}