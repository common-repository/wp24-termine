<?php
defined('ABSPATH')or die();
add_action('add_meta_boxes', 'termin_kategorieboxes');
add_action('save_post', 'apd_termine_savedata');
function termin_kategorieboxes()
{
    add_meta_box(
        'apd_termin_metabox',
        'Termine Kategorie Seite',
        'termin_kategorie_metabox',
        'apd-termin-plan',
        'side',
        'high'
    );
}

function termin_kategorie_metabox()
{
  wp_nonce_field('termine_action','termine_name');
  isset($_GET['cat_id']) && is_numeric($_GET['cat_id']) ? $cat_id = $_GET['cat_id'] : $cat_id = '';
  echo '<input type="hidden" id="cat_id" name="categorie_id" value="'.$cat_id.'" />';
  global $wpdb;
  $table = $wpdb->prefix . 'apd_category';

  $row = $wpdb->get_row("SELECT *
  FROM {$table}
   WHERE id = {$cat_id} ");
  echo '<b>'.$row->name.'</b>';
}

function apd_termine_savedata()
{
  if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return false;
  if( !current_user_can('edit_post',(int)$post_id)) return false;
  if ( !wp_verify_nonce($_POST['termine_name'],'termine_action')) return false;

    isset($_POST['categorie_id']) && is_numeric($_POST['categorie_id']) ? $id = sanitize_text_field($_POST['categorie_id']) : $id = '';

    if(!$id){
      //trigger_error('Ein Fehler ist aufgetreten.', E_USER_ERROR);
    } else {
      global $wpdb;
      $get_post = get_post($_POST['post_ID']);
      $table = $wpdb->prefix . 'apd_category';
      $wpdb->update(
        $table,
        array(
        'post_site' => 1,
        'post_id' => $_POST['post_ID'],
        'post_name'=>$get_post->post_name,
        'post_title'=>$get_post->post_title
        ),
        array( 'id' => (int) sanitize_text_field($_POST['categorie_id'])),
        array(
            '%d','%d','%s','%s'
        ),
        array( '%d' )
    );
      update_post_meta($_POST['post_ID'], '_categorie',(int) sanitize_text_field($_POST['categorie_id']), false);
    }
}

