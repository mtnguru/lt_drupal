<?php

namespace Drupal\activity\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Interface for Activity entities.
 */
interface activityInterface extends ContentEntityInterface, EntityOwnerInterface, EntityPublishedInterface {

}
