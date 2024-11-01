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
class APD_Settings_Form
{
    //Tables
    private $table_settings = 'apd_settings';
    private $table_weekdays = 'apd_weekdays';
    private $table_category = 'apd_category';
    private $table_termin = 'apd_termin';
    private $table_group = 'apd_group';

    //standard Settings
    public $id;
    public $db_id;
    public $name;
    public $bg_color;
    public $bg_txt;
    public $bg_leer;
    public $min_height;
    public $week_size;
    public $time_size;
    public $content_size;
    public $aktiv;
    public $bg_hover_color;
    public $font_size;
    //row Container Settings
    public $cont_width;
    public $padding_top;
    public $padding_bottom;
    public $padding_left;
    public $padding_right;
    public $margin_top;
    public $margin_bottom;
    public $margin_left;
    public $margin_right;
    public $auto_resize;

    public $default;

    //Dropdown
    public $drop_bg;
    public $drop_txt;
    public $drop_hover_bg;
    public $drop_txt_size;
    public $drop_bezeichnung;
    public $drop_aktiv;

    //weekday
    public $sprache;
    public $lang_sprache;
    public $montag;
    public $dienstag;
    public $mittwoch;
    public $donnerstag;
    public $freitag;
    public $samstag;
    public $sonntag;

    //Kategorien
    public $txt_color;
    public $hover_txt;
    public $hover_bg;
    public $post_site;
    public $post_id;

    //Eintrag
    public $content;
    public $time_von;
    public $time_bis;
    public $cat_id;
    public $day_id;
    public $lang_id;
    public $position;
    public $group_id;
    public $leer;

    //Group
    public $settings;
    public $shortcode;
    public $value;
    public $val_type;
    public $sett_id;

    //Error HANDLE
    public $error_id;
    public $error_msg;

    public function update_dropdown_settings()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_settings;
        $wpdb->update(
            $table,
            array(
                  'drop_bg' => $this->bg_color,
                  'drop_txt' => $this->txt_color,
                  'drop_hover_bg' => $this->bg_hover_color,
                  'drop_txt_size' => $this->font_size,
                  'drop_bezeichnung' => $this->name,
                  'drop_aktiv' => $this->drop_aktiv
              ),
            array( 'id' => $this->id ),
            array(
                  '%s','%s','%s','%d','%s','%d'
              ),
            array( '%d' )
          );
    }

    public function update_container_settings()
    {
      global $wpdb;
      $table = $wpdb->prefix . $this->table_settings;
      $wpdb->update(
          $table,
          array(
            'container_widht' => $this->cont_width,
            'padding_top' => $this->padding_top,
            'padding_bottom' => $this->padding_bottom,
            'padding_left' => $this->padding_left,
            'padding_right' => $this->padding_right,
            'margin_top' => $this->margin_top,
            'margin_bottom' => $this->margin_bottom,
            'margin_left' => $this->margin_left,
            'margin_right' => $this->margin_right,
            'auto_resize' => $this->auto_resize
            ),
          array( 'id' => $this->id ),
          array(
                '%s','%s','%s','%s','%s','%s','%s','%s','%s','%d'
            ),
          array( '%d' )
        );
    }

    public function update_event_leer()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $wpdb->update(
          $table,
          array(
                'leer' => $this->leer,
            ),
          array( 'id' => $this->id ),
          array(
                '%d'
            ),
          array( '%d' )
        );
    }

    public function update_standard_settings()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_settings;
        $wpdb->update(
          $table,
          array(
                'name' => $this->name,
                'bg_day' => $this->bg_color,
                'color_day' => $this->bg_txt,
                'bg_leer' => $this->bg_leer,
                'min_height' => $this->min_height,
                'font_size_week' => $this->week_size,
                'font_size_content' => $this->content_size,
                'font_size_time' => $this->time_size
            ),
          array( 'id' => $this->id ),
          array(
                '%s','%s','%s','%s','%d','%d','%d','%d'
            ),
          array( '%d' )
        );
    }

    public function update_weekday()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_weekdays;
        $wpdb->update(
            $table,
            array(
                  'sprache' => $this->sprache,
                  'day_montag' => $this->montag,
                  'day_dienstag' => $this->dienstag,
                  'day_mittwoch' => $this->mittwoch,
                  'day_donnerstag' => $this->donnerstag,
                  'day_freitag' => $this->freitag,
                  'day_samstag' => $this->samstag,
                  'day_sonntag' => $this->sonntag
              ),
            array( 'id' => $this->id ),
            array(
                  '%s','%s','%s','%s','%s','%s','%s','%s'
              ),
            array( '%d' )
          );
    }

    public function get_settings()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_settings;
        $row = $wpdb->get_results("SELECT *
          FROM $table ");
        return $row;
    }

    public function set_settings()
    {

        global $wpdb;
        $table = $wpdb->prefix . $this->table_settings;
        $wpdb->insert(
            $table,
            array(
            'name' => $this->name,
            'aktiv' => $this->aktiv,
            'bg_day' => $this->bg_color,
            'color_day' => $this->bg_txt,
            'bg_leer' => $this->bg_leer,
            'drop_bg' => $this->drop_bg,
            'drop_txt'=> $this->drop_txt,
            'drop_hover_bg' => $this->drop_hover_bg,
            'drop_txt_size' => $this->drop_txt_size,
            'drop_bezeichnung' => $this->drop_bezeichnung,
            'drop_aktiv' => $this->drop_aktiv,
            'min_height' => $this->min_height,
            'font_size_week' => $this->week_size,
            'font_size_content' => $this->content_size,
            'font_size_time' => $this->time_size,
            'container_widht' => $this->cont_width,
            'padding_top' => $this->padding_top,
            'padding_bottom' => $this->padding_bottom,
            'padding_left' => $this->padding_left,
            'padding_right' => $this->padding_right,
            'margin_top' => $this->margin_top,
            'margin_bottom' => $this->margin_bottom,
            'margin_left' => $this->margin_left,
            'margin_right' => $this->margin_right
           ),
            array('%s','%d','%s','%s','%s','%s','%s','%s','%d','%s','%d','%d','%d','%d','%d',
            '%s','%s','%s','%s','%s','%s','%s','%s','%s')
      );
        return array("id"=>$wpdb->insert_id);
    }

    public function set_group()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_group;
        $wpdb->insert(
          $table,
          array(
        'bezeichnung' => $this->name,
        'aktiv' => $this->aktiv,
        'lang_id' => $this->sprache,
        'sett_id' => $this->settings,
        'shortcode' => $this->shortcode
      ),
          array('%s','%d','%d','%d','%s')
      );
        return array("id"=>$wpdb->insert_id);
    }

    public function set_new_eintrag()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $wpdb->insert(
            $table,
            array(
          'aktiv' => $this->aktiv,
          'leer' => $this->leer,
          'day_id' => $this->day_id,
          'cat_id' => $this->cat_id,
          'position' => $this->position,
          'content' => $this->content,
          'time_von' => $this->time_von,
          'time_bis' => $this->time_bis,
          'group_id' => $this->id
      ),
            array('%d','%d','%d','%d','%d','%s','%s','%s','%d')
    );
        return array("id"=>$wpdb->insert_id);
    }

    public function set_category()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_category;
        $wpdb->insert(
            $table,
            array(
          'aktiv' => $this->aktiv,
          'name' => $this->name,
          'bg_color' => $this->bg_color,
          'txt_color' => $this->txt_color,
          'hover_color' => $this->hover_bg,
          'hover_txt_color' => $this->hover_txt
      ),
            array('%d','%s','%s','%s','%s','%s')
    );
        return array("id"=>$wpdb->insert_id);
    }

    public function delete_settings()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_settings;
        $wpdb->delete(
            $table,
            array(
          'id' => $this->id ),
            array('%d')
        );
    }

    public function get_settings_by_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_settings;
        $row = $wpdb->get_row("SELECT *
        FROM $table
        WHERE id = $this->id ");
        return $row;
    }

    public function get_settings_by_name()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_settings;
        $row = $wpdb->get_row("SELECT *
      FROM $table
      WHERE name = '{$this->name}' ");
        return $row;
    }

    public function get_group_by_name()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_group;
        $row = $wpdb->get_row("SELECT *
      FROM $table
      WHERE bezeichnung = '{$this->name}' ");
        return $row;
    }

    public function get_group_by_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_group;
        $row = $wpdb->get_row("SELECT *
      FROM $table
      WHERE id = {$this->id} ");
        return $row;
    }

    public function get_group_by_settings_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_group;
        $row = $wpdb->get_row("SELECT *
      FROM $table
      WHERE sett_id = {$this->id} ");
        return $row;
    }

    public function change_group_aktiv()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_group;
        $wpdb->update(
          $table,
          array(
                'aktiv' => $this->aktiv,
            ),
          array( 'id' => $this->id ),
          array(
                '%d'
            ),
          array( '%d' )
        );
    }

    public function change_group_value()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_group;
        $wpdb->update(
          $table,
          array(
                $this->value => $this->name,
            ),
          array( 'id' => $this->id ),
          array(
                $this->val_type
            ),
          array( '%d' )
        );
    }

    public function delete_group()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_group;
        $wpdb->delete(
            $table,
            array(
      'id' => $this->id ),
            array('%d')
        );
    }

    public function get_event_by_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $row = $wpdb->get_row("SELECT *
      FROM $table
      WHERE id = $this->id ");
        return $row;
    }

    public function get_event_by_cat_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $row = $wpdb->get_row("SELECT *
      FROM $table
      WHERE cat_id = $this->id ");
        return $row;
    }

    public function get_events_by_group_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $row = $wpdb->get_results("SELECT *
        FROM $table
        WHERE group_id = {$this->id} ");
        return $row;
    }

    public function get_settings_by_aktiv()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_settings;
        $row = $wpdb->get_row("SELECT *
        FROM $table
        WHERE aktiv = $this->aktiv ");
        return $row;
    }

    public function update_settings_aktiv()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_settings;
        $wpdb->update(
            $table,
            array(
          'aktiv' => $this->aktiv
        ),
            array( 'id' => $this->id ),
            array(
           '%d'
         ),
            array( '%d' )
       );
    }

    public function update_event_aktiv()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $wpdb->update(
            $table,
            array(
          'aktiv' => $this->aktiv
        ),
            array( 'id' => $this->id ),
            array(
           '%d'
         ),
            array( '%d' )
       );
    }

    public function update_event_position()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $wpdb->update(
            $table,
            array(
        'position' => $this->position
      ),
            array( 'id' => $this->id ),
            array(
         '%d'
       ),
            array( '%d' )
     );
    }

    public function get_weekdays_by_aktiv()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_weekdays;
        $row = $wpdb->get_row("SELECT *
        FROM $table
        WHERE aktiv = $this->aktiv ");
        return $row;
    }

    public function update_weekdays_aktiv()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_weekdays;
        $wpdb->update(
            $table,
            array(
          'aktiv' => $this->aktiv
        ),
            array( 'id' => $this->id ),
            array(
           '%d'
         ),
            array( '%d' )
       );
    }

    public function get_weekdays()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_weekdays;
        $row = $wpdb->get_results("SELECT *
        FROM {$table} ");
        return $row;
    }

    public function get_weekdays_by_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_weekdays;
        $row = $wpdb->get_row("SELECT *
        FROM $table
        WHERE id = $this->id ");
        return $row;
    }

    public function delete_weekdays()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_weekdays;
        $wpdb->delete(
            $table,
            array(
          'id' => $this->id ),
            array('%d')
        );
    }

    public function set_weekdays()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_weekdays;
        $wpdb->insert(
            $table,
            array(
            'sprache' => $this->lang_sprache,
            'aktiv' => $this->aktiv,
            'day_montag' => $this->montag,
            'day_dienstag' => $this->dienstag,
            'day_mittwoch' => $this->mittwoch,
            'day_donnerstag' => $this->donnerstag,
            'day_freitag' => $this->freitag,
            'day_samstag' => $this->samstag,
            'day_sonntag' => $this->sonntag
      ),
            array('%s','%s','%s','%s','%s','%s','%s','%s')
    );
        return array("id"=>$wpdb->insert_id);
    }

    public function delete_category()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_category;
        $wpdb->delete(
            $table,
            array(
        'id' => $this->id ),
            array('%d')
      );
    }

    public function update_category()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_category;
        $wpdb->update(
            $table,
            array(
            'name' => $this->name,
            'bg_color' => $this->bg_color,
            'txt_color' => $this->txt_color,
            'hover_color' => $this->hover_bg,
            'hover_txt_color' => $this->hover_txt
            ),
            array( 'id' => $this->id ),
            array(
                '%s','%s','%s','%s','%s'
            ),
            array( '%d' )
        );
    }

    public function get_category_by_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_category;
        $row = $wpdb->get_row("SELECT *
      FROM $table
      WHERE id = $this->id ");
        return $row;
    }

    public function get_event_by_group_day_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $row = $wpdb->get_results("SELECT *
      FROM $table
      WHERE day_id = $this->day_id AND group_id = $this->id ");
        return $row;
    }

    public function get_category()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_category;
        $row = $wpdb->get_results("SELECT *
        FROM {$table} ");
        return $row;
    }

    public function update_category_post_status()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_category;
        $wpdb->update(
          $table,
          array(
        'post_site' => 0,
        'post_id' => 0,
        'post_name'=>null,
        'post_title'=>null
        ),
          array( 'id' => $this->id),
          array(
            '%d','%d','%s','%s'
        ),
          array( '%d' )
      );
    }

    public function update_category_aktiv()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_category;
        $wpdb->update(
            $table,
            array(
        'aktiv' => $this->aktiv
      ),
            array( 'id' => $this->id ),
            array(
         '%d'
       ),
            array( '%d' )
     );
    }

    public function update_category_post()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_category;
        $wpdb->update(
            $table,
            array(
        'post_site' => $this->post_site,
        'post_id' => $this->post_id
      ),
            array( 'id' => $this->id ),
            array(
         '%d','%d'
       ),
            array( '%d' )
     );
    }

    public function update_event_edit()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $wpdb->update(
            $table,
            array(
          'day_id' => $this->day_id,
          'cat_id' => $this->cat_id,
          'content' => $this->content,
          'time_von' => $this->time_von,
          'time_bis' => $this->time_bis
          ),
            array( 'id' => $this->id ),
            array(
              '%d','%d','%s','%s','%s'
          ),
            array( '%d' )
      );
    }

    public function set_event()
    {
      global $wpdb;
      $table = $wpdb->prefix . $this->table_termin;
      $wpdb->insert(
          $table,
          array(
          'aktiv' => $this->aktiv,
          'leer' => $this->leer,
          'group_id' => $this->group_id,
          'day_id' => $this->day_id,
          'cat_id' => $this->cat_id,
          'position' => $this->position,
          'content' => $this->content,
          'time_von' => $this->time_von,
          'time_bis' => $this->time_bis
    ),
          array('%d','%d','%d','%d','%d','%d','%s','%s','%s')
        );
      return array("id"=>$wpdb->insert_id);
    }

    public function delete_event()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $wpdb->delete(
            $table,
            array(
      'id' => $this->id ),
            array('%d')
        );
    }

    public function get_event_lang()
    {
        switch ($this->day_id) {
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
      WHERE {$table}.id = {$this->lang_id} ");
        return $row->$select;
    }

    public function get_termine_settings()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_settings;
        $row = $wpdb->get_row("SELECT {$table}.*
      FROM {$table}
      WHERE {$table}.id = {$this->sett_id} ");
        return $row;
    }

    public function get_public_event_by_day_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $cat_table = $wpdb->prefix . $this->table_category;
        $row = $wpdb->get_results("SELECT {$table}.*,
      {$cat_table}.name as cat_name, {$cat_table}.bg_color, {$cat_table}.txt_color, {$cat_table}.hover_color,
      {$cat_table}.hover_txt_color, {$cat_table}.post_site, {$cat_table}.post_id, {$cat_table}.post_name, {$cat_table}.post_title
      FROM {$table}
      LEFT JOIN {$cat_table} ON {$table}.cat_id = {$cat_table}.id
      WHERE {$table}.cat_id = {$this->id}  AND {$table}.group_id = {$this->group_id} AND {$table}.day_id = {$this->day_id} ORDER BY {$table}.position ASC ");
        return $row;
    }

    public function get_public_all_events_by_day_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $cat_table = $wpdb->prefix . $this->table_category;
        $row = $wpdb->get_results("SELECT {$table}.*,
      {$cat_table}.name as cat_name, {$cat_table}.bg_color, {$cat_table}.txt_color, {$cat_table}.hover_color,
      {$cat_table}.hover_txt_color, {$cat_table}.post_site, {$cat_table}.post_id, {$cat_table}.post_name, {$cat_table}.post_title
      FROM {$table}
      LEFT JOIN {$cat_table} ON {$table}.cat_id = {$cat_table}.id
      WHERE {$table}.aktiv = 1 AND {$table}.group_id = {$this->group_id} AND {$table}.day_id = {$this->day_id} ORDER BY {$table}.position ASC ");
        return $row;
    }

    public function apd_termine_error_msg($id)
    {
      switch($id) {

        case 1:
            //Ein Fehler ist aufgetreten!
            $error_msg = __('An error has occurred!', 'wp24-termine');
          break;
        case 2:
            //Bitte Name für die Settings eingeben!
            $error_msg = __('Please enter a name for the settings!', 'wp24-termine');
          break;
        case 3:
            //Settings erfolgreich gespeichert!
            $error_msg = __('Settings saved successfully!', 'wp24-termine');
          break;
        case 4:
           //Der Name ist schon vorhanden!
            $error_msg = __('The name already exists!', 'wp24-termine');
          break;
        case 5:
           //Diese Settings können nicht gelöscht werden!
            $error_msg = __('These settings cannot be deleted!', 'wp24-termine');
          break;
        case 6:
            //Aktive Settings können nicht gelöscht werden!
            $error_msg = __('Active settings cannot be deleted!', 'wp24-termine');
          break;
        case 7:
            //Settings erfolgreich gelöscht!
            $error_msg = __('Settings deleted successfully!', 'wp24-termine');
          break;
        case 8:
            //Settings konnten nicht gespeichert werden!
            $error_msg = __('Settings could not be saved!', 'wp24-termine');
          break;
        case 9:
            //Diese Sprache kann nicht gelöscht werden!
            $error_msg = __('This language cannot be deleted!', 'wp24-termine');
          break;
        case 10:
            //Bitte Bezeichnung angeben!
            $error_msg = __('Please indicate designation!', 'wp24-termine');
          break;
        case 11:
          //Kategorie erfolgreich gespeichert!
            $error_msg = __('Category saved successfully!', 'wp24-termine');
          break;
        case 12:
          //Kategorie konnte nicht gespeichert werden!
            $error_msg = __('Category could not be saved!', 'wp24-termine');
          break;
        case 13:
          //Es sind Termine für diese Kategorie vorhanden!
            $error_msg = __('There are dates for this category!', 'wp24-termine');
          break;
        case 14:
          //Kategorie erfolgreich gelöscht!
            $error_msg = __('Category deleted successfully!', 'wp24-termine');
          break;
        case 15:
          //Änderungen erfolgreich gespeichert!
            $error_msg = __('Changes succesfully saved!', 'wp24-termine');
          break;
        case 16:
          //Wochentag auswählen
            $error_msg = __('Select day of the week', 'wp24-termine');
          break;
        case 17:
          //Das Feld Uhrzeit von ist leer!
            $error_msg = __('The Time from field is empty!', 'wp24-termine');
          break;
        case 18:
          //Das Feld Uhrzeit bis ist leer!
            $error_msg = __('The Time to field is empty!', 'wp24-termine');
          break;
        case 19:
          //Das Feld Eintrag ist leer!
            $error_msg = __('The entry field is empty!', 'wp24-termine');
          break;
        case 20:
          //Kategorie auswählen
            $error_msg = __('choose category', 'wp24-termine');
          break;
        case 21:
          //kein Eintrag
            $error_msg = __('no entry', 'wp24-termine');
          break;
        case 22:
          //Eintrag erfolgreich erstellt!
            $error_msg = __('Entry created successfully!', 'wp24-termine');
          break;
        case 23:
          //Daten konnten nicht gespeichert werden!
            $error_msg = __('Data could not be saved!', 'wp24-termine');
          break;
        case 24:
          //Eintrag gelöscht!
            $error_msg = __('Entry deleted!', 'wp24-termine');
          break;
        case 25:
          //Bitte Terminplan Bezeichnung angeben!
            $error_msg = __('Please indicate the schedule description!', 'wp24-termine');
          break;
        case 26:
          //Bitte Sprache auswählen!
            $error_msg = __('Please choose language!', 'wp24-termine');
          break;
        case 27:
          //Bitte Header & Layout auswählen!
            $error_msg = __('Please select header & layout!', 'wp24-termine');
          break;
        case 28:
          //Terminplan erfolgreich erstellt!
            $error_msg = __('Schedule successfully created!', 'wp24-termine');
          break;
        case 29:
          //Terminplan konnte nicht erstellt werden!
            $error_msg = __('Schedule could not be created!', 'wp24-termine');
          break;
        case 30:
          //leere Eingabe!
            $error_msg = __('empty input!', 'wp24-termine');
          break;
        case 31:
          //Einstellungen gespeichert!
            $error_msg = __('Settings saved!', 'wp24-termine');
          break;
        case 32:
          //Terminplan und Events erfolgreich gelöscht!
            $error_msg = __('Schedule and events successfully deleted!', 'wp24-termine');
          break;
        case 33:
          //Bitte Termine Kategorie Seite wählen!
            $error_msg = __('Please choose dates category page!', 'wp24-termine');
          break;
        case 34:
          //Seite erfolgreich gelöscht!
            $error_msg = __('Page deleted successfully!', 'wp24-termine');
          break;
        case 35:
          //Es konnten keine Settings gefunden werden!
            $error_msg = __('No settings could be found!', 'wp24-termine');
          break;
        case 36:
          //Demo Plan geladen! Seite wird neu geladen.
            $error_msg = __('Demo plan loaded! Page is reloading.', 'wp24-termine');
          break;

        // AJAX Files zum Übersetzen:
        case 100:
          //Termin bearbeiten
            $error_msg = __('Edit appointment', 'wp24-termine');
          break;
        case 101:
          //zurück
            $error_msg = __('back', 'wp24-termine');
          break;
        case 102:
         //Wochentag
          $error_msg = __('weekday', 'wp24-termine');
          break;
      case 103:
         //Uhrzeit von
            $error_msg = __('Time from', 'wp24-termine');
          break;
       case 104:
         //Uhrzeit bis
            $error_msg = __('Time to', 'wp24-termine');
          break;
       case 105:
        //Kategorie
            $error_msg = __('category', 'wp24-termine');
         break;
       case 106:
        //Eintrag
            $error_msg = __('entry', 'wp24-termine');
         break;
      case 107:
         //Änderungen speichern
            $error_msg = __('save Changes', 'wp24-termine');
          break;
       case 108:
           //abbrechen
           $error_msg = __('abort', 'wp24-termine');
          break;
        case 109:
          //leerer Eintrag
            $error_msg = __('empty entry', 'wp24-termine');
          break;
        case 110:
          //Wochentag auswählen
            $error_msg = __('Select day of the week', 'wp24-termine');
          break;
        case 111:
          //Kategorie auswählen
            $error_msg = __('choose category', 'wp24-termine');
          break;
        case 112:
          //speichern
            $error_msg = __('to save', 'wp24-termine');
          break;
        case 113:
          //löschen
            $error_msg = __('Clear', 'wp24-termine');
          break;
        case 114:
          //Nr
           $error_msg = __('No', 'wp24-termine');
          break;
        case 115:
          //Demo
           $error_msg = __('Demo', 'wp24-termine');
          break;

        //ERROR MESSAGE SWAT
        case 200:
          //Kategorie wirklich löschen?
            $error_msg = __('Are you sure you want to delete a category?', 'wp24-termine');
          break;
        case 201:
          //Alle Einstellungen dieser Kategorie werden gelöscht!
            $error_msg = __('All settings in this category will be deleted!', 'wp24-termine');
          break;
        case 202:
            //Kategorie löschen!
            $error_msg = __('Delete category!', 'wp24-termine');
          break;
        case 203:
           //Termin wirklich löschen?
            $error_msg = __('Are you sure you want to delete the appointment?', 'wp24-termine');
        break;
        case 204:
           //Alle Daten werden aus der Datenbank gelöscht!
            $error_msg = __('All data will be deleted from the database!', 'wp24-termine');
        break;
        case 205:
           //Termin löschen!
            $error_msg = __('Delete appointment!', 'wp24-termine');
        break;
        case 206:
           //Settings wirklich löschen?
            $error_msg = __('Really delete settings?', 'wp24-termine');
        break;
        case 207:
           //Settings löschen!
            $error_msg = __('Delete settings!', 'wp24-termine');
        break;
        case 208:
           //Sprache wirklich löschen?
            $error_msg = __('Really delete language?', 'wp24-termine');
        break;
        case 209:
           //Sprache löschen!
            $error_msg = __('Delete language!', 'wp24-termine');
        break;
        case 210:
           //Diese Seite wirklich löschen?
            $error_msg = __('Really delete this page?', 'wp24-termine');
        break;
        case 211:
           //Die Seite wird gelöscht!
            $error_msg = __('The page will be deleted!', 'wp24-termine');
        break;
        case 212:
           //Seite löschen!
            $error_msg = __('Delete page!', 'wp24-termine');
        break;
        case 213:
           //Terminplan wirklich löschen?
            $error_msg = __('Are you sure you want to delete the schedule?', 'wp24-termine');
        break;
        case 214:
           //Alle Termine aus dieser Gruppe werden gelöscht!
            $error_msg = __('All appointments from this group will be deleted!', 'wp24-termine');
        break;
        case 215:
           //Terminplan löschen!
            $error_msg = __('Delete schedule!', 'wp24-termine');
        break;
      }

      return $error_msg;
    }
}//endClass
