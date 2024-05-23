<?php

namespace Drupal\Tests\olive\Unit;

use Drupal\Tests\UnitTestCase;

/**
 * Tests the _olive_hex_to_hsl() function.
 *
 * @group olive
 */
final class OliveroHexToHslTest extends UnitTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();
    require_once __DIR__ . '/../../../olive.theme';
  }

  /**
   * Tests hex to HSL conversion.
   *
   * @param string $hex
   *   The hex code.
   * @param array $expected_hsl
   *   The expected HSL values.
   *
   * @dataProvider hexCodes
   */
  public function testHexToHsl(string $hex, array $expected_hsl): void {
    self::assertEquals($expected_hsl, _olive_hex_to_hsl($hex));
  }

  /**
   * Data provider of hex codes and HSL values.
   *
   * @return array[]
   *   The test data.
   */
  public function hexCodes(): array {
    return [
      'Blue Lagoon' => ['#1b9ae4', [202, 79, 50]],
      'Firehouse' => ['#a30f0f', [0, 83, 35]],
      'Ice' => ['#57919e', [191, 29, 48]],
      'Plum' => ['#7a4587', [288, 32, 40]],
      'Slate' => ['#47625b', [164, 16, 33]],
    ];
  }

}
