<?php
/**
 * ArtPictureDesign PHP Class
 * @package Art-Picture Design Plugin
 * Copyright 2020, Jens Wiecker
 * License: Commercial - goto https://art-picturedesign.de
 * https://art-picturedesign.de/webdesign
 *
 */
defined('ABSPATH')or die();

$ajax_path =plugin_dir_path(__DIR__);
require_once($ajax_path.'helper.php');
require_once($ajax_path.'objects/plugin-formular.php');

$Form = new APD\ArtDesign\APD_Settings_Form();
$Helper = new APD\ArtDesign\Helper();
$responseJson = new\ stdClass();
$data = $_POST['daten'];
$status = false;

isset($data['method']) && is_string($data['method']) ? $method = $Helper->sanitize($data['method']) : $method = '';
if (empty($method)) {
    $method = $_POST['method'];
}

switch ($method) {
  case'get_category';
    isset($_POST['id']) && is_numeric($_POST['id']) ? $id = $Helper->sanitize($_POST['id']) : $id = '';
    isset($_POST['group_id']) && is_numeric($_POST['group_id']) ? $group_id = $Helper->sanitize($_POST['group_id']) : $group_id = '';

    //Validate
    if(empty($id)){
      $responseJson->status = $status;
      $responseJson->msg = 'Ein Fehler ist aufgetreten!';
      return $responseJson;
    }

    if(empty($group_id)){
      $responseJson->status = $status;
      $responseJson->msg = 'Ein Fehler ist aufgetreten!';
      return $responseJson;
    }

    $Form->id = $group_id;
    $Form->group_id = $group_id;
    $group = $Form->get_group_by_id();
    $Form->lang_id = $group->lang_id;
    $Form->sett_id = $group->sett_id;
    $Form->id = $id;

    //EVENTS UND TAGE
    $send_arr = array();
    $event_arr = array();
    $event_out = new\ stdClass();
    for ($i=1; $i < 8 ; $i++) {
      $Form->day_id = $i;
      if($Form->id == '99999'){
        $event = $Form->get_public_all_events_by_day_id();
      }else {
        $event = $Form->get_public_event_by_day_id();
      }

      if($event ? $result = true : $result = false);
      $event_item = array(
        "event"=>$event,
        "day"=>$Form->get_event_lang(),
        "result" => $result
      );
      array_push($send_arr,$event_item);
    }
    //Kategorien
    $responseJson->settings = $Form->get_termine_settings();
    $responseJson->events = $send_arr;
    $responseJson->site_url = get_bloginfo('url').'/';
    $responseJson->status = true;
    break;

  case'get_all_termine':
    //EVENTS UND TAGE
    $send_arr = array();
    $settings = $Form->get_termine_settings();
    for ($i=1; $i < 8 ; $i++) {
      $Form->day_id = $i;
      $event = $Form->get_public_all_events_by_day_id();
      if($event ? $result = true : $result = false);
      $event_item = array(
        "event"=>$event,
        "day"=>$Form->get_event_lang(),
        "result" => $result
      );
      array_push($send_arr,$event_item);
    }
    //Kategorien
    $responseJson->settings = $Form->get_termine_settings();
    $responseJson->events = $send_arr;
    $responseJson->status = true;

    break;
}
