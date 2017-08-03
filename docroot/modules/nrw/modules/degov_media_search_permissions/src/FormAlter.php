<?php

namespace Drupal\degov_media_search_permissions;

use Drupal\Core\Entity\EntityFormInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\entity_reference_integrity\EntityReferenceDependencyManagerInterface;
use Drupal\user\PrivateTempStoreFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Alter entity delete forms to provide some warning deletes will fail.
 */
class FormAlter extends \Drupal\entity_reference_integrity_enforce\FormAlter {

  /**
   * The array of media entities to delete.
   *
   * @var string[][]
   */
  protected $entityInfo = [];

  /**
   * The tempstore factory.
   *
   * @var \Drupal\user\PrivateTempStoreFactory
   */
  protected $tempStoreFactory;

  /**
   * The entity storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $storage;

  /**
   * {@inheritdoc}
   */
  public function __construct(EntityReferenceDependencyManagerInterface $calculator, $enabled_entity_type_ids, PrivateTempStoreFactory $temp_store_factory, EntityTypeManagerInterface $manager) {
    $this->dependencyManager = $calculator;
    $this->enabledEntityTypeIds = $enabled_entity_type_ids;
    $this->storage = $manager->getStorage('media');
    $this->tempStoreFactory = $temp_store_factory;
    parent::__construct($calculator, $enabled_entity_type_ids);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_reference_integrity.dependency_manager'),
      $container->get('config.factory')->get('entity_reference_integrity_enforce.settings')->get('enabled_entity_type_ids'),
      $container->get('user.private_tempstore'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * Implements hook_form_alter().
   */
  public function formAlter(&$form, FormStateInterface $form_state, $form_id) {
    /** @var EntityFormInterface $form_object */
    $form_object = $form_state->getFormObject();
    if (!$this->isDeleteForm($form_object)) {
      return;
    }
    $this->entityInfo = $this->tempStoreFactory->get('media_multiple_delete_confirm')->get(\Drupal::currentUser()->id());
    /** @var \Drupal\media_entity\MediaInterface[] $entities */
    $entities = $this->storage->loadMultiple(array_keys($this->entityInfo));
    foreach ($entities as $entity) {
      if (in_array($entity->getEntityTypeId(), $this->enabledEntityTypeIds, TRUE) && $this->dependencyManager->hasDependents($entity)) {
        $referencing_entities = $this->dependencyManager->getDependentEntities($entity);
        if (count($entities) > 1) {
          drupal_set_message($this->t('You can not delete the entities as this are being referenced by another entity.'), 'warning');
        }
        else {
          drupal_set_message($this->t('You can not delete this as it is being referenced by another entity.'), 'warning');
        }
        $form['actions']['submit']['#disabled'] = TRUE;
        $form['referencing_entities_list'][] = [
          '#weight' => -10,
          'explanation' => [
            '#prefix' => '<p><i>',
            '#markup' => $entity->label(),
            '#suffix' => '</i><p>',
          ],
          'entities' => $this->buildReferencingEntitiesList($referencing_entities),
          '#suffix' => '<br/>',
        ];
        $form['entities']['#access'] = FALSE;
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function isDeleteForm($form_object) {
    return $form_object->getFormId() === 'media_multiple_delete_confirm';
  }
}
