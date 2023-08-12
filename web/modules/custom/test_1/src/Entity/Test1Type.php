<?php

namespace Drupal\test_1\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Provides the Test 1 Type entity.
 *
 * @ConfigEntityType(
 *   id = "test_1_type",
 *   label = @Translation("Test 1 Type"),
 *   label_collection = @Translation("Test 1 Types"),
 *   label_singular = @Translation("test 1 type"),
 *   label_plural = @Translation("test 1 types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count test 1 type",
 *     plural = "@count test 1 types",
 *   ),
 *   bundle_of = "test_1",
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
class Test1Type extends ConfigEntityBundleBase implements Test1TypeInterface {

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
