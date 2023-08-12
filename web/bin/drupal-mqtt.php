#!/usr/bin/env /usr/bin/php8.2

<?php


use Drupal\Core\Session\UserSession;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\DrupalKernel;
use Drupal\Core\Site\Settings;

use \PhpMqtt\Client\MqttClient;
use \PhpMqtt\Client\ConnectionSettings;

$clientId = 'drupal';

$DRUPAL_DIR = '/home/lt/drupal/web/';
$autoloader = require_once $DRUPAL_DIR . 'autoload.php';
$configLoaded = false;
require_once $DRUPAL_DIR . 'core/includes/bootstrap.inc';

$aaa = [
  'clientId'=> 'drupal',
  'mqtt' => [
    'server' => 'labtime.org',
    'port' => 1883,
    'clientId' => "drupal",
    'mqttClientId' => "drupal_" . rand(0, 10000),
    'username' => 'data',
    'password' => 'datawp',
    'clean_session' => false,
    'mqtt_version' => '3.1.1',
  ],
  "topics" => [
    "subscribe" => [
      "rsp" => "a/admin/rsp/$clientId",
    ],
    "publish" => [
      "cmd" => "a/admin/cmd/administrator"
    ]
  ],
  "status" => [
    "debugLevel" => 0,
    "mqttConnected" => 0
  ]
];

$connectionSettings = (new ConnectionSettings)
  ->setUsername($aaa['mqtt']['username'])
  ->setPassword($aaa['mqtt']['password'])
  ->setKeepAliveInterval(60)
  ->setConnectTimeout(60)
  ->setReconnectAutomatically(true)
  ->setMaxReconnectAttempts(5)
  ->setLastWillQualityOfService(1);

////////// Main program

// Get the current date
$date = date('Y/m/d h:i:s');
print "start drupal-mqtt.php - " . $date . "\n";
print "PHP_SAPI: " . PHP_SAPI . "\n";
if (PHP_SAPI !== 'cli') {
  return;
}

bootDrupal($autoloader);

$client = connectMqtt();
//sleep(1);

$client->loop(true);

///////////////////////////// End of main program - Begin functions //////////////////////////

function getStatus() {
  global $aaa;

  return $payload = [
    "rsp" => "requestStatus",
    "clientId" => $aaa['clientId'],
    "mqttClientId" => $aaa['mqtt']['mqttClientId'],
    "hostname" => gethostname(),
    "debugLevel" => $aaa["status"]["debugLevel"],
    "mqttConnected" => $aaa["status"]["mqttConnected"]
  ];
}

function bootDrupal($autoloader) {
  global $DRUPAL_DIR;
  $request = Request::createFromGlobals();
  Settings::initialize(dirname(dirname(__DIR__)), DrupalKernel::findSitePath($request), $autoloader);
  $kernel = DrupalKernel::createFromRequest($request, $autoloader, 'prod')->boot();
  $kernel->boot();
  //$kernel->prepareLegacyRequest($request);

  // Switch from anonymous user to admin
  $accountSwitcher = \Drupal::service('account_switcher');
  $accountSwitcher->switchTo(new UserSession(['uid' => 1]));
}

function connectMqtt() {
  global $aaa, $configLoaded;
  $mcg = &$aaa['mqtt'];
  $client = $mc['client'] = new MqttClient(
                                     $mcg['server'],
                                     $mcg['port'],
                                     $mcg['mqttClientId'],
                                     $mcg['mqtt_version']);

  $client->connect($mcg['connectionSettings'], $mcg['clean_session']);
  $aaa["status"]["mqttConnected"]++;
  printf("client connected\n");

  $client->subscribe($aaa["topics"]["subscribe"]["rsp"],   function($_topic, $_payload) {
    processRsp($_topic,$_payload);
  });

  $payload = array(
    'cmd' => 'requestConfig',
    'clientId' => $aaa['clientId'],
  );
  $client->publish($aaa["topics"]["publish"]["cmd"], json_encode($payload), 0, true);
  return $client;
}

function setConfig($payloadIn) {
  global $client, $aaa, $configLoaded;
//$client->unsubscribe($aaa["topics"]["subscribe"]["rsp"], function ($_topic, $_payloadIn) {
//});

  $payloadIn['mqtt'] = $aaa['mqtt'];
  $aaa = $payloadIn;

  $client->subscribe($aaa["topics"]["subscribe"]["all"], function ($_topic, $_payloadIn) {
    processCmd($_topic, $_payloadIn);
  });
  $client->subscribe($aaa["topics"]["subscribe"]["adm"], function ($_topic, $_payloadIn) {
    processCmd($_topic, $_payloadIn);
  });
  $client->subscribe($aaa["topics"]["subscribe"]["dru"], function ($_topic, $_payloadIn) {
    processCmd($_topic, $_payloadIn);
  });
  $client->subscribe($aaa["topics"]["subscribe"]["msg"], function ($_topic, $_payloadIn) {
    processMsg($_topic, $_payloadIn);
  });
//$client->subscribe($aaa["topics"]["subscribe"]["cod"], function ($_topic, $_payloadIn) {
//  processMsg($_topic, $_payloadIn);
//});
  $client->subscribe($aaa["topics"]["subscribe"]["alm"], function ($_topic, $_payloadIn) {
    processMsg($_topic, $_payloadIn);
  });
  $client->subscribe($aaa["topics"]["subscribe"]["get"], function ($_topic, $_payloadIn) {
    processGet($_topic, $_payloadIn);
  });
//  $client->setLastWillTopic($aaa["topics"]["publish"]["wll"])
//    ->setLastWillMessage("$client client disconnected");
  $configLoaded = true;
}
/**
 * processRsp
 * @param $_topic
 * @param $_payload
 */
function processRsp($_topic, $_payloadIn) {
  global $aaa, $mqtt, $mqttClientId;
  $payloadIn = json_decode($_payloadIn, true);
  if ($payloadIn['rsp'] == 'requestConfig') {
    setConfig($payloadIn);
  }
  printf("Received message on topic [%s]: %s\n", $_topic, $_payloadIn);
};

function processCmd($_topic, $_payloadIn) {
  global $aaa, $client;
  $payloadIn = json_decode($_payloadIn, true);
  $payloadOut = [];
  $topic = $aaa["topics"]["publish"]["rsp"];
  if ($payloadIn['cmd'] == 'requestStatus') {
    $payloadOut = getStatus();
  } else if ($payloadIn['cmd'] == 'requestReset') {
    $payloadOut = [
      "rsp" => "requestReset",
      "msg" => "resetting ${aaa['clientId']} client"
    ];
  } else if ($payloadIn['cmd'] == 'setDebugLevel') {
    $aaa["status"]["debugLevel"] = $payloadIn["debugLevel"];
    $payloadOut = [
      "rsp" => "setDebugLevel",
      "debugLevel" => $aaa["status"]["debugLevel"],
    ];
  } else if ($payloadIn['cmd'] == 'getActive') {
    $active = getActive($payloadIn);
  }

  if ($payloadOut) {
    $client->publish($topic, json_encode($payloadOut), 0, true);
  }
}

function processReq($_topic, $_payloadIn) {
  global $aaa, $mqtt, $clientId;
  $payloadIn = json_decode($_payloadIn, true);
  $payloadOut = [];
  if ($payloadIn["sdb"] == "getNode") {
  } else if ($payloadIn["sdb"] == "saveMsg") {
  } else if ($payloadIn["sdb"] == "saveAct") {
  } else if ($payloadIn["sdb"] == "saveAlm") {
  }
}

function processMsg($_topic, $_payloadIn) {
  global $aaa, $mqtt, $clientId;
  $payloadIn = json_decode($_payloadIn, true);
  $payloadOut = [];
  if ($payloadIn["type"] == "Chat") {
  } else if ($payloadIn["type"] == "Notes") {
  }
}

function processGet($_topic, $_payloadIn) {
  global $aaa, $client;
  try {
    $payloadIn = json_decode($_payloadIn, true);
    $topic = $aaa['topics']['publish']['rpy'];
    $payloadOut = [];
    switch ($payloadIn["get"]) {
      case "getNode":
        $payloadOut = getNode($payloadIn);
        break;
      case "getUser":
        $payloadOut = getUser($payloadIn);
        break;
      case "getActivities":
        getActivities($payloadIn);
        break;
      default:
        break;
    }
    if ($payloadOut != []) {
      $client->publish($topic, json_encode($payloadOut), 0, true);
    }
  } catch(\Exception $err) {
    println ("processGet " . $err);
  }
}

function getNode($payloadIn) {
  $nid = $payloadIn['nid'];
  $node = Node::load($nid);
  $payloadOut = [
    "snd" => $payloadIn['get'],
    "title" => $node->label(),
    "nid" => $node->id(),
  ];
  switch ($node->getType()) {
    case 'project':
      break;
    case 'instance':
      break;
    case 'organization':
      break;
  }
  print "\n" . $nid . '  ' . $node->label() . "  " . $node->getType() . "\n\n";
  return $payloadOut;
}

function getUser($payloadIn) {
  return [];
}

function getActivities($payloadIn) {
  return [];
}

function getActive($payloadIn) {
  $uid = $payloadIn['uid'];
  // query uid for a list of organizations for this user
  $entityStorage = \Drupal::service('entity_type.manager')->getStorage('user');
  $entityQuery = $entityStorage->getQuery();
  $entityQuery->
  $entityQuery->addField('o', nid);
  $entityQuery->accessCheck(FALSE);
  $entityQuery->condition('uid', $uid);
  $organizationList = $entityQuery->execute();
  return $organizationList;
  // query for instances for the projects
  // filter for status === "In Process"
  // create array of instances
}
