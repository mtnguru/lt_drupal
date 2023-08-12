<?php

namespace Drupal\test_1\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Interface for Test 1 entities.
 */
interface Test1Interface extends ContentEntityInterface, EntityOwnerInterface {

}
