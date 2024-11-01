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
class WP24_Termine_Plugin
{
    public function execute()
    {
        register_activation_hook(__FILE__, array($this,'activate'));
        add_action('init', array($this, 'load_plugin_textdomain'));
        add_action('admin_menu', array($this, 'register_apd_termin_admin_menu' ));
        add_action('template_redirect', array($this,'apg_user_public_one_trigger_check'));
        add_action('wp_ajax_add_apgHandle', array($this, 'prefix_ajax_add_apgHandle'));
        add_action('wp_ajax_nopriv_add_apgNoAdmin', array($this, 'prefix_ajax_add_apgNoAdmin' ));
        add_action('wp_ajax_add_apgNoAdmin', array($this, 'prefix_ajax_add_apgNoAdmin' ));
        add_action('plugins_loaded', array($this, 'apd_template_ArtPictureFilters' ));
        add_action('plugins_loaded', array($this, 'load_db_daten' ));
        add_action('plugins_loaded', array($this, 'apd_db_update_db' ));
        add_action('plugins_loaded', array($this, 'maybe_self_deactivate' ));
        add_action('init', array($this, 'register_post_types' ));
        add_action('init', array($this, 'artPicture_termine_metbox' ));
    }

    //ACTIVATE-HOOK
    public function activate()
    {
        $this->apd_create_db();
        $this->check_dependencies();
        $this->register_post_types();
        flush_rewrite_rules();
    } //activate ENDE

    public function load_plugin_textdomain()
    {
      load_plugin_textdomain('wp24-termine', false, dirname(APD_TERMINE_SLUG_PATH) . '/language/');
    }

    //Register Admin Menu
    public function register_apd_termin_admin_menu()
    {
        //startseite
        $hook_suffix = add_menu_page(
            __('Events', 'wp24-termine'),
            __('AP24 Events', 'wp24-termine'),
            'manage_options',
            'wp-artPictures',
            array($this, 'apd_page_termine_startseite'),
            plugins_url('../assets/images/logo.png', __FILE__, '2.1')
      );

        add_action('load-' . $hook_suffix, array($this, 'apd_load_ajax_plugin_optionen_script' ));

        $hook_suffix = add_submenu_page(
            'wp-artPictures',
            __('AP24 plans', 'wp24-termine'),
            __('AP24 plans', 'wp24-termine'),
            'manage_options',
            'art-Picture-termine',
            array($this,'apd_page_termine' )
        );
        add_action('load-' . $hook_suffix, array($this, 'apd_load_ajax_plugin_optionen_script' ));
    }

    //PAGES
    public function apd_page_termine_startseite()
    {
        require_once('pages/termine-startseite.php');
    }
    //EVENT SITE
    public function apd_page_termine()
    {
        require_once('pages/termine-events.php');
    }

    //AJAX PLUGIN HANDLE
    public function prefix_ajax_add_apgHandle()
    {
        check_ajax_referer('apd_termin_handle');
        require_once('ajax/form/plugin-formular.php');
        wp_send_json($responseJson);
    }

    //AJAX PUBLIC HANDLE
    public function prefix_ajax_add_apgNoAdmin()
    {
        check_ajax_referer('apd_public_handle');
        require_once('ajax/form/public-formular.php');
        wp_send_json($responseJson);
    }

    //PLUGIN JAVASCRIPT
    public function apd_load_ajax_plugin_optionen_script()
    {
        wp_enqueue_script(
            'ajax-script',
            plugins_url('wp24-termine/lib/js/plugin-optionen.js'),
            array( 'jquery' )
      );

        $title_nonce = wp_create_nonce('apd_termin_handle');
        wp_localize_script('ajax-script', 'apd_ajax_obj', array(
          'ajax_url' => admin_url('admin-ajax.php'),
          'nonce'    => $title_nonce ));
    }

    //PUBLIC FORMULARE
    public function apg_user_public_one_trigger_check()
    {
        //AJAX HANDLE
        wp_enqueue_script(
            'ajax-script',
            plugins_url('wp24-termine/lib/js/public-optionen.js'),
            array( 'jquery' )
      );
        $title_nonce = wp_create_nonce('apd_public_handle');
        wp_localize_script('ajax-script', 'apd_ajax_obj', array(
          'ajax_url' => admin_url('admin-ajax.php'),
          'nonce'    => $title_nonce,
        ));
    }

    public function apd_template_ArtPictureFilters()
    {
      add_filter('init', 'apd_ajax_template_trigger');
        function apd_ajax_template_trigger()
        {
            global $wp;
            $wp->add_query_var('apd-termine-json');
        }
        add_action('template_redirect', 'apd_ajax_template_script_trigger_check');
        function apd_ajax_template_script_trigger_check() {
          if(get_query_var('apd-termine-json') == 'get-termine'){
            require_once('ajax/form/json-out.php');
            exit;
          }
        }
    }

    /*==============================================
    =============LOAD DATENBANK CLASS===============
    ================================================
    */
    public function load_db_daten()
    {
        require_once('php/plugin_db.php');

        if (!function_exists('apd_container_style')) {
            function apd_container_style()
            {
              $plugin_groups = new APD\ArtDesign\TerminPluginDB();
              $groups = $plugin_groups->get_groups();
              $group_arr = array();
              foreach ($groups as $tmp) {
                  $plugin_groups->id = $tmp->sett_id;
                  $settings = $plugin_groups->get_settings_by_id();
                  if($settings->auto_resize ? $resize = true : $resize = false);
                  $group_item = array(
                "random" => $tmp->shortcode,
                "container_widht" => $settings->container_widht,
                "auto_resize" => $resize
              );
                  array_push($group_arr, $group_item);
              }
                wp_register_script('apd-container-handle', '', [], '', true);
                wp_enqueue_script('apd-container-handle');
                wp_add_inline_script('apd-container-handle',
'/* <![CDATA[ */
var apd_termine_settings = { container: '.json_encode($group_arr).'};
/* ]]> */');
          }
        }

        add_action('wp_enqueue_scripts', 'apd_container_style');
    }

    //CREATE DB
    public function apd_create_db()
    {
        require_once('db/create-database.php');
        jal_install();
    }

    //UPDATE-DB
    public function apd_db_update_db()
    {
        require_once('db/create-database.php');
        apd_update_db_check();
    }

    //CUSTOM POST
    public function register_post_types()
    {
        register_post_type(
            'apd-termin-plan',
            array(
              'labels' => array(
                'name'=> 'Terminplan Seite',
                'singular_name'=>'Terminplan',
                'edit_item'=>'Edit Terminplan',
                'items_list_navigation' =>'Terminplan list navigation',
                'add_new_item'=>'Neue Terminplan Seite erstellen',
                'archives'=>'Item Archives',
                ),
              'public'              => true,
              'show_in_rest'        => true,
              'show_ui'             => true,
              'show_in_menu'        => false,
              'has_archive'         => true,
              'show_in_nav_menus'   => true,
              'exclude_from_search' => false,
              'supports'=>array(
                'title', 'custom-fields', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions','page-attributes','editor'
                ),
            //  'taxonomies'  => array( 'category', 'post_tag' ),
            )
        );
    }

    public function artPicture_termine_metbox()
    {
        require_once('meta-boxes/kategorie-boxes.php');
    }
    //VERSIONS-CHECK
    public function check_dependencies()
    {
        global $wp_version;
        $php = '7';
        $wp  = '5';
        if (version_compare(PHP_VERSION, $php, '<')) {
            trigger_error('Dieses Plugin kann nicht aktiviert werden, da es eine PHP-Version größer als %1$s benötigt. Ihre PHP-Version kann von Ihrem Hosting-Anbieter aktualisiert werden.', E_USER_ERROR);
        }
    }

    //SELF-DIACTIVATE
    public function maybe_self_deactivate()
    {
        if (version_compare(PHP_VERSION, $php, '<')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
            deactivate_plugins(dirname(plugin_basename(__FILE__)));
            add_action('admin_notices', array( $this, 'self_deactivate_notice' ));
        }
    }
    //ADMIN-NOTIZ
    public function admin_notices()
    {
        echo '<div class="error"><p>Dieses Plugin wurde deaktiviert, da es eine PHP-Version größer als %1$s benötigt. Ihre PHP-Version kann von Ihrem Hosting-Anbieter aktualisiert werden.</p></div>';
    }

    public function self_deactivate_notice()
    {
        ?>
    <div class="notice notice-error">
        Dieses Plugin wurde deaktiviert, da es eine PHP-Version größer als %1$s benötigt. Ihre PHP-Version kann von Ihrem Hosting-Anbieter aktualisiert werden.
    </div>
    <?php
    }
}//endClass

$apd_termine_plugin = new WP24_Termine_Plugin();
$apd_termine_plugin->execute();
