<?php
namespace Drupal\profile\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\user\Entity\User;
use Drupal\user\UserInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;

class ProfileForm extends FormBase 
{
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'profile_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state){
   $account = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
   $form['user_picture'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('user picture'),
      '#description' => $this->t('Upload your user picture. '),
      '#required' => FALSE,
      //'#default_value' => $account->get('user_picture')->value,
      '#upload_validators' => [
        'file_validate_extensions' => ['gif png jpg jpeg'],
        'file_validate_size' => [25600000],
      ],
      '#upload_location' => 'public://',
    ];

    $form['field_first_name'] = [
      '#type' => 'textfield',
      '#title' => t('Firstname'),
      '#required' => TRUE,
      '#default_value' => $account->get('field_first_name')->value,
      '#attributes' => [
        'placeholder' => t('First Name'),
      ],
    ];
    
    $form['field_last_name'] = [
        '#type' => 'textfield',
        '#title' => t('Lastname'),
        '#required' => TRUE,
        '#default_value' => $account->get('field_last_name')->value,
      ];
    $form['field_date_of_birth'] = [
        '#type' => 'date',
        '#title' => t('Date Of Birth'),
        '#required' => TRUE,
        '#default_value' => $account->get('field_date_of_birth')->value,
      ];
    $form['field_role_or_position'] = [
      '#title' => t('Designation'),
      '#type' => 'textfield',
      '#required' => TRUE,
      '#default_value' => $account->get('field_role_or_position')->value,
    ];
    $form['field_about'] = [
      '#type' => 'textarea',
      '#title' => t('About'),
      '#required' => TRUE,
      '#default_value' => $account->get('field_about')->value,
    ];
    $form['actions']['cancel'] = [
      '#type' => 'submit',
      '#value' => $this->t('Cancel'),
      '#button_type' => 'primary',
      '#attributes' => [
        'onClick' => '/user/*;'
      ],
    ];
  
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
      
    ];
    return $form;
  }
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    if (!preg_match("/^[A-Z][a-zA-Z -]+$/", ($values['field_first_name']))) {
      $form_state->setErrorByName('field_first_name', $this->t('only alphabets'));
    }
  }
  

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
   $account = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
   $values = $form_state->getValues();
   $id = $account->get('uid')->value;
   $user_picture = $form_state->getValue('user_picture')[0];
   if ($user_picture) {
    
      $media = File::load($user_picture);
      $media_uri = $media->getFileUri();
   }
  

   $field_first_name = $values['field_first_name'];
   $field_last_name = $values['field_last_name'];
   $field_date_of_birth = $values['field_date_of_birth'];
   $field_role_or_position = $values['field_role_or_position'];
   $field_about = $values['field_about'];
   $account->set("field_picture",$user_picture);
   $account->set("field_first_name",$field_first_name);
   $account->set("field_last_name",$field_last_name);
   $account->set("field_date_of_birth",$field_date_of_birth);
   $account->set("field_role_or_position",$field_role_or_position);
   $account->set("field_about",$field_about);
  
   $account->save();
   \Drupal::messenger()->addStatus("Profile saved successfully.");
    $form_state->setRedirect("profile.info");
    // kint($form_state->getValue('user_picture')); exit();

}
}
