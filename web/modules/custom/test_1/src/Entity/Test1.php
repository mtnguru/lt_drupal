<?php

namespace Drupal\test_1\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\user\EntityOwnerTrait;

/**
 * Provides the Test 1 entity.
 *
 * @ContentEntityType(
 *   id = "test_1",
 *   label = @Translation("Test 1"),
 *   label_collection = @Translation("Test 1s"),
 *   label_singular = @Translation("test 1"),
 *   label_plural = @Translation("test 1s"),
 *   label_count = @PluralTranslation(
 *     singular = "@count test 1",
 *     plural = "@count test 1s",
 *   ),
 *   bundle_label = @Translation("Test 1 Type"),
 *   base_table = "test_1",
 *   data_table = "test_1_field_data",
 *   revision_table = "test_1_revision",
 *   revision_data_table = "test_1_field_revision",
 *   translatable = "TRUE",
 *   handlers = {
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *     "form" = {
 *       "default" = "Drupal\test_1\Form\Test1Form",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\test_1\Entity\Handler\Test1ListBuilder",
 *   },
 *   admin_permission = "administer test_1 entities",
 *   entity_keys = {
 *     "id" = "test_1_id",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *     "bundle" = "type",
 *     "revision" = "revision_id",
 *     "langcode" = "langcode",
 *     "owner" = "uid",
 *     "uid" = "uid",
 *   },
 *   bundle_entity_type = "test_1_type",
 *   field_ui_base_route = "entity.test_1_type.edit_form",
 *   links = {
 *     "add-page" = "/test_1/add",
 *     "add-form" = "/test_1/add/{test_1_type}",
 *     "canonical" = "/test_1/{test_1}",
 *     "collection" = "/admin/content/test_1",
 *     "delete-form" = "/test_1/{test_1}/delete",
 *     "edit-form" = "/test_1/{test_1}/edit",
 *   },
 * )
 */
class Test1 extends ContentEntityBase implements Test1Interface {

  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields += static::ownerBaseFieldDefinitions($entity_type);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t("Title"))
      ->setRequired(TRUE)
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE)
      ->setSetting("max_length", 255)
      ->setDisplayOptions("form", [
        'type' => "string_textfield",
        'weight' => "-5",
      ])
      ->setDisplayConfigurable("view", TRUE)
      ->setDisplayConfigurable("form", TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t("Created"))
      ->setDescription(t("The time that the entity was created."))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    $fields['my_body'] = BaseFieldDefinition::create('string')
      ->setLabel(t('MyBody'))
      ->setDescription(t('TODO: description of field.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    return $fields;
  }

}
