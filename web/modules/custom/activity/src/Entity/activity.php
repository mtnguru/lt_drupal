<?php

namespace Drupal\activity\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\user\EntityOwnerTrait;

/**
 * Provides the Activity entity.
 *
 * @ContentEntityType(
 *   id = "activity",
 *   label = @Translation("Activity"),
 *   label_collection = @Translation("Activitys"),
 *   label_singular = @Translation("activity"),
 *   label_plural = @Translation("activitys"),
 *   label_count = @PluralTranslation(
 *     singular = "@count activity",
 *     plural = "@count activitys",
 *   ),
 *   base_table = "activity",
 *   data_table = "activity_field_data",
 *   revision_table = "activity_revision",
 *   revision_data_table = "activity_field_revision",
 *   translatable = "TRUE",
 *   entity_keys = {
 *     "id" = "activity_id",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *     "revision" = "revision_id",
 *     "langcode" = "langcode",
 *     "owner" = "uid",
 *     "uid" = "uid",
 *     "published" = "status",
 *   },
 *   field_ui_base_route = "entity.activity.admin_form",
 * )
 */
class activity extends ContentEntityBase implements activityInterface {

  use EntityOwnerTrait;

  use EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields += static::ownerBaseFieldDefinitions($entity_type);

    $fields += static::publishedBaseFieldDefinitions($entity_type);

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

    $fields['date_range'] = BaseFieldDefinition::create('daterange')
      ->setLabel(t('Start and End Date'))
      ->setDescription(t('TODO: description of field.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    $fields['elapsed_seconds'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Offset in seconds from start of a video'))
      ->setDescription(t('TODO: description of field.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User ID'))
      ->setDescription(t('TODO: description of field.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    $fields['project_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Project ID'))
      ->setDescription(t('TODO: description of field.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    $fields['instance_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Instance ID'))
      ->setDescription(t('TODO: description of field.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    $fields['activity_type'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Activity Type'))
      ->setDescription(t('TODO: description of field.'))
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    return $fields;
  }

}
