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

 $plugin_data = get_file_data(plugin_dir_path(__DIR__).'/wp24-termine.php', array('Version' => 'Version'), false);
 global $plugin_version;
 $plugin_version = $plugin_data['Version'];
//PUBLIC CSS & JS
if (!function_exists('apd_termine_scripts')) {
    /**
     * Load theme's CSS / JavaScript sources.
     */
    function apd_termine_scripts()
    {
         global $plugin_version;
         //CSS
         wp_enqueue_style('apd-termine-styles', plugins_url('wp24-termine/assets/css/apd-termine-style.css'), array(), $plugin_version, false);
         wp_enqueue_style('apd-termine-FontAwesome', plugins_url('wp24-termine/assets/css/font-awesome.css'), array(), $plugin_version, false);
         wp_enqueue_style('apd-termine-Fonts', plugins_url('wp24-termine/assets/css/fonts-css/roboto.css'), array(), $plugin_version, false);
         //JS
         wp_enqueue_script('apd-data-termine-main', plugins_url('wp24-termine/assets/js/main.js'), array(), $plugin_version, true);
    }
}
 add_action('wp_enqueue_scripts', 'apd_termine_scripts');

 //PLUGIN ADMIN CSS & JS
 if (!function_exists('apd_termine_admin_style')) {
     /**
      * Load ADMIN-Bereich
      */
     function apd_termine_admin_style()
     {
         global $plugin_version;
         //CSS
         wp_enqueue_style('apd-admin-dashbord-font', plugins_url('wp24-termine/assets/css/fonts-css/OpenSans.css'), array(), $plugin_version, false);
         wp_enqueue_style('apd-data-tables-styles', plugins_url('wp24-termine/assets/css/admin/jquery.dataTables.min.css'), array(), $plugin_version, false);
         wp_enqueue_style('apd-termine-FontAwesome', plugins_url('wp24-termine/assets/css/font-awesome.css'), array(), $plugin_version, false);
         wp_enqueue_style('apd-termine-admin', plugins_url('wp24-termine/assets/css/admin/admin.css'), array(), $plugin_version, false);
         wp_enqueue_style('termine-admin-color-picker', plugins_url('wp24-termine/assets/css/admin/rgbaColorPicker.css'), array(), $plugin_version, false);
         wp_enqueue_style('termine-admin-custom-styles', plugins_url('wp24-termine/assets/css/admin/custom-style.css'), array(), $plugin_version, false);
         //JS
         wp_enqueue_script('apd-data-tables', plugins_url('wp24-termine/assets/js/admin/jquery.dataTables.min.js'), array(), $plugin_version, true);
         wp_enqueue_script('apd-data-sweetalert', plugins_url('wp24-termine/assets/js/admin/sweetalert.min.js'), array(), $plugin_version, true);
         wp_enqueue_script('apd-color-picker', plugins_url('wp24-termine/assets/js/admin/rgbaColorPicker.js'), array(), $plugin_version, true);
         wp_enqueue_script('apd-sort-table', plugins_url('wp24-termine/assets/js/admin/Sortable.min.js'), array(), $plugin_version, true);
     }
 }
add_action('admin_enqueue_scripts', 'apd_termine_admin_style');
