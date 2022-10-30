<?php

namespace Drupal\profile\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\user\Entity\User;
use Drupal\node\Entity\Node;
use Drupal\file\Entity\File;
use Drupal\media\OEmbed\UrlResolverInterface;
use Drupal\media\IFrameMarkup;
use Drupal\Core\Render\Markup;
use Drupal\file\FileStorageInterface;

class PostForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'post_form';
  }

  /**
   * {@inheritdoc}
   */

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['create_post'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Create a post'),
      '#description' => $this->t('Enter the post. '),
      '#required' => TRUE,
    ];
    $form['image_post'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('image'),
      '#description' => $this->t('Upload your post image. '),
      '#required' => TRUE,
      '#upload_validators' => [
        'file_validate_extensions' => ['gif png jpg jpeg'],
        'file_validate_size' => [25600000],
      ],
      '#upload_location' => 'public://',

    ];
    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('post'),
      '#button_type' => 'primary',
    ];
    
    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $node = Node::create([
      'type' => 'page',
      'title' => 'Creating a post',
      'langcode' => 'en',
      'field_post' => $form_state->getValue('create_post'),
      'field_picture' => $form_state->getValue('image_post')[0],

    ]);
    
    $node->save();

    \Drupal::messenger()->addStatus("Your Post saved successfully.");

  }

}
