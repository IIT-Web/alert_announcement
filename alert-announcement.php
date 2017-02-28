<?php

/**
 * @file
 * Alert announcement minimum Drupal bootstrap script.
 *
 * This file is used to return JSON for an AJAX request for any active
 * alert announcment messages. This file uses a minimal drupal bootstrap 
 * level to check the database for any active messages and return a JSON
 * response to the user.
 */

define('DRUPAL_ROOT', $_SERVER['DOCUMENT_ROOT']);

require_once DRUPAL_ROOT . '/includes/bootstrap.inc';

drupal_bootstrap(DRUPAL_BOOTSTRAP_DATABASE);

$stmt = db_query("SELECT v.value FROM {variable} v WHERE v.name = 'alert_announcement_active'");
$alert_is_active = unserialize($stmt->fetchField());

if ($alert_is_active) {
  echo 'alert is active';
} else {
  drupal_add_http_header('Content-Type', 'application/json');
  echo '[]';
}

exit();


//print_r($result);
// foreach ($result as $record) {
//  print_r($record);
// }
//print_r($result->fetchField());
//$array = $result->fetchAssoc();
//print_r($array);
//print_r(unserialize($array['value']));

// Query the database and see if an active alert announcement exists
// $query = db_select('variable', 'v');
// $query->condition('v.name', 'alert_announcement_active', '=')
//   ->fields('v', array('value'));
// $result = $query->execute();
// $alert_is_active = unserialize($result->fetchField());



// if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
//   $json_out = json_encode($output, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
//   drupal_add_http_header('Content-Type', 'application/json');
//   echo $json_out;
// } else {
//   include_once DRUPAL_ROOT . '/includes/json-encode.inc';
//     $json_out = drupal_json_encode_helper($output);
//     drupal_add_http_header('Content-Type', 'application/json');
//     echo $json_out;
// }

