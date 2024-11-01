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

//init variables
 $event_show = false;
 $show_add_event = false;
 $disabled = ' disabled';
 $i = 1;

 //Load Termin Daten
 $db_group = new APD\ArtDesign\TerminPluginDB();
 $select = $db_group->get_groups();
 if($select) {
   $show_add_event = true;
   $disabled = '';
 }

 //Load Settings
 $settings = $db_group->get_settings();
 $sprach_settings =  $db_group->get_sprach_settings();
 $category =  $db_group->get_category();

 //Create Group ID
 isset($_GET['group_id']) && is_numeric($_GET['group_id']) ? $db_group->group_id = $_GET['group_id'] : $db_group->group_id = '';

 //Validate Group
 $aktive_settings = $db_group->get_settings_by_group_id();
 if($db_group->group_id){
    $event_show = true;
 }

 //Alle Events for Group
 $events = $db_group->get_events_by_group_id();
 ?>
 <input type="hidden" id="loaded-group" name="loaded_group" value="<?php echo $db_group->group_id; ?>" />
 <div class="admin-content">
   <div class="galerie-item" style="min-height:70vh;">

     <h1><b class="font-orange"><?php _e('Appointment', 'wp24-termine'); ?> <span class="link-blue"><?php _e('Overview', 'wp24-termine'); ?></span></b></h1>
     <p class="float-right">DB-Version <?php echo get_option("jal_db_version"); ?></p>
     <h2><?php _e('Appointment groups', 'wp24-termine'); ?></h2>
     <hr />
     <br />

     <form action="<?php echo admin_url('admin.php'); ?>" method="get">
       <input type="hidden" name="page" value="art-Picture-termine" />
     <label class="form-label"><?php _e('Choose an appointment', 'wp24-termine'); ?>:</label>
     <select class="events-select" name="group_id" <?php echo $disabled; ?>>
       <option value="0"><?php _e('Select entry', 'wp24-termine'); ?>... </option>
       <?php foreach($select as $tmp) {
         if($db_group->group_id == $tmp->id){
           $select = ' selected';
         } else {
           $select = '';
         }
         echo '<option value="'.$tmp->id.'" '.$select.'>'.$tmp->bezeichnung.'</option>';
       } ?>
     </select>
     <button type="submit" role="button" class="button-primary" <?php echo $disabled; ?>><i class="fa fa-edit"></i>&nbsp;<?php _e('Edit the schedule', 'wp24-termine'); ?></button>
     </form>
     <?php
      if($event_show):
      ?>
     <div id="show_events">
       <?php if($show_add_event): ?>
     <button class="btn-add-eintrag button-primary"><i class="fa fa-plus"></i>&nbsp;<?php _e('Create new entry', 'wp24-termine'); ?></button>
     <button class="btn-dropdown-settings button-secondary"><i class="fa fa-cogs"></i>&nbsp;<?php _e('Settings dropdown button', 'wp24-termine'); ?></button>
      <?php endif; ?>
     <hr />
     <br />
       <?php
       if($events): foreach ($events as $tmp): ?>
          <?php if($tmp['day_status']){
            echo '<h2>'.$tmp['day'].'</h2>';
          } ?>

         <div class="sort-box">
         <ul id="dragable-list<?php echo $i; ?>" class="list-container">
           <?php foreach ($tmp['event'] as $val):
             if ($val->aktiv ? $check = 'checked' : $check = '');
             if ($val->leer || !$val->cat_id) {
                 $background = '#a6a6a6';
                 $color = '#fff';
             } else {
                 $background = $val->bg_color;
                 $color = $val->txt_color;
             }
          ?>
         <li id="event-id<?php echo $val->id; ?>" class="event-data<?php echo $val->id; ?># sort list-element" style="background:<?php echo $background;?>;color:<?php echo $color; ?>">
         <img class="my-handle"src="<?php echo plugins_url('/wp24-termine/assets/images/drag.svg'); ?>">
         <span class="bezeichnung"><?php _e('from', 'wp24-termine'); ?>:&nbsp;<?php echo $val->time_von; ?> <?php _e('to', 'wp24-termine'); ?>:&nbsp;<?php echo $val->time_bis; ?>&nbsp;|&nbsp;</span>
         <span class="bezeichnung"><?php echo $val->content; ?></span>
         <i data-id="<?php echo $val->id; ?>" data-group="<?php echo $val->group_id; ?>"  class="btn-icon pull-right event-edit fa fa-edit"></i>
         <i data-id="<?php echo $val->id; ?>" class=" btn-icon pull-right event-delete fa fa-trash-o mr-2"></i>
         <div class="form-check pull-right mr-2">
         <input data-id="<?php echo $val->id; ?>" class="event-aktiv" name="aktiv" type="checkbox" <?php echo $check; ?>>
         </div>
         </li>
       <?php endforeach;?>
       </div>
     </ul>
       <?php $i++; endforeach; endif;?>
   </div><!--sort-box-->
 <?php endif; ?>
     <!--================DROPDOWN SETTINGS================-->
     <div id ="dropdown-settings">
       <?php if($aktive_settings->drop_aktiv ? $drop_check = 'checked' : $drop_check = ''); ?>
       <br /><hr />
       <h1 class="text-center">
         <i class="text-blue fa fa-cogs"></i>&nbsp;<?php _e('Dropdown button', 'wp24-termine'); ?> <small class="text-blue"><?php _e('Settings', 'wp24-termine'); ?></small>
       </h1>
       <p class="text-center text-blue"> <?php _e('Settings', 'wp24-termine'); ?> (<?php echo $aktive_settings->name; ?>)</p>
       <hr />
       <br />
       <form autocomplete="off" class="send-apd-settings" action="#" method="post">
         <input type="hidden" name="method" value="edit_dropdown" />
         <input type="hidden" name="id" value="<?php echo $aktive_settings->id; ?>" />
         <input type="hidden" name="group_id" value="<?php echo $db_group->group_id; ?>" />
         <div class="settings-flex">
           <div class="settings-item-100">
             <br />
             <a href="#" role="button" class="btn-return button-secondary" ><i class="fa fa-reply-all"></i>&nbsp;<?php _e('back', 'wp24-termine'); ?></a>
             <br /><hr /><br />
           </div>
         </div>
         <div class="settings-flex">
           <div class="settings-item">
             <label class="form-label"><?php _e('Name dropdown button', 'wp24-termine'); ?>:</label>
             <input type="text" value="<?php echo $aktive_settings->drop_bezeichnung; ?>" name="bezeichnung">
         </div>
           <div class="settings-item">
         </div>
       </div>
         <div class="settings-flex">
           <div class="settings-item">
             <label class="form-label"><?php _e('Background dropdown', 'wp24-termine'); ?>:</label>
             <input type="text" class="apd-color-picker" name="bg_color" value="<?php echo $aktive_settings->drop_bg; ?>">
         </div>
         <div class="settings-item">
           <label class="form-label"><?php _e('Dropdown Text Color', 'wp24-termine'); ?>:</label>
           <input type="text" class="apd-color-picker" value="<?php echo $aktive_settings->drop_txt; ?>" name="txt_color">
       </div>
       </div>
       <div class="settings-flex">
         <div class="settings-item">
           <label class="form-label"><?php _e('Background hover dropdown', 'wp24-termine'); ?>:</label>
           <input type="text" class="apd-color-picker" value="<?php echo $aktive_settings->drop_hover_bg; ?>" name="bg_hover_color">
       </div>
       <div class="settings-item">
         <label class="form-label"><?php _e('Dropdown font size', 'wp24-termine'); ?>:</label>
         <input type="text" value="<?php echo $aktive_settings->drop_txt_size; ?>" name="font_size">
     </div>
     </div>
     <div class="settings-flex">
       <div class="settings-item">
         <label class="check-container">
           <?php _e('Show DropDown', 'wp24-termine'); ?>:
           <input name="drop_aktiv" type="checkbox" <?php echo $drop_check; ?>>
           <span class="checkmark"></span>
         </label>
       </div>
       <div class="settings-item"></div>
     </div>
     <br /><hr /><br />
     <div class="settings-flex">
       <div class="settings-item">
         <div class="btn-group">
           <button type="submit" class="button-primary"><i class="fa fa-plus"></i>&nbsp;<?php _e('Save settings', 'wp24-termine'); ?></button>
           <a href="#" role="button" class="btn-close button-secondary" style="margin-right:1rem;"><i class="text-red fa fa-close"></i>&nbsp;<?php _e('abort', 'wp24-termine'); ?></a>
         </div>
       </div>
     </div>
     </form>
     </div>
     <div id="edit-event"></div>
     <div id="add_eintrag">
       <h1 class="text-center"><i class="text-blue fa fa-plus"></i>&nbsp;<?php _e('new', 'wp24-termine'); ?> <small class="text-blue"><?php _e('Settings', 'wp24-termine'); ?></small></h1>
       <hr />
       <br />
       <form class="send-apd-settings" action="#" method="post">
         <input type="hidden" name="method" value="set_eintrag" />
         <input type="hidden" name="group_id" value="<?php echo $db_group->group_id;?>" />
         <div class="settings-flex">
           <div class="settings-item-100">
             <br />
             <a href="#" role="button" class="btn-return button-secondary" ><i class="fa fa-reply-all"></i>&nbsp;<?php _e('back', 'wp24-termine'); ?></a>
             <br /><hr /><br />
           </div>
         </div>
         <div class="settings-flex">
           <div class="settings-item">
             <label class="form-label"><?php _e('weekday', 'wp24-termine'); ?>:</label>
             <select class="custom-select eintrag_name" name="wochentag">
               <option value="0"><?php _e('Select day of the week', 'wp24-termine'); ?>...</option>
               <option value="1"><?php _e('Monday', 'wp24-termine'); ?></option>
               <option value="2"><?php _e('Tuesday', 'wp24-termine'); ?></option>
               <option value="3"><?php _e('Wednesday', 'wp24-termine'); ?></option>
               <option value="4"><?php _e('Thursday', 'wp24-termine'); ?></option>
               <option value="5"><?php _e('Friday', 'wp24-termine'); ?></option>
               <option value="6"><?php _e('Saturday', 'wp24-termine'); ?></option>
               <option value="7"><?php _e('Sunday', 'wp24-termine'); ?></option>
             </select>
           </div>
           <div class="settings-item">
           </div>
         </div>
         <div class="settings-flex">
           <div class="settings-item">
             <label class="form-label"><?php _e('Time from', 'wp24-termine'); ?>:</label>
             <input type="text" class="eintrag_name" placeholder="09:00" name="time_von">
           </div>
           <div class="settings-item">
             <label class="form-label"><?php _e('Time to', 'wp24-termine'); ?>:</label>
             <input type="text" class="eintrag_name" placeholder="10:00" name="time_bis">
           </div>
         </div>

         <div class="settings-flex">
           <div class="settings-item">
             <label class="form-label"><?php _e('entry', 'wp24-termine'); ?>:</label>
             <input type="text" class="eintrag_name" placeholder="Core Work" name="content">
           </div>
           <div class="settings-item">
             <label class="form-label"><?php _e('category', 'wp24-termine'); ?>:</label>
             <select class="custom-select eintrag_name" name="category">
               <option value="0"><?php _e('choose category', 'wp24-termine'); ?>...</option>
               <?php foreach ($category as $tmp) {
               echo '<option value="'.$tmp->id.'">'.$tmp->name.'</option>';
               }
                ?>
             </select>
           </div>
         </div>
         <div class="settings-flex">
           <div class="settings-item">
             <label class="check-container">
               <?php _e('active', 'wp24-termine'); ?>:
               <input class="" name="aktiv" type="checkbox" checked>
               <span class="checkmark"></span>
             </label>
           </div>
           <div class="settings-item">
             <label class="check-container">
               <?php _e('empty entry', 'wp24-termine'); ?>:
               <input class="" name="leer" type="checkbox">
               <span class="checkmark"></span>
             </label>
           </div>
         </div>
         <hr /><br />
         <div class="settings-flex">
           <div class="settings-item">
             <div class="btn-group">
               <button type="submit" class="button-primary"><i class="fa fa-plus"></i>&nbsp;<?php _e('Create an entry', 'wp24-termine'); ?></button>
               <a href="#" role="button" class="btn-close button-secondary" style="margin-right:1rem;"><i class="text-red fa fa-close"></i>&nbsp;<?php _e('abort', 'wp24-termine'); ?></a>
             </div>
           </div>
         </div>
       </form>
       <br />
       <hr>
     </div>

  </div>
  </div>
  <div id="snackbar-success"></div>
  <div id="snackbar-warning"></div>
