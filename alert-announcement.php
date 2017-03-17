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
$stmt = db_query("SELECT v.value FROM {variable} v WHERE v.name = 'alert_announcement_external_cache'");
$external_cache = unserialize($stmt->fetchField());
if (intval($external_cache) == 0) {
  drupal_add_http_header('Cache-Control', 'no-cache, must-revalidate, post-check=0, pre-check=0');
} else {
  drupal_add_http_header('Cache-Control', 'public, max-age=' . intval($external_cache));
}

if ($alert_is_active) {
  $output = array();
  $stmt = db_query("SELECT v.value FROM {variable} v WHERE v.name = 'alert_announcement_message_key'");
  $alert_key = unserialize($stmt->fetchField());
  $stmt = db_query("SELECT v.value FROM {variable} v WHERE v.name = 'alert_announcement_message_headline'");
  $alert_headline = unserialize($stmt->fetchField());
  $stmt = db_query("SELECT v.value FROM {variable} v WHERE v.name = 'alert_announcement_message_subhead'");
  $alert_subhead = unserialize($stmt->fetchField());
  $stmt = db_query("SELECT v.value FROM {variable} v WHERE v.name = 'alert_announcement_severity'");
  $alert_severity = unserialize($stmt->fetchField());
  $stmt = db_query("SELECT v.value FROM {variable} v WHERE v.name = 'alert_announcement_message_markup'");
  $alert_body = unserialize($stmt->fetchField());
  $stmt = db_query("SELECT v.value FROM {variable} v WHERE v.name = 'alert_announcement_client_cache'");
  $client_cache = unserialize($stmt->fetchField());
  $stmt = db_query("SELECT v.value FROM {variable} v WHERE v.name = 'alert_announcement_dismissible'");
  $dismissible = unserialize($stmt->fetchField());
  $output[] = array(
    'key' => $alert_key, 
    'headline' => check_plain($alert_headline),
    'subhead' => check_plain($alert_subhead),
    'severity' => $alert_severity,
    'body' => $alert_body,
    'clientCacheTime' => intval($client_cache),
    'dismissible' => $dismissible,
    );

  drupal_add_http_header('Content-Type', 'application/json');
  if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
    echo json_encode($output, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
  } else {
    include_once DRUPAL_ROOT . '/includes/json-encode.inc';
    echo drupal_json_encode_helper($output);
  }

} else {
  drupal_add_http_header('Content-Type', 'application/json');
  echo '[]';
}

exit();
