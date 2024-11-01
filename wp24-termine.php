<?php
/*
Plugin Name: WP24 EVENTS
Description: Schedule for recurring appointments. Create unlimited weekly schedules.
Version: 1.0.1
Text Domain: wp24-termine
Author: Jens Wiecker
Domain Path: /languages/
Plugin URI: https://web-projekt24.de/termine-plugin-von-webprojekt24/
Author URI: https://web-projekt24.de
*/

/**
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License, version 3, as
* published by the Free Software Foundation.

* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.

* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
**/

define('APD_TERMINE_SLUG_PATH',	plugin_basename(__FILE__));
define('APD_TERMINE_PLUGIN_URL', plugins_url('wp24-termine'));
define('APD_TERMINE_VERSION', '1.0.1' );
define('APD_TERMINE_DB_VERSION', '1.0.0' );
define('APD_TERMINE_PLUGIN_DIR', dirname(__FILE__));
define('APD_TERMINE_PLUGIN_FILE', __FILE__ );

require_once('lib/register_apd_plugin.php');
/**
 * Enqueue scripts and styles.
 */
require_once('lib/enqueue.php');
/**
 * Termine shortcodes
 */
require_once('lib/shortcodes.php');
