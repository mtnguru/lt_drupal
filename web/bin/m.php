#!/usr/bin/env php

<?php

/**
 * @file
 * A command line application to generate proxy classes.
 */

$DRUPAL_DIR='/home/lt/drupal/web/';

use Drupal\Core\Session\UserSession;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\DrupalKernel;
use Drupal\Core\Site\Settings;

// Get the current date
$date = date('Y/m/d h:i:s');
print "start db.php - " . $date . "\n";
print "PHP_SAPI: " . PHP_SAPI . "\n";

if (PHP_SAPI !== 'cli') {
  return;
}

// Bootstrap Drupal

//define('DRUPAL_DIR', '/home/lt/drupal/web');

$autoloader = require_once $DRUPAL_DIR . 'autoload.php';
require_once $DRUPAL_DIR . 'core/includes/bootstrap.inc';
$request = Request::createFromGlobals();
Settings::initialize(dirname(dirname(__DIR__)), DrupalKernel::findSitePath($request), $autoloader);
$kernel = DrupalKernel::createFromRequest($request, $autoloader, 'prod')->boot();
$kernel->boot();
//$kernel->prepareLegacyRequest($request);

// Switch from anonymous user to admin
$accountSwitcher = \Drupal::service('account_switcher');
$accountSwitcher->switchTo(new UserSession(['uid' => 1]));

exit(0);

/////////////////////////////////////////////////////////////////////////////////////////

