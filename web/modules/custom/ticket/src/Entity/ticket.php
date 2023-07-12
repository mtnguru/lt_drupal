<?php

namespace Drupal\ticket\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\user\EntityOwnerTrait;

/**
 * Provides the Ticket entity.
 *
 * @ContentEntityType(
 *   id = "ticket",
 *   label = @Translation("Ticket"),
 *   label_collection = @Translation("Tickets"),
 *   label_singular = @Translation("ticket"),
 *   label_plural = @Translation("tickets"),
 *   label_count = @PluralTranslation(
 *     singular = "@count ticket",
 *     plural = "@count tickets",
 *   ),
 *   bundle_label = @Translation("Ticket Type"),
 *   base_table = "ticket",
 *   data_table = "ticket_field_data",
 *   revision_table = "ticket_revision",
 *   revision_data_table = "ticket_field_revision",
 *   translatable = "TRUE",
 *   entity_keys = {
 *     "id" = "ticket_id",
 *     "label" = "title",
 *     "uuid" = "uuid",
 *     "bundle" = "type",
 *     "revision" = "revision_id",
 *     "langcode" = "langcode",
 *     "owner" = "uid",
 *     "uid" = "uid",
 *     "published" = "status",
 *   },
 *   bundle_entity_type = "ticket_type",
 *   field_ui_base_route = "entity.ticket_type.edit_form",
 * )
 */
class ticket extends ContentEntityBase implements ticketInterface {

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
