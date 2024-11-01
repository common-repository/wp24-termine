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
class TerminPluginShortCode
{
    //Tables
    private $table_settings = 'apd_settings';
    private $table_weekdays = 'apd_weekdays';
    private $table_category = 'apd_category';
    private $table_termin = 'apd_termin';
    private $table_groups = 'apd_group';
    //IDS
    public $group_id;
    public $lang_id;
    public $sett_id;
    public $apd_kursplan;
    //Events
    private $cat_id;

    private function get_public_events()
    {
        $record = new \stdClass();
        //EVENTS UND TAGE
        $cat_arr = array();
        for ($i=1; $i < 8 ; $i++) {
            $this->id = $i;
            $event = $this->get_public_event_by_day_id();
            $event_arr[] = array(
            "event"=>$event,
            "day"=>$this->get_event_lang()
          );
        }

        //Hole Kategorie IDs für diese Gruppe
        $all_events = $this->get_event_by_group_id();
        foreach ($all_events as $tmp) {
            $catId[] = $tmp->cat_id;
        }
        //Doppelte IDs für das Menu löschen
        if ($catId) {
            $catId = array_unique(array_values($catId));
            //Menu array erstellen
            foreach ($catId as $tmp) {
                $this->cat_id = $tmp;
                $cat = $this->get_category_by_id();
                $cat_item = array(
            "id"=> $cat->id,
            "name" => $cat->name
          );
                array_push($cat_arr, $cat_item);
            }
        }

        //Ausgabe alle Events + DropDown Menu & Settings für diese Gruppe
        $record->settings = $this->get_termine_settings();
        $record->category = $cat_arr;
        $record->group_id = $this->group_id;
        $record->events = $event_arr;
        return $record;
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

    private function get_public_event_by_day_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $cat_table = $wpdb->prefix . $this->table_category;
        $row = $wpdb->get_results("SELECT {$table}.*,
        {$cat_table}.name as cat_name, {$cat_table}.bg_color, {$cat_table}.txt_color,
        {$cat_table}.hover_color,{$cat_table}.hover_txt_color, {$cat_table}.id as cat_id, {$cat_table}.post_title
        FROM {$table}
        LEFT JOIN {$cat_table} ON {$table}.cat_id = {$cat_table}.id
        WHERE {$table}.aktiv = 1 AND {$table}.group_id = {$this->group_id} AND {$table}.day_id = {$this->id} ORDER BY {$table}.position ASC ");
        return $row;
    }

    private function get_event_by_group_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_termin;
        $cat_table = $wpdb->prefix . $this->table_category;
        $row = $wpdb->get_results("SELECT {$table}.*,
        {$cat_table}.name as cat_name, {$cat_table}.bg_color, {$cat_table}.txt_color,
        {$cat_table}.hover_color,{$cat_table}.hover_txt_color, {$cat_table}.id as cat_id, {$cat_table}.post_title
        FROM {$table}
        LEFT JOIN {$cat_table} ON {$table}.cat_id = {$cat_table}.id
        WHERE {$table}.aktiv = 1 AND {$table}.group_id = {$this->group_id} ORDER BY {$table}.position ASC ");
        return $row;
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

    private function get_termine_settings()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_settings;
        $row = $wpdb->get_row("SELECT {$table}.*
      FROM {$table}
      WHERE {$table}.id = {$this->sett_id} ");
        return $row;
    }

    private function get_group_by_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_groups;
        $row = $wpdb->get_row("SELECT {$table}.*
      FROM {$table}
      WHERE {$table}.id = {$this->group_id} ");
        return $row;
    }

    private function get_category()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_category;
        $row = $wpdb->get_results("SELECT *
      FROM {$table}
      ORDER BY name ASC ");
        return $row;
    }

    private function get_category_by_id()
    {
        global $wpdb;
        $table = $wpdb->prefix . $this->table_category;
        $row = $wpdb->get_row("SELECT {$table}.*
      FROM {$table}
      WHERE {$table}.id = {$this->cat_id} ");
        return $row;
    }

    public function get_apd_shortcode()
    {
        $group_items = $this->get_group_by_id();
        if(!$group_items->aktiv){
          return array("status"=>false);
        }
        $events = $this->get_public_events();

        $html ='
              <div id="termine_row_'.$group_items->shortcode.'" class="apd-termine-wrapper">
              <div class="termine-full-row">
              <div id="apd-termine-body-'.$group_items->shortcode.'" class="apd-termine-body-wrapper"style="width:'.$events->settings->container_widht.';
              margin:'.$events->settings->margin_top.' '.$events->settings->margin_right.' '.$events->settings->margin_bottom.' '.$events->settings->margin_left.';
              padding:'.$events->settings->padding_top.' '.$events->settings->padding_right.' '.$events->settings->padding_bottom.' '.$events->settings->padding_left.'
              ">';
        if($events->settings->drop_aktiv){
        $html .= '<div id="termine-dropdown">
              <div class="dropdown" style="background:'.$events->settings->drop_bg.';color:'.$events->settings->drop_txt.'"
              onmouseover="this.style.background=\''.$events->settings->drop_hover_bg.'\';"
              onmouseout="this.style.background=\''.$events->settings->drop_bg.'\';" class="kp-content '.$leer_class.' ">
              <span data-method="get_all_termine" class="get-all-events" style="font-size:'.$events->settings->drop_txt_size.'px">'.$events->settings->drop_bezeichnung.'</span>
              <span class="drop-icon"><i class="fa fa-angle-down"></i></span>
              <div class="dropdown-content">';
        $html .= '<span  data-group_id ="'.$this->group_id.'" data-id="99999" class="select-event">'.$events->settings->drop_bezeichnung.'</span>';
        foreach ($events->category as $tmp) {
            if (empty($tmp['name'])) {
                continue;
            }
            $html .= '<span data-group_id ="'.$this->group_id.'"  data-id="'.$tmp['id'].'" class="select-event">'.$tmp['name'].'</span>';
        }
        $html .= '</div>
              </div>
              </div>';
        } //DropDown Menu
        $html .= '<div id="apd-kursplan">
               <div class="kp-grid">';
        foreach ($events->events as $tmp) {
            $html .= '
                 <div class="grid-item">
                 <div class="box-header" style="background:'.$events->settings->bg_day.';color:'.$events->settings->color_day.';">
                 <div class="kp-day" style="font-size:'.$events->settings->font_size_week.'px;">
                 '.$tmp['day'].'
                 </div><!--day-->
                 </div><!--header-->';
            //BOXEN
            foreach ($tmp['event'] as $val) {
                $this->cat_id = $val->cat_id;
                $kategorie = $this->get_category_by_id();
                if ($kategorie->post_site) {
                    $post = get_post($kategorie->post_id);
                    $url = get_bloginfo('url').'/'.$post->post_type.'/'.$post->post_name;
                    $href_start = '<a title="'.$val->post_title.'" class="termine-post-site" href="'.$url.'">';
                    $href_end = '</a>';
                    $cursor = 'pointer';
                    $info_icon = '<small><i class="small-info-icon fa fa-globe"></i></small>';
                } else {
                    $href_start = '';
                    $href_end = '';
                    $info_icon = '';
                    $cursor = 'default';
                }
                if ($val->leer) {
                    $background = $events->settings->bg_leer;
                    $color = $events->settings->color_day;
                    $ermin_content = '';
                    $time = '';
                    $hover_color = $events->settings->bg_leer;
                    $out_color = $events->settings->bg_leer;
                    $leer_class = 'kp-leer';
                } else {
                    $background = $val->bg_color;
                    $color = $val->txt_color;
                    $ermin_content = $val->content;
                    $time = $val->time_von.' - '.$val->time_bis;
                    $hover_color = $val->hover_color;
                    $out_color = $val->bg_color;
                    $leer_class = '';
                }
                $html .= $href_start.'<div style="cursor:'.$cursor.'; background: '.$background.'; color:'.$color.';
                   min-height: '.$events->settings->min_height.'px;"
                   onmouseover="this.style.background=\''.$hover_color.'\';"
                   onmouseout="this.style.background=\''.$out_color.'\';" class="kp-content '.$leer_class.' ">
                   <div class="kp-content-head" style="font-size:'.$events->settings->font_size_content.'px;">
                   '.$ermin_content.'
                   </div>
                   <div class="content-time" style="font-size:'.$events->settings->font_size_time.'px;">
                   '.$time.$info_icon.'
                   </div>
                   </div>'
                   .$href_end;
            }
            $html .= '</div><!--item-->';
        }
        $html .='</div>
               </div>
               <div id="show-ajax-event"></div>
               </div><!--body-wrapper-->
               </div><!--termine-full-row-->
               </div><!--apd-termine-wrapper-->
               ';
        return array('status'=>true, "html"=>$html);
    }
}//endClass
