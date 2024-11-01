<?php
defined('ABSPATH')or die();
/**
 * ArtPictureDesign PHP Class
 * @package Art-Picture Design Plugin
 * Copyright 2020, Jens Wiecker
 * License: Commercial - goto https://art-picturedesign.de
 *
**/

 $db_settings = new APD\ArtDesign\TerminPluginDB();
 $settings = $db_settings->get_settings();
 $sprach_settings =  $db_settings->get_sprach_settings();
 $category =  $db_settings->get_category();
 $groups = $db_settings->get_groups();
 $add_groups = $db_settings->get_add_groups();
 $kat_seiten = $db_settings->get_kategorie_seiten();
 ?>
<div class="admin-content">
  <div class="galerie-item">
    <h1><a class="custom-link-blue" href="https://web-projekt24.de/termine-plugin-von-webprojekt24/" target="_blank"><b><span  class="font-orange">WEB</span>PROJEKT24</b> <span class="font-orange"> <?php _e('appointment', 'wp24-termine'); ?></span></a></h1>
    <p class="float-right">DB-Version <?php echo get_option("jal_db_version"); ?></p>
    <h2><?php _e('Create & Settings', 'wp24-termine'); ?></h2>
    <hr />
    <div class="tab-panels">
      <ul class="tabs">
        <li rel="panel1" class="active"><i class="fa fa-list"></i>&nbsp;<?php _e('Appointment schedule', 'wp24-termine'); ?></li>
        <li rel="panel2"><i class="fa fa-list"></i>&nbsp;<?php _e('Categories', 'wp24-termine'); ?></li>
        <li rel="panel5"><i class="fa fa-list"></i>&nbsp;<?php _e('Category pages', 'wp24-termine'); ?></li>
        <li rel="panel3"><i class="fa fa-cogs"></i>;&nbsp;<?php _e('Header & layout settings', 'wp24-termine'); ?></li>
        <li rel="panel4"><i class="fa fa-cogs"></i>&nbsp;<?php _e('Appointment schedule days', 'wp24-termine'); ?></li>
      </ul>
      <div id="panel1" class="panel active">
      <br />
        <!----------->
        <div id="show_add_group">
          <form id="apd-add-group" class="send-apd-settings" action="#" method="post">
            <input type="hidden" name="method" value="add_group" />
            <div class="settings-flex">
              <div class="settings-item">
                <br />
                <a href="#" role="button" class="btn-close-group button-secondary" ><i class="fa fa-reply-all"></i>&nbsp;<?php _e('back', 'wp24-termine'); ?></a>
                <br />
                <hr />
                <label class="form-label"><?php _e('Schedule description', 'wp24-termine'); ?>:</label>
                <input type="text" name="bezeichnung">
            </div>
              <div class="settings-item">
            </div>
          </div>
            <div class="settings-flex">
                <div class="settings-item">
                <label class="form-label"><?php _e('language', 'wp24-termine'); ?>:</label>
                <select class="select-lang custom-select" name="sprache">
                  <option value="0"><?php _e('Select entry', 'wp24-termine'); ?>... </option>
                  <?php foreach ($add_groups->lang as $tmp) {
     echo '<option value="'.$tmp->id.'">'.$tmp->sprache.'</option>';
 } ?>
                </select>
            </div>
            <div class="settings-item">
            <label class="form-label"><?php _e('Header & layout', 'wp24-termine'); ?>:</label>
            <select class="select-settings custom-select" name="settings">
              <option value="0"><?php _e('Select entry', 'wp24-termine'); ?>... </option>
              <?php foreach ($add_groups->settings as $tmp) {
     echo '<option value="'.$tmp->id.'">'.$tmp->name.'</option>';
 } ?>
            </select>
        </div>
          </div>
          <div class="settings-flex">
            <div class="settings-item">
              <label class="check-container">
               <?php _e('active', 'wp24-termine'); ?>:
               <input id="category_ckeck" class="category-aktiv" name="aktiv" type="checkbox" checked>
                <span class="checkmark"></span>
              </label>
          </div>
          <div class="settings-item"></div>
        </div>
        <hr />
        <br />
        <div class="settings-flex">
            <div class="btn-group">
              <button type="submit" class="button-primary"><i class="fa fa-plus"></i>&nbsp;<?php _e('Create a schedule', 'wp24-termine'); ?></button>
              <a href="#" role="button" class="btn-close-group button-secondary" style="margin-right:1rem;"><i class="text-red fa fa-close"></i>&nbsp;<?php _e('abort', 'wp24-termine'); ?></a>
            </div>
        </div>
        </form>
        </div><!--endAddGroup-->
        <div id="show_groups">
          <button class="btn-add-terminplan button-primary"><i class="font-success fa fa-plus"></i>&nbsp;<?php _e('Create new appointment', 'wp24-termine'); ?></button>
          <button class="btn-add-demo button-secondary"><i class="fa fa-clone"></i>&nbsp;<?php _e('Load demo appointment schedule', 'wp24-termine'); ?></button>

        <div id="table-settings" class="table-responsive">
          <br />
          <h3><?php _e('Created appointment groups', 'wp24-termine'); ?></h3>
          <hr />
            <br />
            <table class="dataTable" id="GroupTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th><?php _e('designation', 'wp24-termine'); ?>:</th>
                  <th><?php _e('active', 'wp24-termine'); ?>:</th>
                  <th><?php _e('language', 'wp24-termine'); ?>:</th>
                  <th><?php _e('Settings', 'wp24-termine'); ?></th>
                  <th><?php _e('Shortcode', 'wp24-termine'); ?></th>
                  <th><?php _e('Edit appointments', 'wp24-termine'); ?></th>
                  <th><?php _e('Clear', 'wp24-termine'); ?></th>
                </tr>
              </thead>
              <tbody class="tr-body">
                <?php foreach ($groups as $tmp):
                  if ($tmp->aktiv ? $group_check = 'checked' : $group_check = '');
                   ?>
                  <tr>
                    <td><b><input data-id="<?php echo $tmp->id; ?>" data-type="1" class="change_group_form settings_name_long objekt_group<?php echo $tmp->id; ?>" value="<?php echo $tmp->bezeichnung; ?>"></b></td>
                    <td>
                      <label class="check-container">
                        <?php _e('active', 'wp24-termine'); ?>:
                        <input data-id="<?php echo $tmp->id; ?>" class="change_group_aktiv" name="aktiv" type="checkbox" <?php echo $group_check; ?>>
                        <span class="checkmark"></span>
                      </label>
                    </td>
                    <td>
                      <select data-id="<?php echo $tmp->id; ?>" data-type="2" class="select-lang change_group_form">
                        <option value="0"><?php _e('Select entry', 'wp24-termine'); ?>... </option>
                        <?php foreach ($add_groups->lang as $val) {
                       if ($tmp->lang_id == $val->id) {
                           $lang_sel = ' selected';
                       } else {
                           $lang_sel = '';
                       }
                       echo '<option value="'.$val->id.'" '.$lang_sel.'>'.$val->sprache.'</option>';
                   } ?>
                      </select>
                    </td>
                    <td>
                      <select data-id="<?php echo $tmp->id; ?>" data-type="3" class="select-settings change_group_form">
                        <option value="0"><?php _e('Select entry', 'wp24-termine'); ?>... </option>
                        <?php foreach ($add_groups->settings as $val) {
                       if ($tmp->sett_id == $val->id) {
                           $lang_sel = ' selected';
                       } else {
                           $lang_sel = '';
                       }
                       echo '<option value="'.$val->id.'" '.$lang_sel.'>'.$val->name.'</option>';
                   } ?>
                      </select>
                    </td>
                    <td><b>[termin_<?php echo $tmp->shortcode; ?>]</b></td>
                    <td>
                      <a href=" <?php echo admin_url('admin.php?page=art-Picture-termine&group_id='.$tmp->id.''); ?>" class="btn btn-primary-outline"><i class="fa fa-edit"></i>&nbsp;<?php _e('Add / edit appointment', 'wp24-termine'); ?></a>
                    </td>
                    <td>
                      <button data-id="<?php echo $tmp->id; ?>" type="button" class="btn-delete-group btn btn-danger-outline"><i class="fa fa-trash"></i>&nbsp;<?php _e('Clear', 'wp24-termine'); ?></button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div><!--endGroup-->
      </div>
      <!--Ende Panel1 -->
      <div id="panel2" class="panel">
        <hr />
        <button class="btn-add-category button-primary"><i class="fa fa-plus"></i>&nbsp;<?php _e('create a new category', 'wp24-termine'); ?></button>
        <span class="float-right">
        <button id="toggle-selected" class="btn-select-all-category btn btn-primary-outline"><i class="fa fa-check"></i>&nbsp;<?php _e('select all', 'wp24-termine'); ?></button>
        <button class="btn-delete-selected-category btn btn-danger-outline"><i class="fa fa-trash-o"></i>&nbsp;<?php _e('delete unused', 'wp24-termine'); ?></button>
        </span>
        <hr />
        <br />
        <div id="table-kategorie" class="table-responsive">
          <br />
          <table class="dataTable" id="CategoryTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th><?php _e('active', 'wp24-termine'); ?>:</th>
                <th><?php _e('designation', 'wp24-termine'); ?>:</th>
                <th><?php _e('Box BG Color', 'wp24-termine'); ?>:</th>
                <th><?php _e('Text Color', 'wp24-termine'); ?></th>
                <th><?php _e('Hover BG Color', 'wp24-termine'); ?></th>
                <th><?php _e('Hover Text Color', 'wp24-termine'); ?></th>
                <th><?php _e('to save', 'wp24-termine'); ?></th>
                <th><?php _e('Clear', 'wp24-termine'); ?></th>
                <th><?php _e('selection', 'wp24-termine'); ?></th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th><?php _e('active', 'wp24-termine'); ?>:</th>
                <th><?php _e('designation', 'wp24-termine'); ?>:</th>
                <th><?php _e('Box BG Color', 'wp24-termine'); ?>:</th>
                <th><?php _e('Text Color', 'wp24-termine'); ?></th>
                <th><?php _e('Hover BG Color', 'wp24-termine'); ?></th>
                <th><?php _e('Hover Text Color', 'wp24-termine'); ?></th>
                <th><?php _e('to save', 'wp24-termine'); ?></th>
                <th><?php _e('Clear', 'wp24-termine'); ?></th>
                <th><?php _e('selection', 'wp24-termine'); ?></th>
              </tr>
            </tfoot>
            <tbody class="tr-body">
              <?php foreach ($category as $tmp):
                if ($tmp->aktiv ? $check = 'checked' : $check = '');
                ?>
                <tr>
                  <form autocomplete="off" class="send-apd-settings" action="#" method="post">
                    <input type="hidden" name="method" value="edit_category" />
                    <input type="hidden" name="id" value="<?php echo $tmp->id; ?>" />
                    <td>
                      <label class="check-container">
                        <?php _e('active', 'wp24-termine'); ?>:
                        <input id="catgory_ckeck<?php echo $tmp->id; ?>" data-id="<?php echo $tmp->id; ?>" class="category-aktiv" name="aktiv" type="checkbox" <?php echo $check; ?>>
                        <span class="checkmark"></span>
                      </label>
                    </td>
                  <td><p class="objekt_category<?php echo $tmp->id; ?>"><input class="category_name" name="name" value="<?php echo $tmp->name; ?>"> </p></td>
                  <td><p><input type="text" name="bg_color" class="apd-color-picker" value="<?php echo $tmp->bg_color; ?>"></p>
                  </td>
                  <td><p><input type="text" name="txt_color" class="apd-color-picker" value="<?php echo $tmp->txt_color; ?>"></p></td>
                  <td><p><input type="text" name="hover_color" class="apd-color-picker" value="<?php echo $tmp->hover_color; ?>"></p></td>
                  <td><p><input type="text" name="hover_txt" class="apd-color-picker" value="<?php echo $tmp->hover_txt_color; ?>"></p></td>
                  <td>
                    <button data-id="<?php echo $tmp->id; ?>" type="button" class="btn-delete-category btn btn-danger-outline"><i class="fa fa-trash"></i>&nbsp; <?php _e('Clear', 'wp24-termine'); ?></button>
                  </td>
                  <td>
                    <button type="submit" data-id="<?php echo $tmp->id; ?>" class="btn btn-primary-outline"><i class="fa fa-save"></i>&nbsp; <?php _e('Save', 'wp24-termine'); ?></button>
                  </td>
                  <td>
                    <label class="check-container">
                      <input name="seleced-categorie" data-id="<?php echo $tmp->id; ?>" value="<?php echo $tmp->id ?>" class="select-category" type="checkbox">
                      <span class="select checkmark"></span>
                    </label>
                  </td>
                </form>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div id="add_category">

          <h1 class="text-center"><i class="text-blue fa fa-plus"></i>&nbsp;<?php _e('new', 'wp24-termine'); ?> <small class="text-blue"><?php _e('category', 'wp24-termine'); ?></small></h1>
          <hr />
          <br />
          <form autocomplete="off" class="send-apd-settings" action="#" method="post">
            <input type="hidden" name="method" value="set_category" />
            <div class="settings-flex">
              <div class="settings-item">
                <br />
                <a href="#" role="button" class="btn-close button-secondary" ><i class="fa fa-reply-all"></i>&nbsp;<?php _e('back', 'wp24-termine'); ?></a>
                <br />
                <hr />
                <label class="form-label"><?php _e('designation', 'wp24-termine'); ?>:</label>
                <input type="text" name="name" placeholder="<?php _e('designation', 'wp24-termine'); ?>">
              </div>
              <div class="settings-item">
              </div>
            </div>
            <div class="settings-flex">
              <div class="settings-item">
                <label class="form-label"><?php _e('Text color', 'wp24-termine'); ?>:</label>
                <input type="text" class="apd-color-picker-txt" name="txt_color">
              </div>
              <div class="settings-item">
                <label class="form-label"><?php _e('Box BG Color', 'wp24-termine'); ?>:</label>
                <input type="text" class="apd-color-picker-txt" name="bg_color">
              </div>
            </div>

            <div class="settings-flex">
              <div class="settings-item">
                <label class="form-label"><?php _e('Hover Text Color', 'wp24-termine'); ?>:</label>
                <input type="text" class="apd-color-picker-txt" name="hover_txt">
              </div>
              <div class="settings-item">
                <label class="form-label"><?php _e('Hover BG Color', 'wp24-termine'); ?>:</label>
                <input type="text" class="apd-color-picker-txt" name="hover_bg">
              </div>
            </div>
            <hr /><br />
            <div class="settings-flex">
              <div class="settings-item">
                <div class="btn-group">
                  <button type="submit" class="button-primary"><i class="fa fa-plus"></i>&nbsp;<?php _e('Create category', 'wp24-termine'); ?></button>
                  <a href="#" role="button" class="btn-close button-secondary" style="margin-right:1rem;"><i class="text-red fa fa-close"></i>&nbsp;<?php _e('abort', 'wp24-termine'); ?></a>
                </div>
              </div>
            </div>
          </form>
          <br />
          <hr>
        </div>
      </div>
      <!--Ende Panel 2 -->
      <div id="panel3" class="panel">
        <hr />
        <button class="btn-add-settings button-primary"><i class="fa fa-plus"></i>&nbsp;<?php _e('create new settings', 'wp24-termine'); ?></button>
        <hr />
        <br />
        <div id="tableSettings" class="table-responsive">
          <br />
          <table class="dataTable" id="StartTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th><?php _e('name', 'wp24-termine'); ?>:</th>
                <th><?php _e('Header BG', 'wp24-termine'); ?>:</th>
                <th><?php _e('Header Color', 'wp24-termine'); ?></th>
                <th><?php _e('Empty BG', 'wp24-termine'); ?></th>
                <th><?php _e('Box min. Height (px)', 'wp24-termine'); ?></th>
                <th><?php _e('Font size header (px)', 'wp24-termine'); ?></th>
                <th><?php _e('Font size appointment (px)', 'wp24-termine'); ?></th>
                <th><?php _e('Font size date (px)', 'wp24-termine'); ?></th>
                <th><?php _e('Container', 'wp24-termine'); ?></th>
                <th><?php _e('DropDown', 'wp24-termine'); ?></th>
                <th><?php _e('to save', 'wp24-termine'); ?></th>
                <th><?php _e('Clear', 'wp24-termine'); ?></th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th><?php _e('name', 'wp24-termine'); ?>:</th>
                <th><?php _e('Header BG', 'wp24-termine'); ?>:</th>
                <th><?php _e('Header Color', 'wp24-termine'); ?></th>
                <th><?php _e('Empty BG', 'wp24-termine'); ?></th>
                <th><?php _e('Box min. Height (px)', 'wp24-termine'); ?></th>
                <th><?php _e('Font size header (px)', 'wp24-termine'); ?></th>
                <th><?php _e('Font size appointment (px)', 'wp24-termine'); ?></th>
                <th><?php _e('Font size date (px)', 'wp24-termine'); ?></th>
                <th><?php _e('Container', 'wp24-termine'); ?></th>
                <th><?php _e('DropDown', 'wp24-termine'); ?></th>
                <th><?php _e('to save', 'wp24-termine'); ?></th>
                <th><?php _e('Clear', 'wp24-termine'); ?></th>
              </tr>
            </tfoot>
            <tbody class="tr-body">
              <?php foreach ($settings as $tmp):
                if ($tmp->aktiv ? $check = 'checked' : $check = '');
                ?>
              <tr id="table_data<?php echo $tmp->id; ?>">
                <form autocomplete="off" class="send-apd-settings" action="#" method="post">
                  <input type="hidden" name="method" value="edit_settings" />
                  <input type="hidden" name="id" value="<?php echo $tmp->id; ?>" />
                <td><b><input class="objekt_settings<?php echo $tmp->id; ?> settings_name" name="name" value="<?php echo $tmp->name; ?>"></b></td>
                <td>
                  <p>
                    <input name="bg_color" class="apd-color-picker" value="<?php echo $tmp->bg_day ?>">
                  </p>
                </td>
                <td>
                <p>
                  <input name="bg_txt" class="apd-color-picker" value="<?php echo $tmp->color_day ?>">
                </p>
                </td>
                <td>
                  <p>
                    <input name="bg_leer" class="apd-color-picker" value="<?php echo $tmp->bg_leer ?>">
                  </p>
                </td>
                <td><input class="input-size-small" name="min_height" value="<?php echo $tmp->min_height; ?>"></td>
                <td><input class="input-size-small" name="week_size" value="<?php echo $tmp->font_size_week; ?>"></td>
                <td><input class="input-size-small" name="content_size" value="<?php echo $tmp->font_size_content; ?>"></td>
                <td><input class="input-size-small" name="time_size" value="<?php echo $tmp->font_size_time; ?>"></td>
                <td>
                  <span data-id="<?php echo $tmp->id; ?>" type="button" class="btn-show-formular btn-edit-small"> <i class="fa fa-cogs"></i></span>
                </td>
                <td>
                  <span data-id="<?php echo $tmp->id; ?>" type="button" class="btn-show-drop-formular btn-edit-small"> <i class="fa fa-cogs"></i></span>
                </td>
                <td>
                  <button name="settings_gesendet" type="submit" class="btn-save-settings btn btn-primary-outline"><i class="fa fa-save"></i>&nbsp; <?php _e('save', 'wp24-termine'); ?></button>
                </td>
                <td>
                  <button data-id="<?php echo $tmp->id; ?>" type="button" class="btn-delete-settings btn btn-danger-outline">
                  <i class="fa fa-trash"></i>&nbsp; <?php _e('Clear', 'wp24-termine'); ?></button>
                </td>
                </form>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div id="add_settings">

          <h1 class="text-center"><i class="text-blue fa fa-plus"></i>&nbsp;<?php _e('new', 'wp24-termine'); ?> <small class="text-blue"><?php _e('Settings', 'wp24-termine'); ?></small></h1>
          <hr />
          <br />
          <form autocomplete="off" id="add_standard_settings" class="send-apd-settings" action="#" method="post">
            <input type="hidden" name="method" value="set_settings" />
            <div class="settings-flex">
              <div class="settings-item-100">
                <br />
                 <a href="#" role="button" class="btn-close button-secondary" ><i class="fa fa-reply-all"></i>&nbsp;<?php _e('back', 'wp24-termine'); ?></a>
                 <br /><hr /><br />
                 </div>
            </div>
            <div class="settings-flex">
              <div class="settings-item">
                <label class="form-label"><?php _e('name', 'wp24-termine'); ?>:</label>
                <input type="text" name="name" placeholder="<?php _e('designation', 'wp24-termine'); ?>">
              </div>
              <div class="settings-item">
                <label class="form-label"><?php _e('Box empty color', 'wp24-termine'); ?>:</label>
                <input type="text" class="apd-color-picker" name="bg_leer">
              </div>
            </div>
            <div class="settings-flex">
              <div class="settings-item">
                <label class="form-label"><?php _e('BG Color header', 'wp24-termine'); ?>:</label>
                <input type="text" class="apd-color-picker" name="bg_color">
              </div>
              <div class="settings-item">
                <label class="form-label"><?php _e('Header color', 'wp24-termine'); ?>:</label>
                <input type="text" class="apd-color-picker" name="bg_txt">
              </div>
            </div>

            <div class="settings-flex">
              <div class="settings-item">
                <label class="form-label"><?php _e('Box min. height', 'wp24-termine'); ?>:</label>
                <input type="number" name="min_height" placeholder="130">
              </div>
              <div class="settings-item">
                <label class="form-label"><?php _e('Font size header', 'wp24-termine'); ?>:</label>
                <input type="number" name="week_size" placeholder="18">
              </div>
            </div>

            <div class="settings-flex">
              <div class="settings-item">
                <label class="form-label"><?php _e('Font size appointment', 'wp24-termine'); ?>:</label>
                <input type="number" name="content_size" placeholder="18">
              </div>
              <div class="settings-item">
                <label class="form-label"><?php _e('Font size date', 'wp24-termine'); ?>:</label>
                <input type="number" name="time_size" placeholder="16">
              </div>
            </div>

            <hr /><br />
            <div class="settings-flex">
              <div class="settings-item">
                <div class="btn-group">
                  <button type="submit" class="button-primary"><i class="fa fa-plus"></i>&nbsp;<?php _e('Create settings', 'wp24-termine'); ?></button>
                  <a href="#" role="button" class="btn-close button-secondary" style="margin-right:1rem;"><i class="text-red fa fa-close"></i>&nbsp;<?php _e('abort', 'wp24-termine'); ?></a>
                </div>
              </div>
            </div>
          </form>
          <br />
          <hr>
        </div>
      </div>
      <!--Ende Panel 3-->
      <div id="panel4" class="panel">
          <hr />
          <button class="btn-add-weekdays button-primary"><i class="fa fa-plus"></i>&nbsp;<?php _e('add new language', 'wp24-termine'); ?></button>
          <hr />
          <br />
          <div id="table-weekdays" class="table-responsive">
            <br />
            <table class="dataTable" id="WeekdaysTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th><?php _e('name', 'wp24-termine'); ?>:</th>
                  <th><?php _e('Monday', 'wp24-termine'); ?>:</th>
                  <th><?php _e('Tuesday', 'wp24-termine'); ?></th>
                  <th><?php _e('Wednesday', 'wp24-termine'); ?></th>
                  <th><?php _e('Thursday', 'wp24-termine'); ?></th>
                  <th><?php _e('Friday', 'wp24-termine'); ?></th>
                  <th><?php _e('Saturday', 'wp24-termine'); ?></th>
                  <th><?php _e('Sunday', 'wp24-termine'); ?></th>
                  <th><?php _e('to save', 'wp24-termine'); ?></th>
                  <th><?php _e('Clear', 'wp24-termine'); ?></th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th><?php _e('name', 'wp24-termine'); ?>:</th>
                  <th><?php _e('Monday', 'wp24-termine'); ?>:</th>
                  <th><?php _e('Tuesday', 'wp24-termine'); ?></th>
                  <th><?php _e('Wednesday', 'wp24-termine'); ?></th>
                  <th><?php _e('Thursday', 'wp24-termine'); ?></th>
                  <th><?php _e('Friday', 'wp24-termine'); ?></th>
                  <th><?php _e('Saturday', 'wp24-termine'); ?></th>
                  <th><?php _e('Sunday', 'wp24-termine'); ?></th>
                  <th><?php _e('to save', 'wp24-termine'); ?></th>
                  <th><?php _e('Clear', 'wp24-termine'); ?></th>
                </tr>
              </tfoot>
              <tbody class="tr-body">
                <?php foreach ($sprach_settings as $tmp):?>
                  <tr>
                    <td>
                      <p><input class="settings_name object_weekdays<?php echo $tmp->id; ?>" value="<?php echo $tmp->sprache; ?>"></p>
                    </td>
                    <td>
                      <p><input class="settings_name object_montag<?php echo $tmp->id; ?>" value="<?php echo $tmp->day_montag; ?>"></p>
                    </td>
                    <td>
                      <p><input class="settings_name object_dienstag<?php echo $tmp->id; ?>" value="<?php echo $tmp->day_dienstag; ?>"></p>
                    </td>
                    <td>
                      <p><input class="settings_name object_mittwoch<?php echo $tmp->id; ?>" value="<?php echo $tmp->day_mittwoch; ?>"></p>
                    </td>
                    <td>
                      <p><input class="settings_name object_donnerstag<?php echo $tmp->id; ?>" value="<?php echo $tmp->day_donnerstag; ?>"></p>
                    </td>
                    <td>
                      <p><input class="settings_name object_freitag<?php echo $tmp->id; ?>" value="<?php echo $tmp->day_freitag; ?>"></p>
                    </td>
                    <td>
                      <p><input class="settings_name object_samstag<?php echo $tmp->id; ?>" value="<?php echo $tmp->day_samstag; ?>"></p>
                    </td>
                    <td>
                      <p><input class="settings_name object_sonntag<?php echo $tmp->id; ?>" value="<?php echo $tmp->day_sonntag; ?>"></p>
                    </td>
                    <td>
                      <button data-id="<?php echo $tmp->id; ?>" type="button" class="btn-delete-weekdays btn btn-danger-outline"><i class="fa fa-trash"></i>&nbsp; <?php _e('Clear', 'wp24-termine'); ?></button>
                    </td>
                    <td>
                      <button type="button" data-method="edit_weekdays" data-id="<?php echo $tmp->id; ?>" class="btn-save-weekdays btn btn-primary-outline"><i class="fa fa-save"></i>&nbsp; <?php _e('Save', 'wp24-termine'); ?></button>
                    </td>
                  </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div id="add_weekdays">
            <h1 class="text-center"><i class="text-blue fa fa-plus"></i>&nbsp;<?php _e('new', 'wp24-termine'); ?> <small class="text-blue"><?php _e('Settings', 'wp24-termine'); ?></small></h1>
            <hr />
            <br />
            <form id="weekdays-form" class="send-apd-settings" action="#" method="post">
              <input type="hidden" name="method" value="set_weekdays" />
              <div class="settings-flex">
                <div class="settings-item-100">
                  <br />
                   <a href="#" role="button" class="btn-close button-secondary" ><i class="fa fa-reply-all"></i>&nbsp;<?php _e('back', 'wp24-termine'); ?></a>
                   <br /><hr /><br />
                   </div>
              </div>
              <div class="settings-flex">
                <div class="settings-item">
                  <label class="form-label"><?php _e('language', 'wp24-termine'); ?>:</label>
                  <input type="text" name="lang_sprache" placeholder="de">
                </div>
                <div class="settings-item">
                  <label class="form-label"><?php _e('Monday', 'wp24-termine'); ?>:</label>
                  <input type="text" placeholder="<?php _e('Monday', 'wp24-termine'); ?>" name="montag">
                </div>
              </div>
              <div class="settings-flex">
                <div class="settings-item">
                  <label class="form-label"><?php _e('Tuesday', 'wp24-termine'); ?>:</label>
                  <input type="text" placeholder="<?php _e('Tuesday', 'wp24-termine'); ?>"name="dienstag">
                </div>
                <div class="settings-item">
                  <label class="form-label"><?php _e('Wednesday', 'wp24-termine'); ?>:</label>
                  <input type="text" placeholder="<?php _e('Wednesday', 'wp24-termine'); ?>" name="mittwoch">
                </div>
              </div>

              <div class="settings-flex">
                <div class="settings-item">
                  <label class="form-label"><?php _e('Thursday', 'wp24-termine'); ?>:</label>
                  <input type="text" name="donnerstag" placeholder="<?php _e('Thursday', 'wp24-termine'); ?>">
                </div>

                <div class="settings-item">
                  <label class="form-label"><?php _e('Friday', 'wp24-termine'); ?>:</label>
                  <input type="text" name="freitag" placeholder="<?php _e('Friday', 'wp24-termine'); ?>">
                </div>
              </div>

              <div class="settings-flex">
                <div class="settings-item">
                  <label class="form-label"><?php _e('Saturday', 'wp24-termine'); ?>:</label>
                  <input type="text" name="samstag" placeholder="<?php _e('Saturday', 'wp24-termine'); ?>">
                </div>
                <div class="settings-item">
                  <label class="form-label"><?php _e('Sunday', 'wp24-termine'); ?>:</label>
                  <input type="text" name="sonntag" placeholder="<?php _e('Sunday', 'wp24-termine'); ?>">
                </div>
              </div>
              <hr /><br />
              <div class="settings-flex">
                <div class="settings-item">
                  <div class="btn-group">
                    <button type="submit" class="button-primary"><i class="fa fa-plus"></i>&nbsp;<?php _e('Create settings', 'wp24-termine'); ?></button>
                    <a href="#" role="button" class="btn-close button-secondary" style="margin-right:1rem;"><i class="text-red fa fa-close"></i>&nbsp;<?php _e('abort', 'wp24-termine'); ?></a>
                  </div>
                </div>
              </div>
            </form>
            <br />
            <hr>
          </div>
      </div>
      <!--Ende Panel 4-->
      <div id="panel5" class="panel">
        <hr />
        <button class="btn-add-sites button-primary"><i class="fa fa-plus"></i>&nbsp;<?php _e('add new page', 'wp24-termine'); ?></button>
        <hr />
        <br />
        <div id="add_site">
          <h1 class="text-center"><i class="text-blue fa fa-plus"></i>&nbsp;neue <small class="text-blue"><?php _e('Category page', 'wp24-termine'); ?></small></h1>
          <hr />
          <div class="form-center">
          <form action="<?php echo admin_url('post-new.php'); ?>" method="get">
           <input type="hidden" name="post_type" value="apd-termin-plan">
           <label class="form-label"><?php _e('choose categorie', 'wp24-termine'); ?>:</label>
           <select class="seite-category-select" id="select_category" name="cat_id" >
           <option value="0"><?php _e('Select entry', 'wp24-termine'); ?>... </option>
           <?php
            $select_cat = $db_settings->get_kategorie_non_post_id();
           foreach ($select_cat as $tmp) {
               echo ' <option value="'.$tmp->id.'">'.$tmp->name.'</option>';
           } ?>
           </select>
           <br />

           <button id="add_category_seite" type="submit" role="button" class="button-primary" disabled><i class="fa fa-edit"></i>&nbsp;<?php _e('Create a page', 'wp24-termine'); ?></button>
           <a href="#" role="button" class="btn-close button-secondary" style="margin-right:1rem;"><i class="text-red fa fa-close"></i>&nbsp;<?php _e('abort', 'wp24-termine'); ?></a>
            </form>
           </div>
          <br />
          <hr>
        </div>
        <!----------->
      <div id="show-kategorie-seite" class="table-responsive">
        <!---------------->
        <table class="dataTable" id="SeitenTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th><?php _e('category', 'wp24-termine'); ?>:</th>
              <th><?php _e('Pages title', 'wp24-termine'); ?>:</th>
              <th><?php _e('Post ID', 'wp24-termine'); ?>:</th>
              <th><?php _e('Created', 'wp24-termine'); ?>:</th>
              <th><?php _e('status', 'wp24-termine'); ?>:</th>
              <th><?php _e('Comment status', 'wp24-termine'); ?>:</th>
              <th><?php _e('View page', 'wp24-termine'); ?>:</th>
              <th><?php _e('To edit', 'wp24-termine'); ?></th>
              <th><?php _e('Clear', 'wp24-termine'); ?></th>
            </tr>
          </thead>
          <tbody class="tr-body">
            <?php foreach ($kat_seiten as $tmp): ?>
              <tr>
                <td><b class="seiten_objekt<?php echo $tmp['cat_id']; ?>"><?php echo $tmp['cat_name']; ?></b></td>
                <td><?php echo $tmp['post_title']; ?></td>
                <td><b><?php echo $tmp['post_id']; ?></b></td>
                <td><span class="d-none"><?php echo $tmp['datum2']; ?></span><?php echo $tmp['datum']; ?></td>
                <td><b><?php echo $tmp['post_status'];  ?></b></td>
                <td><b><?php echo $tmp['comment_status'];  ?></b></td>
                <td>
                  <a href="<?php echo get_bloginfo('url').'/'.$tmp['post_type'].'/'.$tmp['post_name']; ?>" role="button" class="btn btn-primary-outline"><i class="fa fa-mail-forward"></i>&nbsp; <?php _e('look at', 'wp24-termine'); ?></button>
                </td>
                <td>
                  <a href="<?php echo admin_url('post.php?post='.$tmp['post_id'].'&action=edit&cat_id='.$tmp['cat_id'].''); ?>" role="button" class="btn btn-primary-outline"><i class="fa fa-edit"></i>&nbsp; <?php _e('to edit', 'wp24-termine'); ?></button>
                </td>
                <td>
                  <button data-id="<?php echo $tmp['cat_id']; ?>" class="btn-delete-seite btn btn-danger-outline">
                  <i class="fa fa-trash"></i>&nbsp; <?php _e('Clear', 'wp24-termine'); ?></button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div><!--Ende Panel 5-->

    </div>
    <!--tabs-->
  </div>
</div>
<!--=============================MODAL======================================-->
<div id="meinModal" class="modal-overlay">
<div class="modal-wrapper" id="modal-wrapper">
<div class="modal" id="modal">
  <button class="close-button button-secondary" id="close-button"><i class="fa fa-close"></i></button>
  <div class="modal-title">
    <h2><i class="text-blue fa fa-arrows"></i>&nbsp; <?php _e('Container settings', 'wp24-termine'); ?> &nbsp;(<small class="title-form-modal"></small>)</h2>
  </div>
  <div class="modal-body">
    <div>
    <!------->
    <form class="send-apd-settings" action="#" method="post">
      <input class="modalMethod" type="hidden" name="method" />
      <input class="settingsID" type="hidden" name="id" />
      <div class="modal-flex">
        <div class="modal-item">
          <!--<label class="form-label"><i class="fa fa-arrows-h"></i>&nbsp;<?php _e('Container width', 'wp24-termine'); ?>:</label>
          <input type="text" placeholder="100" class="modal-input-form" name="cont_widht" required>
          -->
          <label class="form-label"><i class="fa fa-arrows-h"></i>&nbsp;<?php _e('Container width', 'wp24-termine'); ?>:</label>
          <select class="select-width-container custom-select" name="cont_widht">
          </select>

        </div>
        <div class="modal-item"></div>
      </div>
      <div class="modal-flex">
        <div class="modal-item">
          <label class="form-label"><i class="fa fa-arrows-v"></i>&nbsp;<?php _e('Margin top', 'wp24-termine'); ?>:</label>
          <input type="text" placeholder="25" class="modal-input-form" name="margin_top" required>
        </div>
        <div class="modal-item">
          <label class="form-label"><i class="fa fa-arrows-v"></i>&nbsp;<?php _e('Margin bottom', 'wp24-termine'); ?>:</label>
          <input type="text" placeholder="25" class="modal-input-form" name="margin_bottom" required>
        </div>
      </div>
      <div class="modal-flex">
        <div class="modal-item">
          <label class="form-label"><i class="fa fa-arrows-h"></i>&nbsp;<?php _e('Margin left', 'wp24-termine'); ?>:</label>
          <input type="text" placeholder="25" class="modal-input-form" name="margin_left" required>
        </div>
        <div class="modal-item">
          <label class="form-label"><i class="fa fa-arrows-h"></i>&nbsp;<?php _e('Margin right', 'wp24-termine'); ?>:</label>
          <input type="text" placeholder="25" class="modal-input-form" name="margin_right" required>
        </div>
      </div>
      <div class="modal-flex">
        <div class="modal-item">
          <label class="form-label"><i class="fa fa fa-arrows-v"></i>&nbsp;<?php _e('Padding top', 'wp24-termine'); ?>:</label>
          <input type="text" placeholder="15" class="modal-input-form" name="padding_top" required>
        </div>
        <div class="modal-item">
          <label class="form-label"><i class="fa fa fa-arrows-v"></i>&nbsp;<?php _e('Padding bottom', 'wp24-termine'); ?>:</label>
          <input type="text" placeholder="10" class="modal-input-form" name="padding_bottom" required>
        </div>
      </div>
      <div class="modal-flex">
        <div class="modal-item">
          <label class="form-label"><i class="fa fa fa-arrows-h"></i>&nbsp;<?php _e('Padding-Left', 'wp24-termine'); ?>:</label>
          <input type="text" placeholder="15" class="modal-input-form" name="padding_left" required>
        </div>
        <div class="modal-item">
          <label class="form-label"><i class="fa fa fa-arrows-h"></i>&nbsp;<?php _e('Padding-Right', 'wp24-termine'); ?>:</label>
          <input type="text" placeholder="10" class="modal-input-form" name="padding_right" required>
        </div>
      </div>

      <div class="modal-flex">
        <div class="modal-item">
          <label class="check-container">
            <?php _e('auto resize', 'wp24-termine'); ?>:
            <input class="auto-aktiv" name="auto_aktiv" type="checkbox">
            <span class="checkmark"></span>
          </label>
        </div>
        <div class="modal-item"></div>
      </div>
    <!------->
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" id="close-button" class="btn-group button-secondary"><i class="text-red fa fa-close"></i>&nbsp;<?php _e('close', 'wp24-termine'); ?></button>
    <button type="submit" class="button-primary"><i class="fa fa-save"></i>&nbsp;<?php _e('to save', 'wp24-termine'); ?></button>
   </div>
 </form>
</div>
</div>
</div>
<!------------------------------------------------------------------------------------------>
<!--DropDown Modal-->
<div id="DropModal" class="modal-overlay">
<div class="modal-wrapper" id="modal-wrapper">
<div class="modal" id="modal">
  <button class="close-button button-secondary" id="close-button"><i class="fa fa-close"></i></button>
  <div class="modal-title">
    <h2><i class="text-blue fa fa-arrows"></i>&nbsp; <?php _e('DropDown Settings', 'wp24-termine'); ?></h2>
  </div>
  <div class="modal-body">
    <div>
    <!------->
    <form autocomplete="off" class="send-apd-settings" action="#" method="post">
       <input type="hidden" class="modalMethod" name="method" />
       <input type="hidden" class="settingsID" name="id" />
       <input type="hidden" name="send_modal" value="1" />

       <div class="modal-flex">
         <div class="modal-item">
           <label class="form-label"><?php _e('Name dropdown button', 'wp24-termine'); ?>:</label>
           <input type="text" name="bezeichnung">
       </div>
         <div class="modal-item">
       </div>
     </div>
       <div class="modal-flex">
         <div class="modal-item">
           <label class="form-label"><?php _e('Background dropdown', 'wp24-termine'); ?>:</label>
           <input type="text" class="apd-color-picker" name="bg_color">
       </div>
       <div class="modal-item">
         <label class="form-label"><?php _e('Dropdown Text Color', 'wp24-termine'); ?>:</label>
         <input type="text" class="apd-color-picker" name="txt_color">
     </div>
     </div>
     <div class="modal-flex">
       <div class="modal-item">
         <label class="form-label"><?php _e('Background hover dropdown', 'wp24-termine'); ?>:</label>
         <input type="text" class="apd-color-picker" name="bg_hover_color">
     </div>
     <div class="modal-item">
       <label class="form-label"><?php _e('Dropdown font size', 'wp24-termine'); ?>:</label>
       <input type="text" name="font_size">
   </div>
 </div><br />
   <div class="modal-flex">
     <div class="modal-item">
       <label class="check-container">
         <?php _e('Show DropDown', 'wp24-termine'); ?>:
         <input class="drop-aktiv" name="drop_aktiv" type="checkbox">
         <span class="checkmark"></span>
       </label>
     </div>
     <div class="modal-item"></div>
   </div>
    <!------->
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" id="close-button" class="btn-group button-secondary"><i class="text-red fa fa-close"></i>&nbsp;<?php _e('close', 'wp24-termine'); ?></button>
    <button type="submit" class="button-primary"><i class="fa fa-save"></i>&nbsp;<?php _e('to save', 'wp24-termine'); ?></button>
   </div>
 </form>
</div>
</div>
</div>
<!--Modal-Ende-->
<div id="snackbar-success"></div>
<div id="snackbar-warning"></div>
