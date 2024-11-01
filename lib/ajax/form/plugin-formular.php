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
  case'edit_settings':
    isset($data['id']) && is_numeric($data['id']) ? $Form->id = $Helper->sanitize($data['id']) : $Form->id = '';
    isset($data['name']) && is_string($data['name']) ? $Form->name = $Helper->sanitize($data['name']) : $Form->name = '';
    isset($data['bg_color']) && is_string($data['bg_color']) ? $Form->bg_color = $Helper->sanitize($data['bg_color']) : $Form->bg_color = '#808080';
    isset($data['bg_txt']) && is_string($data['bg_txt']) ? $Form->bg_txt = $Helper->sanitize($data['bg_txt']) : $Form->bg_txt = '#FFFFFF';
    isset($data['bg_leer']) && is_string($data['bg_leer']) ? $Form->bg_leer = $Helper->sanitize($data['bg_leer']) : $Form->bg_leer = 'transparent';
    isset($data['min_height']) && is_numeric($data['min_height']) ? $Form->min_height = $Helper->sanitize($data['min_height']) : $Form->min_height = 130;
    isset($data['week_size']) && is_numeric($data['week_size']) ? $Form->week_size = $Helper->sanitize($data['week_size']) : $Form->week_size = 18;
    isset($data['time_size']) && is_numeric($data['time_size']) ? $Form->time_size = $Helper->sanitize($data['time_size']) : $Form->time_size = 16;
    isset($data['content_size']) && is_numeric($data['content_size']) ? $Form->content_size = $Helper->sanitize($data['content_size']) : $Form->content_size = 18;

    //Validate
    if(empty($Form->id)) {
      $responseJson->status = $status;
      $responseJson->msg = $Form->apd_termine_error_msg(1);
      return $responseJson;
    }

    if(empty($Form->name)) {
      $responseJson->status = $status;
      $responseJson->msg = $Form->apd_termine_error_msg(2);
      return $responseJson;
    }

    $Form->update_standard_settings();
    $status = true;
    $responseJson->status = $status;
    $responseJson->msg = $Form->apd_termine_error_msg(3);
    break;

  case'update_settings':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = '';
      isset($_POST['name']) && is_string($_POST['name']) ? $Form->name = $Helper->sanitize($_POST['name']) : $Form->name = '';
      isset($_POST['header_bg']) && is_string($_POST['header_bg']) ? $Form->bg_color = $Helper->sanitize($_POST['header_bg']) : $Form->bg_color = '#808080';
      isset($_POST['header_color']) && is_string($_POST['header_color']) ? $Form->bg_txt = $Helper->sanitize($_POST['header_color']) : $Form->bg_txt = '#FFFFFF';
      isset($_POST['leer_bg']) && is_string($_POST['leer_bg']) ? $Form->bg_leer = $Helper->sanitize($_POST['leer_bg']) : $Form->bg_leer = '#808080';
      isset($_POST['min_height']) && is_numeric($_POST['min_height']) ? $Form->min_height = $Helper->sanitize($_POST['min_height']) : $Form->min_height = 130;
      isset($_POST['size_header']) && is_numeric($_POST['size_header']) ? $Form->week_size = $Helper->sanitize($_POST['size_header']) : $Form->week_size = 18;
      isset($_POST['datum_size']) && is_numeric($_POST['datum_size']) ? $Form->time_size = $Helper->sanitize($_POST['datum_size']) : $Form->time_size = 16;
      isset($_POST['content_size']) && is_numeric($_POST['content_size']) ? $Form->content_size = $Helper->sanitize($_POST['content_size']) : $Form->content_size = 18;
      //Validate
      if(empty($Form->id)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

        $getSettings = $Form->get_settings_by_id();
        if($getSettings->name != $Form->name){
          $newName = $Form->get_settings_by_name();
          if($newName) {
            $responseJson->status = $status;
            $responseJson->msg = $Form->apd_termine_error_msg(4);
            return $responseJson;
          }
        }

        $Form->update_standard_settings();
        $status = true;
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(3);
      break;

  case'delete_settings':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = '';
      //Validate
      if(empty($Form->id)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $settings = $Form->get_settings();
      if(count($settings) == 1) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(5);
        return $responseJson;
      }

      $group = $Form->get_group_by_settings_id();
      if($group) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(6);
        return $responseJson;
      }

      $Form->delete_settings();
      $status = true;
      $responseJson->status = $status;
      $responseJson->id = $Form->id;
      $responseJson->msg = $Form->apd_termine_error_msg(7);
    break;

  case'set_settings':
      isset($data['name']) && is_string($data['name']) ? $Form->name = $Helper->sanitize($data['name']) : $Form->name = '';
      isset($data['bg_color']) && is_string($data['bg_color']) ? $Form->bg_color = $Helper->sanitize($data['bg_color']) : $Form->bg_color = '#808080';
      isset($data['bg_txt']) && is_string($data['bg_txt']) ? $Form->bg_txt = $Helper->sanitize($data['bg_txt']) : $Form->bg_txt = '#FFFFFF';
      isset($data['bg_leer']) && is_string($data['bg_leer']) ? $Form->bg_leer = $Helper->sanitize($data['bg_leer']) : $Form->bg_leer = '#808080';
      isset($data['min_height']) && is_numeric($data['min_height']) ? $Form->min_height = $Helper->sanitize($data['min_height']) : $Form->min_height = 130;
      isset($data['week_size']) && is_numeric($data['week_size']) ? $Form->week_size = $Helper->sanitize($data['week_size']) : $Form->week_size = 18;
      isset($data['time_size']) && is_numeric($data['time_size']) ? $Form->time_size = $Helper->sanitize($data['time_size']) : $Form->time_size = 16;
      isset($data['content_size']) && is_numeric($data['content_size']) ? $Form->content_size = $Helper->sanitize($data['content_size']) : $Form->content_size = 18;

      if(empty($Form->name)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(8);
        return $responseJson;
      }

      $newName = $Form->get_settings_by_name();
      if($newName) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(4);
        return $responseJson;
      }

      //DEfault Werte
      $Form->drop_bg = '#CD7399';
      $Form->drop_txt = '#FFFFFF';
      $Form->drop_hover_bg = '#663749';
      $Form->drop_txt_size = 16;
      $Form->drop_bezeichnung = __('All appointments', 'wp24-termine');

      $Form->cont_width = '100%';
      $Form->padding_top = '15px';
      $Form->padding_bottom = '15px';
      $Form->padding_left = '25px';
      $Form->padding_right = '25px';
      $Form->margin_top = '0px';
      $Form->margin_bottom = '0px';
      $Form->margin_left = 'auto';
      $Form->margin_right = 'auto';

      $Form->aktiv = 0;
      $Form->drop_aktiv = 1;
      $insert = $Form->set_settings();
      if($insert){
        $sprache = array(
          $Form->apd_termine_error_msg(112),
          $Form->apd_termine_error_msg(113)
        );
        $responseJson->status = true;
        $responseJson->id = $insert['id'];
        $responseJson->name = $Form->name;
        $responseJson->header_bg = $Form->bg_color;
        $responseJson->header_color = $Form->bg_txt;
        $responseJson->leer_bg = $Form->bg_leer;
        $responseJson->min_height = $Form->min_height;
        $responseJson->size_header = $Form->week_size;
        $responseJson->size_content = $Form->content_size;
        $responseJson->size_time = $Form->time_size;
        $responseJson->add_settings = true;
        $responseJson->sprache = $sprache;
        $responseJson->msg = $Form->apd_termine_error_msg(3);
        return $responseJson;
      }
      $responseJson->status = $status;
      $responseJson->msg = $Form->apd_termine_error_msg(8);
      break;

  case'change_aktiv_settings':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $id = $Helper->sanitize($_POST['id']) : $id = '';
      //Validate
      if(empty($id)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $Form->id = $id;
      $settings = $Form->get_settings_by_id();

      if($settings->aktiv == 1){
        $Form->aktiv = 1;
        $Form->update_settings_aktiv();
        $responseJson->status = $status;
        $responseJson->new_id = $Form->id;
        $responseJson->msg = $Form->apd_termine_error_msg(8);
        return $responseJson;
      }

      $Form->aktiv = 1;
      $old_aktiv = $Form->get_settings_by_aktiv();
      $Form->id = $old_aktiv->id;
      $Form->aktiv = 0;
      $Form->update_settings_aktiv();

      if(empty($settings->aktiv) ? $Form->aktiv = 1 : $Form->aktiv = 0);
      $Form->id = $settings->id;
      $Form->update_settings_aktiv();
      $responseJson->status = true;
      $responseJson->new_id = $settings->id;
      $responseJson->old_id = $old_aktiv->id;
      $responseJson->msg = $Form->apd_termine_error_msg(3);
      break;

  case'edit_weekdays':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = '';
      isset($_POST['sprache']) && is_string($_POST['sprache']) ? $Form->sprache = $Helper->sanitize($_POST['sprache']) : $Form->sprache = "de";
      isset($_POST['montag']) && is_string($_POST['montag']) ? $Form->montag = $Helper->sanitize($_POST['montag']) : $Form->montag = "Montag";
      isset($_POST['dienstag']) && is_string($_POST['dienstag']) ? $Form->dienstag = $Helper->sanitize($_POST['dienstag']) : $Form->dienstag = "Dienstag";
      isset($_POST['mittwoch']) && is_string($_POST['mittwoch']) ? $Form->mittwoch = $Helper->sanitize($_POST['mittwoch']) : $Form->mittwoch = "Mittwoch";
      isset($_POST['donnerstag']) && is_string($_POST['donnerstag']) ? $Form->donnerstag = $Helper->sanitize($_POST['donnerstag']) : $Form->donnerstag = "Donnerstag";
      isset($_POST['freitag']) && is_string($_POST['freitag']) ? $Form->freitag = $Helper->sanitize($_POST['freitag']) : $Form->freitag = "Freitag";
      isset($_POST['samstag']) && is_string($_POST['samstag']) ? $Form->samstag = $Helper->sanitize($_POST['samstag']) : $Form->samstag = "Samstag";
      isset($_POST['sonntag']) && is_string($_POST['sonntag']) ? $Form->sonntag = $Helper->sanitize($_POST['sonntag']) : $Form->sonntag = "Sonntag";

      //Validate
      if(empty($Form->id)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $Form->update_weekday();
      $status = true;
      $responseJson->status = $status;
      $responseJson->msg = $Form->apd_termine_error_msg(3);
      break;

  case'delete_weekdays':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = '';
      //Validate
      if(empty($Form->id)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $settings = $Form->get_weekdays();
      if(count($settings) == 1) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(9);
        return $responseJson;
      }


      $Form->delete_weekdays();
      $status = true;
      $responseJson->status = $status;
      $responseJson->id = $Form->id;
      $responseJson->msg = $Form->apd_termine_error_msg(7);
      break;

  case'set_weekdays':
      isset($data['lang_sprache']) && is_string($data['lang_sprache']) ? $Form->lang_sprache = $Helper->sanitize($data['lang_sprache']) : $Form->lang_sprache = "";
      isset($data['montag']) && is_string($data['montag']) ? $Form->montag = $Helper->sanitize($data['montag']) : $Form->montag = "Montag";
      isset($data['dienstag']) && is_string($data['dienstag']) ? $Form->dienstag = $Helper->sanitize($data['dienstag']) : $Form->dienstag = "Dienstag";
      isset($data['mittwoch']) && is_string($data['mittwoch']) ? $Form->mittwoch = $Helper->sanitize($data['mittwoch']) : $Form->mittwoch = "Mittwoch";
      isset($data['donnerstag']) && is_string($data['donnerstag']) ? $Form->donnerstag = $Helper->sanitize($data['donnerstag']) : $Form->donnerstag = "Donnerstag";
      isset($data['freitag']) && is_string($data['freitag']) ? $Form->freitag = $Helper->sanitize($data['freitag']) : $Form->freitag = "Freitag";
      isset($data['samstag']) && is_string($data['samstag']) ? $Form->samstag = $Helper->sanitize($data['samstag']) : $Form->samstag = "Samstag";
      isset($data['sonntag']) && is_string($data['sonntag']) ? $Form->sonntag = $Helper->sanitize($data['sonntag']) : $Form->sonntag = "Sonntag";

      if(empty($Form->lang_sprache) ) {
        $Form->lang_sprache = "de";
      }

      if(empty($Form->montag) ) {
        $Form->montag = "Montag";
      }
      if(empty($Form->dienstag) ) {
        $Form->dienstag = "Dienstag";
      }
      if(empty($Form->mittwoch) ) {
        $Form->mittwoch = "Mittwoch";
      }
      if(empty($Form->donnerstag) ) {
        $Form->donnerstag = "Donnerstag";
      }
      if(empty($Form->freitag) ) {
        $Form->freitag = "Freitag";
      }
      if(empty($Form->samstag) ) {
        $Form->samstag = "Samstag";
      }
      if(empty($Form->sonntag) ) {
        $Form->sonntag = "Sonntag";
      }
      $Form->aktiv = 1;
      $insert = $Form->set_weekdays();
      if($insert){
        $days = array(
          "id"=> $insert['id'],
          "montag"=> $Form->montag,
          "dienstag"=> $Form->dienstag,
          "mittwoch"=> $Form->mittwoch,
          "donnerstag"=> $Form->donnerstag,
          "freitag"=> $Form->freitag,
          "samstag"=> $Form->samstag,
          "sonntag"=> $Form->sonntag,
          "sprache"=> $Form->lang_sprache
        );
        $sprache = array(
          $Form->apd_termine_error_msg(112),
          $Form->apd_termine_error_msg(113)
        );
        $responseJson->status = true;
        $responseJson->add_weekdays = true;
        $responseJson->days = $days;
        $responseJson->btn_sprache = $sprache;
        $responseJson->msg = $Form->apd_termine_error_msg(3);
        return $responseJson;
      }
      $responseJson->status = $status;
      $responseJson->msg = $Form->apd_termine_error_msg(8);
      break;

  case'change_weekdays_aktiv':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $id = $Helper->sanitize($_POST['id']) : $id = '';
      //Validate
      if(empty($id)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $Form->id = $id;
      $settings = $Form->get_weekdays_by_id();

      if($settings->aktiv == 1){
        $Form->aktiv = 1;
        $Form->update_weekdays_aktiv();
        $responseJson->status = $status;
        $responseJson->new_id = $Form->id;
        $responseJson->msg = $Form->apd_termine_error_msg(8);
        return $responseJson;
      }

      $Form->aktiv = 1;
      $old_aktiv = $Form->get_weekdays_by_aktiv();
      $Form->id = $old_aktiv->id;
      $Form->aktiv = 0;
      $Form->update_weekdays_aktiv();

      if(empty($settings->aktiv) ? $Form->aktiv = 1 : $Form->aktiv = 0);
      $Form->id = $settings->id;
      $Form->update_weekdays_aktiv();
      $responseJson->status = true;
      $responseJson->new_id = $settings->id;
      $responseJson->old_id = $old_aktiv->id;
      $responseJson->msg = $Form->apd_termine_error_msg(3);
      break;
  case'set_category':
      isset($data['name']) && is_string($data['name']) ? $Form->name = $Helper->sanitize($data['name']) : $Form->name = "";
      isset($data['txt_color']) && is_string($data['txt_color']) ? $Form->txt_color = $Helper->sanitize($data['txt_color']) : $Form->txt_color = "";
      isset($data['bg_color']) && is_string($data['bg_color']) ? $Form->bg_color = $Helper->sanitize($data['bg_color']) : $Form->bg_color = "";
      isset($data['hover_txt']) && is_string($data['hover_txt']) ? $Form->hover_txt = $Helper->sanitize($data['hover_txt']) : $Form->hover_txt = "";
      isset($data['hover_bg']) && is_string($data['hover_bg']) ? $Form->hover_bg = $Helper->sanitize($data['hover_bg']) : $Form->hover_bg = "";

      //Validate
      if(empty($Form->name)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(10);
        return $responseJson;
      }

      $Form->aktiv = 1;
      $insert = $Form->set_category();
      if($insert){
        $eintrag = array(
          "id"=> $insert['id'],
          "name"=> $Form->name,
          "txt_color"=> $Form->txt_color,
          "bg_color"=> $Form->bg_color,
          "hover_txt"=> $Form->hover_txt,
          "hover_bg"=> $Form->hover_bg
        );
        $sprache = array(
          $Form->apd_termine_error_msg(112),
          $Form->apd_termine_error_msg(113)
        );
        $responseJson->status = true;
        $responseJson->add_category = true;
        $responseJson->eintrag = $eintrag;
        $responseJson->sprache = $sprache;
        $responseJson->msg = $Form->apd_termine_error_msg(11);
        return $responseJson;
      }
      $responseJson->status = $status;
      $responseJson->msg = $Form->apd_termine_error_msg(12);
      break;

  case'delete_category':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = '';
      //Validate
      if(empty($Form->id)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $event = $Form->get_event_by_cat_id();
      if($event){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(13);
        return $responseJson;
      }

      $Form->delete_category();
      $status = true;
      $responseJson->status = $status;
      $responseJson->id = $Form->id;
      $responseJson->msg = $Form->apd_termine_error_msg(14);
      break;

  case'edit_category':

      if(empty($data)){
        $data = $_POST;
      }
      isset($data['id']) && is_numeric($data['id']) ? $Form->id = $Helper->sanitize($data['id']) : $Form->id = '';
      isset($data['name']) && is_string($data['name']) ? $Form->name = $Helper->sanitize($data['name']) : $Form->name = "";
      isset($data['txt_color']) && is_string($data['txt_color']) ? $Form->txt_color = $Helper->sanitize($data['txt_color']) : $Form->txt_color = "";
      isset($data['bg_color']) && is_string($data['bg_color']) ? $Form->bg_color = $Helper->sanitize($data['bg_color']) : $Form->bg_color = "";
      isset($data['hover_txt']) && is_string($data['hover_txt']) ? $Form->hover_txt = $Helper->sanitize($data['hover_txt']) : $Form->hover_txt = "";
      isset($data['hover_color']) && is_string($data['hover_color']) ? $Form->hover_bg = $Helper->sanitize($data['hover_color']) : $Form->hover_bg = "";

      //Validate
      if(empty($Form->id)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      if(empty($Form->name)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(10);
        return $responseJson;
      }

      $Form->update_category();
      $status = true;
      $responseJson->status = $status;
      $responseJson->id = $Form->id;
      $responseJson->msg = $Form->apd_termine_error_msg(15);
      break;

  case'change_category_aktiv':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = '';
      //Validate
      if(empty($Form->id)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $cat = $Form->get_category_by_id();
      if($cat->aktiv ? $Form->aktiv = 0 : $Form->aktiv = 1);

      $Form->update_category_aktiv();
      $status = true;
      $responseJson->status = $status;
      $responseJson->id = $Form->id;
      $responseJson->msg = $Form->apd_termine_error_msg(15);
      break;

  case'set_eintrag':
      isset($data['content']) && is_string($data['content']) ? $Form->content = $Helper->sanitize($data['content']) : $Form->content = "";
      isset($data['time_von']) && is_string($data['time_von']) ? $Form->time_von = $Helper->sanitize($data['time_von']) : $Form->time_von = "";
      isset($data['time_bis']) && is_string($data['time_bis']) ? $Form->time_bis = $Helper->sanitize($data['time_bis']) : $Form->time_bis = "";
      isset($data['category']) && is_numeric($data['category']) ? $Form->cat_id = $Helper->sanitize($data['category']) : $Form->cat_id = "";
      isset($data['wochentag']) && is_numeric($data['wochentag']) ? $Form->day_id = $Helper->sanitize($data['wochentag']) : $Form->day_id = "";
      isset($data['group_id']) && is_numeric($data['group_id']) ? $Form->id = $Helper->sanitize($data['group_id']) : $Form->id = "";
      isset($data['aktiv']) && is_string($data['aktiv']) ? $Form->aktiv = 1 : $Form->aktiv = 0;
      isset($data['leer']) && is_string($data['leer']) ? $Form->leer = 1 : $Form->leer = 0;

      //Validate
      if(empty($Form->id)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      if(empty($Form->day_id)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(16);
        return $responseJson;
      }

      if(empty($Form->time_von)) {
        $responseJson->status = $status;
        $responseJson->msg =  $Form->apd_termine_error_msg(17);
        return $responseJson;
      }

      if(empty($Form->time_bis)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(18);
        return $responseJson;
      }

      if(empty($Form->content) && !$Form->leer) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(19);
        return $responseJson;
      }

      if(empty($Form->cat_id) && !$Form->leer) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(20);
        return $responseJson;
      }

      if($Form->leer) {
        $Form->cat_id = 0;
        $Form->content = $Form->apd_termine_error_msg(21);
      }

      $Form->position = 0;

      $insert = $Form->set_new_eintrag();
      if($insert['id']) {
        $responseJson->status = true;
        $responseJson->new_eintrag = true;
        $responseJson->msg = $Form->apd_termine_error_msg(22);
        $responseJson->id = $insert['id'];
        $responseJson->cat_id = $Form->cat_id;
        $responseJson->day_id = $Form->day_id;
        $responseJson->position = $Form->position;
        $responseJson->time_von = $Form->time_von;
        $responseJson->time_bis = $Form->time_bis;
        $responseJson->content = $Form->content;
        return $responseJson;
      }
      $responseJson->status = $status;
      $responseJson->msg = $Form->apd_termine_error_msg(23);
      break;

  case'sort_events':
      $i = 1;
      foreach($_POST['formData'] as $tmp) {
        if(!$tmp){
          continue;
        }
          $pos = stripos($tmp, '#');
          $id = substr($tmp,0,$pos);
          $Form->id = substr($id,10);
          $Form->position = $i;
          $Form->update_event_position();
        $i++;
      }
      break;

  case'change_event_aktiv':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = '';
      //Validate
      if(empty($Form->id)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $event = $Form->get_event_by_id();
      if($event->aktiv ? $Form->aktiv = 0 : $Form->aktiv = 1);

      $Form->update_event_aktiv();
      $status = true;
      $responseJson->status = $status;
      $responseJson->id = $Form->id;
      $responseJson->msg = $Form->apd_termine_error_msg(15);
      break;

  case'event_edit':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = '';
      isset($_POST['group_id']) && is_numeric($_POST['group_id']) ? $Form->group_id = $Helper->sanitize($_POST['group_id']) : $Form->group_id = '';
      //Validate
      if(empty($Form->id)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      if(empty($Form->group_id)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      for ($i=1; $i < 8 ; $i++) {
        $day_item[] = array(
          "id"=>$i,
          "day"=>select_get_weekdays($i)
        );
      }

      $getKategorie = $Form->get_category();
      $cat_arr = array();
      foreach($getKategorie as $tmp){
        $cat_item = array(
          "id"=>$tmp->id,
          'name'=>$tmp->name
        );
        array_push($cat_arr,$cat_item);
      }

      $lang_ajax = array(
        $Form->apd_termine_error_msg(100),
        $Form->apd_termine_error_msg(101),
        $Form->apd_termine_error_msg(102),
        $Form->apd_termine_error_msg(103),
        $Form->apd_termine_error_msg(104),
        $Form->apd_termine_error_msg(105),
        $Form->apd_termine_error_msg(106),
        $Form->apd_termine_error_msg(107),
        $Form->apd_termine_error_msg(108),
        $Form->apd_termine_error_msg(109),
        $Form->apd_termine_error_msg(110),
        $Form->apd_termine_error_msg(111)
      );

      $event = $Form->get_event_by_id();
      $responseJson->status = true;
      $responseJson->id = $Form->id;
      $responseJson->lang_files = $lang_ajax;
      $responseJson->group_id = $Form->group_id;
      $responseJson->record = $event;
      $responseJson->days = $day_item;
      $responseJson->categorys = $cat_arr;
      break;

  case'edit_eintrag':
      isset($data['id']) && is_numeric($data['id']) ? $Form->id = $Helper->sanitize($data['id']) : $Form->id = "";
      isset($data['group_id']) && is_numeric($data['group_id']) ? $Form->group_id = $Helper->sanitize($data['group_id']) : $Form->group_id = "";
      isset($data['content']) && is_string($data['content']) ? $Form->content = $Helper->sanitize($data['content']) : $Form->content = "";
      isset($data['time_von']) && is_string($data['time_von']) ? $Form->time_von = $Helper->sanitize($data['time_von']) : $Form->time_von = "";
      isset($data['time_bis']) && is_string($data['time_bis']) ? $Form->time_bis = $Helper->sanitize($data['time_bis']) : $Form->time_bis = "";
      isset($data['category']) && is_numeric($data['category']) ? $Form->cat_id = $Helper->sanitize($data['category']) : $Form->cat_id = "";
      isset($data['wochentag']) && is_numeric($data['wochentag']) ? $Form->day_id = $Helper->sanitize($data['wochentag']) : $Form->day_id = "";
      isset($data['leer']) && is_string($data['leer']) ? $leer = 1 : $leer = 0;

      //Validate
      if(empty($Form->id)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      if(empty($Form->group_id)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      if(empty($Form->day_id)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(16);
        return $responseJson;
      }

      if(empty($Form->time_von)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(17);
        return $responseJson;
      }

      if(empty($Form->time_bis)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(18);
        return $responseJson;
      }

      if(empty($Form->content) && !$leer) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(19);
        return $responseJson;
      }

      if(empty($Form->cat_id) && !$leer) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(20);
        return $responseJson;
      }

      if($leer) {
        $Form->cat_id = 0;
        $Form->content = $Form->apd_termine_error_msg(21);
      }

      $Form->update_event_edit();
      $responseJson->status = true;
      $responseJson->update_event = true;
      $responseJson->msg = $Form->apd_termine_error_msg(15);
      break;

  case'delete_event':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = "";
      //Validate
      if(empty($Form->id)) {
        $responseJson->status = $status;
        $responseJson->msg =  $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $Form->delete_event();
      $responseJson->status = true;
      $responseJson->id = $Form->id;
      $responseJson->msg = $Form->apd_termine_error_msg(24);
      break;

  case'edit_dropdown':
      isset($data['id']) && is_numeric($data['id']) ? $Form->id = $Helper->sanitize($data['id']) : $Form->id = "";
      isset($data['bg_color']) && is_string($data['bg_color']) ? $Form->bg_color = $Helper->sanitize($data['bg_color']) : $Form->bg_color = "";
      isset($data['txt_color']) && is_string($data['txt_color']) ? $Form->txt_color = $Helper->sanitize($data['txt_color']) : $Form->txt_color = "";
      isset($data['bg_hover_color']) && is_string($data['bg_hover_color']) ? $Form->bg_hover_color = $Helper->sanitize($data['bg_hover_color']) : $Form->bg_hover_color = "";
      isset($data['font_size']) && is_numeric($data['font_size']) ? $Form->font_size = $Helper->sanitize($data['font_size']) : $Form->font_size = "";
      isset($data['bezeichnung']) && is_string($data['bezeichnung']) ? $Form->name = $Helper->sanitize($data['bezeichnung']) : $Form->name = "";
      isset($data['drop_aktiv']) && is_string($data['drop_aktiv']) ? $Form->drop_aktiv = 1 : $Form->drop_aktiv = 0;
      isset($data['send_modal']) && is_numeric($data['send_modal']) ? $send_modal = true : $send_modal = false;
      //Validate
      if(empty($Form->id)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      if(empty($Form->bg_color) ? $Form->bg_color = '#CD7399' : $Form->bg_color = $Form->bg_color);
      if(empty($Form->txt_color) ? $Form->txt_color = '#FFFFFF' : $Form->txt_color = $Form->txt_color);
      if(empty($Form->bg_hover_color) ? $Form->bg_hover_color = '#FF0000' : $Form->bg_hover_color = $Form->bg_hover_color);
      if(empty($Form->font_size) ? $Form->font_size = 16 : $Form->font_size = $Form->font_size);
      if(empty($Form->name) ? $Form->name = 'Alle Termine' : $Form->name = $Form->name);

      $Form->update_dropdown_settings();
      $responseJson->status = true;
      $responseJson->dropdown_update = true;
      $responseJson->send_modal = $send_modal;
      $responseJson->msg = $Form->apd_termine_error_msg(3);
      break;

  case'add_group':
      isset($data['bezeichnung']) && is_string($data['bezeichnung']) ? $Form->name = $Helper->sanitize($data['bezeichnung']) : $Form->name = "";
      isset($data['sprache']) && is_numeric($data['sprache']) ? $Form->sprache = $Helper->sanitize($data['sprache']) : $Form->sprache = "";
      isset($data['settings']) && is_numeric($data['settings']) ? $Form->settings = $Helper->sanitize($data['settings']) : $Form->settings = "";
      isset($data['aktiv']) && is_string($data['aktiv']) ? $Form->aktiv = 1 : $Form->aktiv = 0;

      //Validate
      if(empty($Form->name)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(25);
        return $responseJson;
      }

      $group = $Form->get_group_by_name();
      if(!empty($group)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(4);
        return $responseJson;
      }
      if(empty($Form->sprache)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(26);
        return $responseJson;
      }
      if(empty($Form->settings)) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(27);
        return $responseJson;
      }

      $Form->shortcode = $Helper->random_string();

      $insert = $Form->set_group();
      if($insert['id']){
        $Form->id = $Form->settings;
        $settings = $Form->get_settings_by_id();
        $Form->id = $Form->sprache;
        $lang = $Form->get_weekdays_by_id();
        $responseJson->status = true;
        $responseJson->add_group = true;
        $responseJson->id = $insert['id'];
        $responseJson->shortcode = $Form->shortcode;
        $responseJson->name = $Form->name;
        $responseJson->lang_id = $Form->sprache;
        $responseJson->lang_name = $lang->sprache;
        $responseJson->sett_id = $Form->settings;
        $responseJson->sett_name = $settings->name;
        $responseJson->aktiv = $Form->aktiv;
        $responseJson->msg = $Form->apd_termine_error_msg(28);
        return $responseJson;
      }
      $responseJson->status = $status;
      $responseJson->msg = $Form->apd_termine_error_msg(29);
      break;

  case'update_group_settings':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = "";
      isset($_POST['type']) && is_numeric($_POST['type']) ? $type = $Helper->sanitize($_POST['type']) : $type = "";
      isset($_POST['eintrag']) && is_string($_POST['eintrag']) ? $Form->name = $Helper->sanitize($_POST['eintrag']) : $Form->name = "";
      //Validate
      if(empty($Form->id)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }
      if(empty($Form->name)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(30);
        return $responseJson;
      }
      if(empty($type)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $group = $Form->get_group_by_id();
      switch($type){
        case '1':
          if($group->bezeichnung != $Form->name){
            $group_name = $Form->get_group_by_name();
            if(!empty($group_name)){
              $responseJson->status = $status;
              $responseJson->msg = $Form->apd_termine_error_msg(4);
              return $responseJson;
            }
          }
          $Form->value = 'bezeichnung';
          $Form->val_type = '%s';
          $Form->change_group_value();
          $responseJson->status = true;
          $responseJson->msg = $Form->apd_termine_error_msg(15);
          return $responseJson;
          break;
        case'2':
          $Form->value = 'lang_id';
          $Form->val_type = '%d';
          $Form->change_group_value();
          $responseJson->status = true;
          $responseJson->msg = $Form->apd_termine_error_msg(15);
          return $responseJson;
          break;
        case'3':
          $Form->value = 'sett_id';
          $Form->val_type = '%d';
          $Form->change_group_value();
          $responseJson->status = true;
          $responseJson->msg = $Form->apd_termine_error_msg(15);
          return $responseJson;
          break;
      }
      break;

  case'change_group_aktiv':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = "";

      if(empty($Form->id)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $group = $Form->get_group_by_id();
      if($group->aktiv ? $Form->aktiv = 0 : $Form->aktiv = 1);

      $Form->change_group_aktiv();

      $responseJson->status = true;
      $responseJson->msg = $Form->apd_termine_error_msg(31);
      break;

  case'delete_group':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $id = $Helper->sanitize($_POST['id']) : $id = "";

      if(empty($id)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $Form->id = $id;
      $events = $Form->get_events_by_group_id();
      foreach($events as $tmp){
        $Form->id = $tmp->id;
        $Form->delete_event();
      }

      $Form->id = $id;
      $Form->delete_group();

      $responseJson->status = true;
      $responseJson->id = $Form->id;
      $responseJson->msg = $Form->apd_termine_error_msg(32);
      break;

  case'change_leer_aktiv':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = "";

      if(empty($Form->id)){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $event = $Form->get_event_by_id();
      $event->leer ? $Form->leer = 0 : $Form->leer = 1;
      $Form->update_event_leer();
      $load_event = $Form->get_event_by_id();

      if($load_event->leer){
        $responseJson->status = true;
        $responseJson->cat_aktiv = false;
        $responseJson->id = $Form->id;
      } else {
        $responseJson->status = true;
        $responseJson->cat_aktiv = true;
        $responseJson->id = $Form->id;
      }
      break;

  case'if_matabox_post':
        isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = "";

        if(!$Form->id){
          $responseJson->status = $status;
          $responseJson->msg = $Form->apd_termine_error_msg(33);
          return $responseJson;
        }

        $responseJson->status = $status;
        $responseJson->test = $Form->id;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        break;

  case'delete_seite':
        isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = "";

        if(!$Form->id){
          $responseJson->status = $status;
          $responseJson->msg = $Form->apd_termine_error_msg(33);
          return $responseJson;
        }
        $cat = $Form->get_category_by_id();
        wp_delete_post($cat->post_id, true);
        $Form->post_site = 0;
        $Form->post_id = 0;
        $Form->update_category_post();
        $responseJson->status = true;
        $responseJson->id = $Form->id;
        $responseJson->name = $cat->name;
        $responseJson->msg = $Form->apd_termine_error_msg(34);
        break;

  case 'update_kategorie_status':

      $args = array(
        'post_type'=>'apd-termin-plan'
      );
      //Fehlende Einträge aus DB löschen
      $custom_posts = get_posts($args);

      foreach($custom_posts as $tmp) {
      $db_post_category = $form->get_category();
         foreach($db_post_category as $val){
           if($val->post_id != $tmp->ID){
             $Form->id = $val->id;
             $Form->update_category_post_status();
           }
         }
      }
      break;
  case'get_modal_settings':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = "";

      if(!$Form->id) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $settings = $Form->get_settings_by_id();
      if(!$settings){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(35);
        return $responseJson;
      }

      $select = array('50%','60%','70%','80%','90%','100%');
      foreach ($select as $tmp) {
        if($tmp == $settings->container_widht){
          $sel = ' selected';
        }else{
          $sel = '';
        }
        $selected .= '<option value="'.$tmp.'"'.$sel.'>'.$tmp.'</option>';
      }
      if($settings->auto_resize ? $aktiv = true : $aktiv = false);


      $responseJson->status = true;
      $responseJson->name = $settings->name;
      $responseJson->cont_widht = $selected;
      $responseJson->resize_aktiv = $aktiv;
      $responseJson->margin_top = $settings->margin_top;
      $responseJson->margin_bottom = $settings->margin_bottom;
      $responseJson->margin_left = $settings->margin_left;
      $responseJson->margin_right = $settings->margin_right;
      $responseJson->padding_left = $settings->padding_left;
      $responseJson->padding_right = $settings->padding_right;
      $responseJson->padding_top = $settings->padding_top;
      $responseJson->padding_bottom = $settings->padding_bottom;
      $responseJson->id = $settings->id;
      break;

  case'get_drop_modal_settings':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $Form->id = $Helper->sanitize($_POST['id']) : $Form->id = "";

      if(!$Form->id) {
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $settings = $Form->get_settings_by_id();
      if($settings->drop_aktiv ? $aktiv = true : $aktiv = false);
      $responseJson->status = true;
      $responseJson->id = $settings->id;
      $responseJson->drop_bg = $settings->drop_bg;
      $responseJson->drop_hover_bg = $settings->drop_hover_bg;
      $responseJson->drop_txt = $settings->drop_txt;
      $responseJson->drop_txt_size = $settings->drop_txt_size;
      $responseJson->drop_bezeichnung = $settings->drop_bezeichnung;
      $responseJson->drop_aktiv = $aktiv;
      break;

  case'load_language':
      isset($_POST['id']) && is_numeric($_POST['id']) ? $id = $Helper->sanitize($_POST['id']) : $id = "";
      isset($_POST['msg_id']) && is_numeric($_POST['msg_id']) ? $msg_id = $Helper->sanitize($_POST['msg_id']) : $msg_id = "";

      switch($msg_id){
      case'1':
        $record_msg = array(
          $Form->apd_termine_error_msg(200),
          $Form->apd_termine_error_msg(201),
          $Form->apd_termine_error_msg(202),
          $Form->apd_termine_error_msg(108));
        break;
        case'2':
          $record_msg = array(
            $Form->apd_termine_error_msg(203),
            $Form->apd_termine_error_msg(204),
            $Form->apd_termine_error_msg(205),
            $Form->apd_termine_error_msg(108));
        break;
        case'3':
          $record_msg = array(
            $Form->apd_termine_error_msg(206),
            $Form->apd_termine_error_msg(204),
            $Form->apd_termine_error_msg(207),
            $Form->apd_termine_error_msg(108));
          break;
          case'4':
            $record_msg = array(
              $Form->apd_termine_error_msg(208),
              $Form->apd_termine_error_msg(204),
              $Form->apd_termine_error_msg(209),
              $Form->apd_termine_error_msg(108));
          break;
          case'5':
            $record_msg = array(
              $Form->apd_termine_error_msg(210),
              $Form->apd_termine_error_msg(211),
              $Form->apd_termine_error_msg(212),
              $Form->apd_termine_error_msg(108));
          break;
          case'6':
            $record_msg = array(
              $Form->apd_termine_error_msg(213),
              $Form->apd_termine_error_msg(214),
              $Form->apd_termine_error_msg(215),
              $Form->apd_termine_error_msg(108));
            break;
      }
        $responseJson->status = true;
        $responseJson->id = $id;
        $responseJson->sprache = $record_msg;
      break;

  case'update_cont_settings':
      isset($data['id']) && is_numeric($data['id']) ? $Form->id = $Helper->sanitize($data['id']) : $Form->id = "";
      isset($data['cont_widht']) && is_string($data['cont_widht']) ? $Form->cont_width = $Helper->sanitize($data['cont_widht']) : $Form->cont_width = "100%";
      isset($data['margin_top']) && is_string($data['margin_top']) ? $Form->margin_top = $Helper->sanitize($data['margin_top']) : $Form->margin_top = "0px";
      isset($data['margin_bottom']) && is_string($data['margin_bottom']) ? $Form->margin_bottom = $Helper->sanitize($data['margin_bottom']) : $Form->margin_bottom = "0px";
      isset($data['margin_left']) && is_string($data['margin_left']) ? $Form->margin_left = $Helper->sanitize($data['margin_left']) : $Form->margin_left = "auto";
      isset($data['margin_right']) && is_string($data['margin_right']) ? $Form->margin_right = $Helper->sanitize($data['margin_right']) : $Form->margin_right = "auto";
      isset($data['padding_top']) && is_string($data['padding_top']) ? $Form->padding_top = $Helper->sanitize($data['padding_top']) : $Form->padding_top = "15px";
      isset($data['padding_bottom']) && is_string($data['padding_bottom']) ? $Form->padding_bottom = $Helper->sanitize($data['padding_bottom']) : $Form->padding_bottom = "15px";
      isset($data['padding_left']) && is_string($data['padding_left']) ? $Form->padding_left = $Helper->sanitize($data['padding_left']) : $Form->padding_left = "25px";
      isset($data['padding_right']) && is_string($data['padding_right']) ? $Form->padding_right = $Helper->sanitize($data['padding_right']) : $Form->padding_right = "25px";
      isset($data['auto_aktiv']) && is_string($data['auto_aktiv']) ? $Form->auto_resize = 1 : $Form->auto_resize = 0;

      if(!$Form->id){
        $responseJson->status = $status;
        $responseJson->msg = $Form->apd_termine_error_msg(1);
        return $responseJson;
      }

      $Form->update_container_settings();
      $responseJson->status = true;
      $responseJson->id = $Form->id;
      $responseJson->update_cont = true;
      $responseJson->msg = $Form->apd_termine_error_msg(31);
      break;

  case'load_demo_plan':

      $random_str = $Helper->random_string();
      $Form->shortcode = $Helper->random_string();
      $Form->aktiv = 1;


      //Wochentage Erstellen
      $Form->lang_sprache = $random_str;
      $Form->montag = "Monday";
      $Form->dienstag = "Tuesday";
      $Form->mittwoch = "Wednesday";
      $Form->donnerstag = "Thursday";
      $Form->freitag = "Friday";
      $Form->samstag = "Saturday";
      $Form->sonntag = "Sunday";
      //Insert Weekdays
      $insert_lang = $Form->set_weekdays();
      //lang ID
      $Form->lang_id = $insert_lang['id'];

      //Demo Settings erstellen
      $Form->name = 'demo_'.$random_str;
      $Form->bg_color = '#d3d3d3';
      $Form->bg_txt = '#6a6a6a';
      $Form->bg_leer = '#d3d3d3';
      $Form->min_height = 160;
      $Form->week_size = 16;
      $Form->time_size = 15;
      $Form->content_size = 16;

      //DEfault Werte
      $Form->drop_bg = '#939393';
      $Form->drop_txt = '#FFFFFF';
      $Form->drop_hover_bg = '#426477';
      $Form->drop_txt_size = 16;
      $Form->drop_bezeichnung = 'Demo Termine';
      $Form->drop_aktiv = 1;

      $Form->cont_width = '80%';
      $Form->padding_top = '15px';
      $Form->padding_bottom = '15px';
      $Form->padding_left = '25px';
      $Form->padding_right = '25px';
      $Form->margin_top = '0px';
      $Form->margin_bottom = '0px';
      $Form->margin_left = 'auto';
      $Form->margin_right = 'auto';
      //Insert Settings
      $insert_settings = $Form->set_settings();
      //sett ID
      $Form->sett_id = $insert_settings['id'];

      $Form->sprache = $Form->lang_id;
      $Form->settings = $Form->sett_id;
      //Insert Group
      $insert_group = $Form->set_group();
      //Group ID
      $Form->group_id = $insert_group['id'];

      //Kategorien erstellen
      $bezeichnung = array('#946474', '#D68B74', '#945994', '#A96D6F', '#6A6174', '#57639F', '#44859E',
        '#5A779F', '#6AA0A2', '#A85E93', '#A8665E', '#535F85', '#BC7070', '#A17AA0' );

      for ($i=0; $i < 14 ; $i++) {

        $Form->txt_color = "#FFFFFF";
        $Form->name = $Form->apd_termine_error_msg(115).' '.$Form->apd_termine_error_msg(114).': '.substr($Helper->random_string(),0,3);
        $Form->bg_color = $bezeichnung[$i];
        $Form->hover_txt = "#FFFFFF";
        $Form->hover_bg = "#6F3249";

        $insert_category = $Form->set_category();
        $insert_cat_id[] = $insert_category['id'];
      }

      $montag_arr = array(
        array(
          "time_von"=>'09:00',
          "time_bis"=>'10:00',
          "content" => 'Bauch, Pein, Po',
          "position" => 1,
          "day_id" => 1,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[0],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'10:00',
          "time_bis"=>'11:00',
          "content" => 'Core Work',
          "position" => 2,
          "day_id" => 1,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[2],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'12:00',
          "time_bis"=>'13:00',
          "content" => 'Rückenfit',
          "position" => 3,
          "day_id" => 1,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[10],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'14:00',
          "time_bis"=>'15:00',
          "content" => 'Stretching',
          "position" => 4,
          "day_id" => 1,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[11],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'17:00',
          "time_bis"=>'18:00',
          "content" => 'Pilates',
          "position" => 5,
          "day_id" => 1,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[9],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'18:30',
          "time_bis"=>'20:00',
          "content" => 'the workout',
          "position" => 6,
          "day_id" => 1,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[12],
          "leer"=> 0,
          "aktiv"=>1
        )
      );

      foreach($montag_arr as $tmp){
        if($tmp['leer']) {
          $Form->cat_id = '99999';
        }else{
          $Form->cat_id = $tmp['cat_id'];
        }
        $Form->leer = $tmp['leer'];
        $Form->day_id = $tmp['day_id'];
        $Form->position = $tmp['position'];
        $Form->content = $tmp['content'];
        $Form->time_von = $tmp['time_von'];
        $Form->time_bis = $tmp['time_bis'];
        $insert_event_id[] = $Form->set_event();
      }

      $dienstag_arr = array(
        array(
          "time_von"=>'09:00',
          "time_bis"=>'10:00',
          "content" => 'Total Body Workout',
          "position" => 1,
          "day_id" => 2,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[13],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'10:00',
          "time_bis"=>'11:00',
          "content" => 'Gesundheitssport',
          "position" => 2,
          "day_id" => 2,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[6],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'12:00',
          "time_bis"=>'13:00',
          "content" => 'KamiBo',
          "position" => 3,
          "day_id" => 2,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[7],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'14:00',
          "time_bis"=>'15:00',
          "content" => 'Functional Muscle Fitness',
          "position" => 4,
          "day_id" => 2,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[5],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'17:00',
          "time_bis"=>'18:00',
          "content" => 'Kindersport',
          "position" => 5,
          "day_id" => 2,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[8],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'18:30',
          "time_bis"=>'20:00',
          "content" => 'Body Pump',
          "position" => 6,
          "day_id" => 2,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[1],
          "leer"=> 0,
          "aktiv"=>1
        )
      );

      foreach($dienstag_arr as $tmp){
        if($tmp['leer']) {
          $Form->cat_id = '99999';
        }else{
          $Form->cat_id = $tmp['cat_id'];
        }
        $Form->leer = $tmp['leer'];
        $Form->day_id = $tmp['day_id'];
        $Form->position = $tmp['position'];
        $Form->content = $tmp['content'];
        $Form->time_von = $tmp['time_von'];
        $Form->time_bis = $tmp['time_bis'];
        $insert_event_id[] = $Form->set_event();
      }

      $mittwoch_arr = array(
        array(
          "time_von"=>'09:00',
          "time_bis"=>'10:00',
          "content" => 'Rückenfit',
          "position" => 1,
          "day_id" => 3,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[10],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'10:00',
          "time_bis"=>'11:00',
          "content" => 'Stretching',
          "position" => 2,
          "day_id" => 3,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[11],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'12:00',
          "time_bis"=>'13:00',
          "content" => 'FatAttack',
          "position" => 3,
          "day_id" => 3,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[4],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'14:00',
          "time_bis"=>'15:00',
          "content" => 'Bauch, Beine, Po',
          "position" => 4,
          "day_id" => 3,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[0],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'17:00',
          "time_bis"=>'18:00',
          "content" => 'Dance',
          "position" => 5,
          "day_id" => 3,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[3],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'18:30',
          "time_bis"=>'20:00',
          "content" => 'Functional Muscle Fitness',
          "position" => 6,
          "day_id" => 3,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[5],
          "leer"=> 0,
          "aktiv"=>1
        )
      );

      foreach($mittwoch_arr as $tmp){
        if($tmp['leer']) {
          $Form->cat_id = '99999';
        }else{
          $Form->cat_id = $tmp['cat_id'];
        }
        $Form->leer = $tmp['leer'];
        $Form->day_id = $tmp['day_id'];
        $Form->position = $tmp['position'];
        $Form->content = $tmp['content'];
        $Form->time_von = $tmp['time_von'];
        $Form->time_bis = $tmp['time_bis'];
        $insert_event_id[] = $Form->set_event();
      }

      $donnerstag_arr = array(
        array(
          "time_von"=>'09:00',
          "time_bis"=>'10:00',
          "content" => 'Bauch, Beine, Po',
          "position" => 1,
          "day_id" => 4,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[0],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'10:00',
          "time_bis"=>'11:00',
          "content" => 'Gesundheitssport',
          "position" => 2,
          "day_id" => 4,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[6],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'12:00',
          "time_bis"=>'13:00',
          "content" => 'Rückenfit',
          "position" => 3,
          "day_id" => 4,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[10],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'14:00',
          "time_bis"=>'15:00',
          "content" => 'KamiBo',
          "position" => 4,
          "day_id" => 4,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[7],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'17:00',
          "time_bis"=>'18:00',
          "content" => 'Kindersport',
          "position" => 5,
          "day_id" => 4,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[8],
          "leer"=> 0,
          "aktiv"=>1
        ),
        array(
          "time_von"=>'18:30',
          "time_bis"=>'20:00',
          "content" => 'Body Pump',
          "position" => 6,
          "day_id" => 4,
          "group_id" => $Form->group_id,
          "cat_id" => $insert_cat_id[1],
          "leer"=> 0,
          "aktiv"=>1
        )
      );

      foreach($donnerstag_arr as $tmp){
        if($tmp['leer']) {
          $Form->cat_id = '99999';
        }else{
          $Form->cat_id = $tmp['cat_id'];
        }
        $Form->leer = $tmp['leer'];
        $Form->day_id = $tmp['day_id'];
        $Form->position = $tmp['position'];
        $Form->content = $tmp['content'];
        $Form->time_von = $tmp['time_von'];
        $Form->time_bis = $tmp['time_bis'];
        $insert_event_id[] = $Form->set_event();
      }

            $freitag_arr = array(
              array(
                "time_von"=>'09:00',
                "time_bis"=>'10:00',
                "content" => 'FatAttack',
                "position" => 1,
                "day_id" => 5,
                "group_id" => $Form->group_id,
                "cat_id" => $insert_cat_id[4],
                "leer"=> 0,
                "aktiv"=>1
              ),
              array(
                "time_von"=>'10:00',
                "time_bis"=>'11:00',
                "content" => 'Core Work',
                "position" => 2,
                "day_id" => 5,
                "group_id" => $Form->group_id,
                "cat_id" => $insert_cat_id[2],
                "leer"=> 0,
                "aktiv"=>1
              ),
              array(
                "time_von"=>'12:00',
                "time_bis"=>'13:00',
                "content" => 'Dance',
                "position" => 3,
                "day_id" => 5,
                "group_id" => $Form->group_id,
                "cat_id" => $insert_cat_id[3],
                "leer"=> 0,
                "aktiv"=>1
              ),
              array(
                "time_von"=>'14:00',
                "time_bis"=>'15:00',
                "content" => 'Stretching',
                "position" => 4,
                "day_id" => 5,
                "group_id" => $Form->group_id,
                "cat_id" => $insert_cat_id[11],
                "leer"=> 0,
                "aktiv"=>1
              ),
              array(
                "time_von"=>'17:00',
                "time_bis"=>'18:00',
                "content" => 'Pilates',
                "position" => 5,
                "day_id" => 5,
                "group_id" => $Form->group_id,
                "cat_id" => $insert_cat_id[9],
                "leer"=> 0,
                "aktiv"=>1
              ),
              array(
                "time_von"=>'18:30',
                "time_bis"=>'20:00',
                "content" => 'Functional Muscle Fitness',
                "position" => 6,
                "day_id" => 5,
                "group_id" => $Form->group_id,
                "cat_id" => $insert_cat_id[5],
                "leer"=> 0,
                "aktiv"=>1
              )
            );

            foreach($freitag_arr as $tmp){
              if($tmp['leer']) {
                $Form->cat_id = '99999';
              }else{
                $Form->cat_id = $tmp['cat_id'];
              }
              $Form->leer = $tmp['leer'];
              $Form->day_id = $tmp['day_id'];
              $Form->position = $tmp['position'];
              $Form->content = $tmp['content'];
              $Form->time_von = $tmp['time_von'];
              $Form->time_bis = $tmp['time_bis'];
              $insert_event_id[] = $Form->set_event();
            }

                  $samstag_arr = array(
                    array(
                      "time_von"=>'09:00',
                      "time_bis"=>'10:00',
                      "content" => 'leerer Eintrag',
                      "position" => 1,
                      "day_id" => 6,
                      "group_id" => $Form->group_id,
                      "cat_id" => 99999,
                      "leer"=> 1,
                      "aktiv"=>1
                    ),
                    array(
                      "time_von"=>'10:00',
                      "time_bis"=>'11:00',
                      "content" => 'Body Pump',
                      "position" => 2,
                      "day_id" => 6,
                      "group_id" => $Form->group_id,
                      "cat_id" => $insert_cat_id[1],
                      "leer"=> 0,
                      "aktiv"=>1
                    ),
                    array(
                      "time_von"=>'12:00',
                      "time_bis"=>'13:00',
                      "content" => 'FatAttack',
                      "position" => 3,
                      "day_id" => 6,
                      "group_id" => $Form->group_id,
                      "cat_id" => $insert_cat_id[4],
                      "leer"=> 0,
                      "aktiv"=>1
                    ),
                    array(
                      "time_von"=>'14:00',
                      "time_bis"=>'15:00',
                      "content" => 'Total Body Workout',
                      "position" => 4,
                      "day_id" => 6,
                      "group_id" => $Form->group_id,
                      "cat_id" => $insert_cat_id[13],
                      "leer"=> 0,
                      "aktiv"=>1
                    ),
                    array(
                      "time_von"=>'17:00',
                      "time_bis"=>'18:00',
                      "content" => 'leerer Eintrag',
                      "position" => 5,
                      "day_id" => 6,
                      "group_id" => $Form->group_id,
                      "cat_id" => 99999,
                      "leer"=> 1,
                      "aktiv"=>1
                    ),
                    array(
                      "time_von"=>'18:30',
                      "time_bis"=>'20:00',
                      "content" => 'leerer Eintrag',
                      "position" => 6,
                      "day_id" => 6,
                      "group_id" => $Form->group_id,
                      "cat_id" => 99999,
                      "leer"=> 1,
                      "aktiv"=>1
                    )
                  );

                  foreach($samstag_arr as $tmp){
                    if($tmp['leer']) {
                      $Form->cat_id = '99999';
                    }else{
                      $Form->cat_id = $tmp['cat_id'];
                    }
                    $Form->leer = $tmp['leer'];
                    $Form->day_id = $tmp['day_id'];
                    $Form->position = $tmp['position'];
                    $Form->content = $tmp['content'];
                    $Form->time_von = $tmp['time_von'];
                    $Form->time_bis = $tmp['time_bis'];
                    $insert_event_id[] = $Form->set_event();
                  }

                  $sonntag_arr = array(
                    array(
                      "time_von"=>'09:00',
                      "time_bis"=>'10:00',
                      "content" => 'leerer Eintrag',
                      "position" => 1,
                      "day_id" => 7,
                      "group_id" => $Form->group_id,
                      "cat_id" => 99999,
                      "leer"=> 1,
                      "aktiv"=>1
                    ),
                    array(
                      "time_von"=>'10:00',
                      "time_bis"=>'11:00',
                      "content" => 'Body Pump',
                      "position" => 2,
                      "day_id" => 7,
                      "group_id" => $Form->group_id,
                      "cat_id" => $insert_cat_id[1],
                      "leer"=> 0,
                      "aktiv"=>1
                    ),
                    array(
                      "time_von"=>'12:00',
                      "time_bis"=>'13:00',
                      "content" => 'Bauch, Beine, Po',
                      "position" => 3,
                      "day_id" => 7,
                      "group_id" => $Form->group_id,
                      "cat_id" => $insert_cat_id[0],
                      "leer"=> 0,
                      "aktiv"=>1
                    ),
                    array(
                      "time_von"=>'14:00',
                      "time_bis"=>'15:00',
                      "content" => 'Stretching',
                      "position" => 4,
                      "day_id" => 7,
                      "group_id" => $Form->group_id,
                      "cat_id" => $insert_cat_id[11],
                      "leer"=> 0,
                      "aktiv"=>1
                    ),
                    array(
                      "time_von"=>'17:00',
                      "time_bis"=>'18:00',
                      "content" => 'leerer Eintrag',
                      "position" => 5,
                      "day_id" => 7,
                      "group_id" => $Form->group_id,
                      "cat_id" => 99999,
                      "leer"=> 1,
                      "aktiv"=>1
                    ),
                    array(
                      "time_von"=>'18:30',
                      "time_bis"=>'20:00',
                      "content" => 'leerer Eintrag',
                      "position" => 6,
                      "day_id" => 7,
                      "group_id" => $Form->group_id,
                      "cat_id" => 99999,
                      "leer"=> 1,
                      "aktiv"=>1
                    )
                  );
        foreach($sonntag_arr as $tmp){
          if($tmp['leer']) {
            $Form->cat_id = '99999';
          }else{
            $Form->cat_id = $tmp['cat_id'];
          }
          $Form->leer = $tmp['leer'];
          $Form->day_id = $tmp['day_id'];
          $Form->position = $tmp['position'];
          $Form->content = $tmp['content'];
          $Form->time_von = $tmp['time_von'];
          $Form->time_bis = $tmp['time_bis'];
          $insert_event_id[] = $Form->set_event();
        }

      $responseJson->status = true;
      $responseJson->load_demo = true;
      $responseJson->msg = $Form->apd_termine_error_msg(36);
      break;


  }//endSwitch


  function select_get_weekdays($id)
  {
    switch($id) {
      case'1':
        $row = 'Montag';
        break;
      case'2':
        $row = 'Dienstag';
        break;
      case'3':
        $row = 'Mittwoch';
        break;
      case'4':
        $row = 'Donnerstag';
        break;
      case'5':
        $row = 'Freitag';
        break;
      case'6':
        $row = 'Samstag';
        break;
      case'7':
        $row = 'Sonntag';
        break;
     }//endSwitch
     return $row;
  }

  function update_post_status()
  {
    $args = array(
      'post_type'=>'apd-termin-plan'
    );
    //Fehlende Einträge aus DB löschen
    $custom_posts = get_posts($args);

    foreach($custom_posts as $tmp) {
    $db_post_category = $form->get_category();
       foreach($db_post_category as $val){
         if($val->post_id != $tmp->ID){
           $Form->id = $val->id;
           $Form->update_category_post_status();
         }
       }
    }
  }
