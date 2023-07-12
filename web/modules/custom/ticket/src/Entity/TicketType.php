<?php

namespace Drupal\ticket\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Provides the Ticket Type entity.
 *
 * @ConfigEntityType(
 *   id = "ticket_type",
 *   label = @Translation("Ticket Type"),
 *   label_collection = @Translation("Ticket Types"),
 *   label_singular = @Translation("ticket type"),
 *   label_plural = @Translation("ticket types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count ticket type",
 *     plural = "@count ticket types",
 *   ),
 *   bundle_of = "ticket",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *   },
 * )
 */
class TicketType extends ConfigEntityBundleBase implements TicketTypeInterface {

  /**
   * Machine name.
   *
   * @var string
   */
  protected $id = '';

  /**
   * Name.
   *
   * @var string
   */
  protected $label = '';

}
