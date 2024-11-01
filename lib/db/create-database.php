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
global $jal_db_version;
$jal_db_version = APD_TERMINE_DB_VERSION;
function jal_install()
{
    global $wpdb;
    global $jal_db_version;
    $installed_ver = get_option("jal_db_version");
    if ($installed_ver != $jal_db_version) {
        //TERMINE SETTINGS
        $table_name = $wpdb->prefix . 'apd_settings';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                name varchar(64) NOT NULL,
                aktiv mediumint(1) NOT NULL,
                bg_day varchar(32) NOT NULL,
                color_day varchar(32) NOT NULL,
                bg_leer varchar(32) NOT NULL,
                drop_bg varchar(32) NOT NULL,
                drop_txt varchar(32) NOT NULL,
                drop_hover_bg varchar(32) NOT NULL,
                drop_txt_size mediumint(5) NOT NULL,
                drop_bezeichnung varchar(64) NOT NULL,
                drop_aktiv mediumint(1) NOT NULL,
                min_height mediumint(5) NOT NULL,
                font_size_week mediumint(5) NOT NULL,
                font_size_content mediumint(5) NOT NULL,
                font_size_time mediumint(5) NOT NULL,
                container_widht varchar(32) NULL,
                padding_top varchar(32) NULL,
                padding_bottom varchar(32) NULL,
                padding_left varchar(32) NULL,
                padding_right varchar(32) NULL,
                margin_top varchar(32) NULL,
                margin_bottom varchar(32) NULL,
                margin_left varchar(32) NULL,
                margin_right varchar(32) NULL,
                auto_resize mediumint(1) NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        //TERMINE CATEGORY
        $table_name = $wpdb->prefix . 'apd_category';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                aktiv mediumint(1) NOT NULL,
                post_site mediumint(1) NOT NULL,
                post_id mediumint(1) NOT NULL,
                post_name varchar(255) NULL,
                post_title varchar(255) NULL,
                name varchar(64) NOT NULL,
                bg_color varchar(32) NOT NULL,
                txt_color varchar(32) NOT NULL,
                hover_color varchar(32) NOT NULL,
                hover_txt_color varchar(32) NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        //TERMINE GROUP
        $table_name = $wpdb->prefix . 'apd_group';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                bezeichnung varchar(64) NOT NULL,
                aktiv mediumint(1) NOT NULL,
                lang_id mediumint(9) NOT NULL,
                sett_id mediumint(9) NOT NULL,
                shortcode varchar(64) NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        //TERMINE WOCHENTAGE
        $table_name = $wpdb->prefix . 'apd_weekdays';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                sprache varchar(64) NOT NULL,
                aktiv mediumint(1) NOT NULL,
                day_montag varchar(64) NOT NULL,
                day_dienstag varchar(64) NOT NULL,
                day_mittwoch varchar(64) NOT NULL,
                day_donnerstag varchar(64) NOT NULL,
                day_freitag varchar(64) NOT NULL,
                day_samstag varchar(64) NOT NULL,
                day_sonntag varchar(64) NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        //TERMINE Eintrage
        $table_name = $wpdb->prefix . 'apd_termin';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                aktiv mediumint(1) NOT NULL,
                leer mediumint(1) NOT NULL,
                group_id mediumint(9) NOT NULL,
                day_id mediumint(9) NOT NULL,
                cat_id mediumint(9) NOT NULL,
                position mediumint(9) NOT NULL,
                content varchar(64) NOT NULL,
                time_von varchar(64) NOT NULL,
                time_bis varchar(64) NOT NULL,
                created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);


        //INSERT Default
        require_once('defaults.php');

        $table = $wpdb->prefix . 'apd_settings';
        $settings = $wpdb->get_row("SELECT * FROM $table");

        if(empty($settings)) {
          $wpdb->insert(
            $table,
            array(
              'name' => $apd_default->name,
              'aktiv' => $apd_default->aktiv,
              'bg_day' => $apd_default->bg_color_weekday,
              'color_day' => $apd_default->color_weekday,
              'bg_leer' => $apd_default->bg_color_leer,
              'drop_bg' => $apd_default->drop_bg,
              'drop_txt' => $apd_default->drop_txt,
              'drop_hover_bg' => $apd_default->drop_hover_bg,
              'drop_txt_size' => $apd_default->drop_txt_size,
              'drop_bezeichnung' => $apd_default->drop_bezeichnung,
              'drop_aktiv' => $apd_default->drop_aktiv,
              'min_height' => $apd_default->min_height_box,
              'font_size_week' => $apd_default->font_size_weekday,
              'font_size_content' => $apd_default->font_size_content,
              'font_size_time' => $apd_default->font_size_time,
              'container_widht' => $apd_default->cont_width,
              'padding_top' => $apd_default->padding_top,
              'padding_bottom' => $apd_default->padding_bottom,
              'padding_left' => $apd_default->padding_left,
              'padding_right' => $apd_default->padding_right,
              'margin_top' => $apd_default->margin_top,
              'margin_bottom' => $apd_default->margin_bottom,
              'margin_left' => $apd_default->margin_left,
              'margin_right' => $apd_default->margin_right,
              'auto_resize'=>$apd_default->auto_resize
            ),
            array('%s','%d','%s','%s','%s','%s','%s','%s','%d','%s','%d','%d','%d','%d','%d',
            '%s','%s','%s','%s','%s','%s','%s','%s','%s','%d')
          );
        }
        //Default Kategorie
        $table = $wpdb->prefix . 'apd_category';
        $category = $wpdb->get_row("SELECT * FROM $table");

        $apd_default->post_site = 0;
        $apd_default->post_id = 0;

        if(empty($category)) {
          $wpdb->replace(
            $table,
            array(
              'name' =>  $apd_default->cat_bez,
              'aktiv' => $apd_default->cat_aktiv,
              'bg_color' => $apd_default->cat_bg,
              'txt_color' => $apd_default->cat_txt,
              'hover_color' => $apd_default->cat_txt_hover_bg,
              'hover_txt_color' => $apd_default->cat_txt_hover_txt,
              'post_site' => $apd_default->post_site,
              'post_id' => $apd_default->post_id
            ),
            array('%s','%d','%s','%s','%s','%s','%d','%d')
          );
        }

        //WOCHENTAGE Default
        $table = $wpdb->prefix . 'apd_weekdays';
        $weekdays = $wpdb->get_row("SELECT * FROM $table");
        if(empty($weekdays)) {
          $wpdb->replace(
            $table,
            array(
              'sprache' => $apd_default->sprache,
              'aktiv' => $apd_default->aktiv,
              'day_montag' => $apd_default->montag,
              'day_dienstag' => $apd_default->dienstag,
              'day_mittwoch' => $apd_default->mittwoch,
              'day_donnerstag' => $apd_default->donnerstag,
              'day_freitag' => $apd_default->freitag,
              'day_samstag' => $apd_default->samstag,
              'day_sonntag' => $apd_default->sonntag
            ),
            array('%s','%d','%s','%s','%s','%s','%s','%s','%s')
          );
        }

        update_option("jal_db_version", $jal_db_version);
    }
}

function apd_update_db_check()
{
    global $jal_db_version;
    if (get_site_option('jal_db_version') != $jal_db_version) {
        jal_install();
    }
}
