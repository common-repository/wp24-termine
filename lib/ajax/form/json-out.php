<?php
defined('ABSPATH')or die();
/**
 * ArtPictureDesign PHP Class
 * @package Art-Picture Design Plugin
 * Copyright 2020, Jens Wiecker
 * License: Commercial - goto https://art-picturedesign.de
 * https://art-picturedesign.de/webdesign
 *
 */
    //Tables
    $table_settings = 'apd_settings';
    $table_weekdays = 'apd_weekdays';
    $table_category = 'apd_category';
    $table_termin = 'apd_termin';
    $table_groups = 'apd_group';

isset($_GET['m']) && is_string($_GET['m']) ? $method = sanitize_text_field($_GET['m']) : $method = '';
isset($_GET['id']) && is_numeric($_GET['id']) ? $id = sanitize_text_field($_GET['id']) : $id = '';
global $wpdb;
$response = false;
switch($method){
  case'get_groups':
    $table = $wpdb->prefix . $table_groups;
    $table_settings = $wpdb->prefix . $table_settings;
    $table_weekdays = $wpdb->prefix . $table_weekdays;
    $response = $wpdb->get_results("SELECT $table.*,
    $table_settings.name as settings_name,
    $table_weekdays.sprache as lang_name
    FROM {$table}
    LEFT JOIN {$table_settings} ON {$table}.sett_id = {$table_settings}.id
    LEFT JOIN {$table_weekdays} ON {$table}.lang_id = {$table_weekdays}.id
    ");
    break;

  case'get_settings':
      $table = $wpdb->prefix . $table_settings;
      $response = $wpdb->get_results("SELECT *
      FROM {$table} ");
      break;

  case'get_settings_by_id':
      $table = $wpdb->prefix . $table_settings;
      $response = $wpdb->get_row("SELECT *
      FROM {$table} WHERE id = {$id} ");
      break;

  case'get_language':
      $table = $wpdb->prefix . $table_weekdays;
      $response = $wpdb->get_results("SELECT *
      FROM {$table} ");
      break;

  case'get_language_by_id':
      $table = $wpdb->prefix . $table_weekdays;
      $response = $wpdb->get_row("SELECT *
      FROM {$table} WHERE id = {$id}");
      break;

   case'get_category':
       $table = $wpdb->prefix . $table_category;
       $response = $wpdb->get_results("SELECT *
       FROM {$table} ");
      break;

   case'get_category_by_id':
       $table = $wpdb->prefix . $table_category;
       $response = $wpdb->get_row("SELECT *
       FROM {$table} WHERE id = {$id} ");
      break;

  case'get_events':
      $table = $wpdb->prefix . $table_termin;
      $response = $wpdb->get_results("SELECT *
        FROM $table
        ");
      break;

  case'get_events_by_id':
      $table = $wpdb->prefix . $table_termin;
      $response = $wpdb->get_row("SELECT *
        FROM $table WHERE id = {$id} ");
      break;
}
    echo json_encode($response);
