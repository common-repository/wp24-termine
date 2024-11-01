<?php
namespace APD\ArtDesign;
/**
 * ArtPictureDesign PHP Class
 * @package Art-Picture Design Plugin
 * Copyright 2020, Jens Wiecker
 * License: Commercial - goto https://art-picturedesign.de
 * https://art-picturedesign.de/webdesign
 *
 */
defined('ABSPATH')or die();
class TerminPluginDB
{
    //Tables
    private $table_settings = 'apd_settings';
    private $table_weekdays = 'apd_weekdays';
    private $table_category = 'apd_category';
    private $table_termin = 'apd_termin';
    private $table_groups = 'apd_group';

    private $day;
    public $id;
    public $lang_id;
    public $group_id;
    public $aktiv;

    public function get_settings_by_group_id()
    {
        global $wpdb;
        $group = $this->get_group_by_id();
        $id = $group->sett_id;
        $table = $wpdb->prefix . $this->table_settings;
        $row = $wpdb->get_row("SELECT *
        FROM {$table}
        WHERE id = {$id} ");
        return $row;
    }

    public function get_settings_by_id()
    {
      global $wpdb;
      $table = $wpdb->prefix . $this->table_settings;
      $row = $wpdb->get_row("SELECT *
      FROM {$table}
      WHERE id = {$this->id} ");
      return $row;
    }

    public function get_settings()
    {
        $this->update_post_status();
        global $wpdb;
        $table = $wpdb->prefix . $this->table_settings;
        $row = $wpdb->get_results("SELECT *
        FROM {$table} ");
        return $row;
    }

    public function get_sprach_settings()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_weekdays;
        $row = $wpdb->get_results("SELECT *
        FROM {$table} ");
        return $row;
    }

    public function get_category()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_category;
        $row = $wpdb->get_results("SELECT *
      FROM {$table} ORDER BY name ASC ");
        return $row;
    }

    public function get_events()
    {
        $send_arr = array();
        for ($i=1; $i < 8 ; $i++) {
            $this->id = $i;
            $event = $this->get_event_by_day_id();
            $event_arr[] = array(
          "event"=>$event,
          "day"=>$this->get_event_lang()
        );
        }
        return $event_arr;
    }

    public function get_events_by_group_id()
    {
        $send_arr = array();
        $group = $this->get_group_by_id();
        $this->lang_id = $group->lang_id;

        for ($i=1; $i < 8 ; $i++) {
            $this->id = $i;
            $event = $this->get_event_by_group_day_id();
            if (!$event) {
                $day_status = false;
            } else {
                $day_status = true;
            }
            $event_arr[] = array(
          "event"=>$event,
          "day"=>$this->get_event_lang(),
          "day_status"=>$day_status
        );
        }
        return $event_arr;
    }

    public function get_groups()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_groups;
        $table_settings = $wpdb->prefix . $this->table_settings;
        $table_weekdays = $wpdb->prefix . $this->table_weekdays;
        $row = $wpdb->get_results("SELECT $table.*,
      $table_settings.name as settings_name,
      $table_weekdays.sprache as lang_name
      FROM {$table}
      LEFT JOIN {$table_settings} ON {$table}.sett_id = {$table_settings}.id
      LEFT JOIN {$table_weekdays} ON {$table}.lang_id = {$table_weekdays}.id
      ");
        return $row;
    }

    public function get_add_groups()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_settings;
        $row = $wpdb->get_results("SELECT *
      FROM {$table}
      ");
        $sprache = $this->get_sprach_settings();
        $record = new \stdClass();
        $record->settings = $row;
        $record->lang = $sprache;
        return $record;
    }

    public function get_public_events()
    {
        $record = new \stdClass();
        //EVENTS UND TAGE
        $send_arr = array();
        for ($i=1; $i < 8 ; $i++) {
            $this->id = $i;
            $event = $this->get_public_event_by_day_id();
            $event_arr[] = array(
          "event"=>$event,
          "day"=>$this->get_event_lang()
        );
        }

        //Kategorien
        $record->settings = $this->get_termine_settings();
        $record->category = $this->get_category();
        $record->events = $event_arr;
        return $record;
    }

    public function get_kategorie_non_post_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_category;
        $row = $wpdb->get_results("SELECT *
      FROM {$table}
       WHERE post_site = 0 ");
        return $row;
    }

    public function get_kategorie_seiten()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_category;
        $args = array(
         'post_type'   => 'apd-termin-plan'
        );
        $kat_sites = new \WP_Query($args);
        $rec_arr = array();
        foreach ($kat_sites->posts as $tmp) {
            $cat_id =  get_post_meta($tmp->ID, '_categorie', true);
            $kategorie = $wpdb->get_row("SELECT *
        FROM {$table}
         WHERE id = {$cat_id} ");
            $date = new \DateTime($tmp->post_date);
            $datum = $date->format('d.m.Y');
            $datum2 = $date->format('dmYHis');
            $rec_item = array(
          "post_id" => $tmp->ID,
          "post_title" => $tmp->post_title,
          "post_name" => $tmp->post_name,
          "post_status" => $tmp->post_status,
          "comment_status"=>$tmp->comment_status,
          "post_type" => $tmp->post_type,
          "datum" => $datum,
          "datum2" => $datum2,
          "cat_id" => $cat_id,
          "cat_name" => $kategorie->name
        );
            array_push($rec_arr, $rec_item);
        }
        return $rec_arr;
    }

    private function get_event_by_day_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $cat_table = $wpdb->prefix . $this->table_category;
        $row = $wpdb->get_results("SELECT {$table}.*,
      {$cat_table}.name as cat_name, {$cat_table}.bg_color, {$cat_table}.txt_color, {$cat_table}.hover_color,{$cat_table}.hover_txt_color
      FROM {$table}
      LEFT JOIN {$cat_table} ON {$table}.cat_id = {$cat_table}.id
      WHERE {$table}.day_id = {$this->id} ORDER BY {$table}.position ASC ");
        return $row;
    }

    private function get_event_by_group_day_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $cat_table = $wpdb->prefix . $this->table_category;
        $groups_table = $wpdb->prefix . $this->table_groups;
        $row = $wpdb->get_results("SELECT {$table}.*,
      {$cat_table}.name as cat_name, {$cat_table}.bg_color, {$cat_table}.txt_color, {$cat_table}.hover_color,{$cat_table}.hover_txt_color
      FROM {$table}
      LEFT JOIN {$cat_table} ON {$table}.cat_id = {$cat_table}.id
      WHERE {$table}.group_id = {$this->group_id} AND {$table}.day_id = {$this->id} ORDER BY {$table}.position ASC ");
        return $row;
    }

    private function get_public_event_by_day_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $cat_table = $wpdb->prefix . $this->table_category;
        $row = $wpdb->get_results("SELECT {$table}.*,
      {$cat_table}.name as cat_name, {$cat_table}.bg_color, {$cat_table}.txt_color, {$cat_table}.hover_color,{$cat_table}.hover_txt_color
      FROM {$table}
      LEFT JOIN {$cat_table} ON {$table}.cat_id = {$cat_table}.id
      WHERE {$table}.aktiv = 1 AND {$table}.day_id = {$this->id} ORDER BY {$table}.position ASC ");
        return $row;
    }

    private function get_group_by_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_groups;
        $row = $wpdb->get_row("SELECT {$table}.*
      FROM {$table}
      WHERE {$table}.id = $this->group_id ");
        return $row;
    }

    private function get_termine_settings()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_settings;
        $row = $wpdb->get_row("SELECT {$table}.*
      FROM {$table}
      WHERE {$table}.aktiv = 1 ");
        return $row;
    }

    private function update_post_status()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_category;
        $db_post_category = $wpdb->get_results("SELECT * FROM {$table} ");
        foreach ($db_post_category as $val) {
            if (strpos($val->post_name,"__trashed")) {
                $wpdb->update(
                        $table,
                        array(
                    'post_site' => 0,
                    'post_id' => 0,
                    'post_name'=>null,
                    'post_title'=>null
                    ),
                        array( 'id' => $val->id),
                        array( '%d','%d','%s','%s'),
                        array( '%d' )
                );
            }
        }
    }

    private function get_event_lang()
    {
        switch ($this->id) {
        case'1':
          $select = 'day_montag';
          break;
        case'2':
          $select = 'day_dienstag';
          break;
        case'3':
          $select = 'day_mittwoch';
          break;
        case'4':
          $select = 'day_donnerstag';
          break;
        case'5':
          $select = 'day_freitag';
          break;
        case'6':
          $select = 'day_samstag';
          break;
        case'7':
          $select = 'day_sonntag';
          break;
       }//endSwitch

        global $wpdb;
        $table = $wpdb->prefix . $this->table_weekdays;
        $row = $wpdb->get_row("SELECT {$table}.{$select}
      FROM {$table}
      WHERE {$table}.id = $this->lang_id");
        return $row->$select;
    }
}//endClass
