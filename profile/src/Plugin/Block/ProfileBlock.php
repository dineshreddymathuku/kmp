<?php

namespace Drupal\profile\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\Entity\User;
use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;

/**
 * Provides a block for Profile details.
 *
 * @Block(
 *   id = "profile_block",
 *   admin_label = @Translation("Profile Block"),
 * )
 */
class ProfileBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */

  public function build() {
    $build = [];
    $currentUser = \Drupal::currentUser();
    $id = $currentUser->id();
    $account = User::load($id);
    $user_picture = $account->get('field_picture')->target_id;
    $file = File::load($user_picture);
    if($file){
        $file_path = $file->getFileUri();
    }
    dsm($)
    $field_first_name = $account->field_first_name->value;
    $field_last_name = $account->field_last_name->value;
    $field_date_of_birth = $account->field_date_of_birth->value;
    $field_role_or_position = $account->field_role_or_position->value;
    $field_about = $account->field_about->value;
    // Getting current user and role.
    $roles = $currentUser->getRoles();
    
    $register = FALSE;
    if (in_array('administrator',$roles) || in_array('account_lead',$roles) || in_array('solutions_lead',$roles) || in_array('finance_lead',$roles) || in_array('hr_lead',$roles)) {
      $register = TRUE;
    }

    $data['user_picture'] = $file_path;
    $data['first_name'] = $field_first_name;
    $data['last_name'] = $field_last_name;
    $data['date_of_birth'] = $field_date_of_birth;
    $data['role_or_position'] = $field_role_or_position;
    $data['about'] = $field_about;
    $data['register'] = $register;

    $build = [
      '#theme' => 'profile_block',
      '#data' => $data,
    ];
    return $build;
  }

  public function getCacheMaxAge() {
    return 0;
  }

}
