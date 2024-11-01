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
function apd_termine_shortcode($content)
{
  require_once('shortcode-out.php');
  $Data = new APD\ArtDesign\TerminPluginShortCode();
  $Groups = $Data->get_groups();
  foreach($Groups as $tmp){
    $Data->group_id = $tmp->id;
    $Data->lang_id = $tmp->lang_id;
    $Data->sett_id = $tmp->sett_id;
    $html = $Data->get_apd_shortcode();
    if($html['status']){
      $event = $html['html'];
    }else {
      $event = '';
    }
     $content = str_replace('[termin_'.$tmp->shortcode.']', $event, $content);
  }
  return $content;
}

add_filter('the_content', 'apd_termine_shortcode', 20);
