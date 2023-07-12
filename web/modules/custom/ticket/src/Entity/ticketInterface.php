<?php

namespace Drupal\ticket\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Interface for Ticket entities.
 */
interface ticketInterface extends ContentEntityInterface, EntityOwnerInterface, EntityPublishedInterface {

}
