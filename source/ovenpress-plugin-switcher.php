<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.wpoven.com/plugins/
 * @since             1.0.0
 * @package           Ovenpress_Plugin_Switcher
 *
 * @wordpress-plugin
 * Plugin Name:       OvenPress Plugin Switcher
 * Plugin URI:        https://www.wpoven.com/plugins/ovenpress-plugin-switcher
 * Description:       Allows users to quickly enable or disable plugins as per need. 
 * Version:           1.1.7
 * Author:            WPOven
 * Author URI:        https://www.wpoven.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ovenpress-plugin-switcher
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('OVENPRESS_PLUGIN_SWITCHER_VERSION', '1.1.7');
if (!defined('OVENPRESS_PLUGIN_SWITCHER_SLUG'))
	define('OVENPRESS_PLUGIN_SWITCHER_SLUG', 'ovenpress-plugin-switcher');

define('OVENPRESS_PLUGIN_SWITCHER', 'OvenPress Plugin Switcher');
define('OVENPRESS_PLUGIN_SWITCHER_ROOT_PL', __FILE__);
define('OVENPRESS_PLUGIN_SWITCHER_ROOT_URL', plugins_url('', OVENPRESS_PLUGIN_SWITCHER_ROOT_PL));
define('OVENPRESS_PLUGIN_SWITCHER_ROOT_DIR', dirname(OVENPRESS_PLUGIN_SWITCHER_ROOT_PL));
define('OVENPRESS_PLUGIN_SWITCHER_PLUGIN_DIR', plugin_dir_path(__DIR__));
define('OVENPRESS_PLUGIN_SWITCHER_PLUGIN_BASE', plugin_basename(OVENPRESS_PLUGIN_SWITCHER_ROOT_PL));
define('OVENPRESS_SWITCHER_PATH', realpath(plugin_dir_path(OVENPRESS_PLUGIN_SWITCHER_ROOT_PL)) . '/');

if (file_exists(plugin_dir_path(__FILE__) . 'includes/class-ovenpress-plugin-switcher-updater.php')) {
	require_once plugin_dir_path(__FILE__) . 'includes/class-ovenpress-plugin-switcher-updater.php';
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ovenpress-plugin-switcher-activator.php
 */
function activate_ovenpress_plugin_switcher()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-ovenpress-plugin-switcher-activator.php';
	Ovenpress_Plugin_Switcher_Activator::activate();

	if (empty(get_option('ovenpress-plugin-switcher-status')) || get_option('ovenpress-plugin-switcher-status')) {
		update_option('ovenpress-plugin-switcher-status', 'active');
	} else {
		add_option('ovenpress-plugin-switcher-status', 'active');
	}
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ovenpress-plugin-switcher-deactivator.php
 */
function deactivate_ovenpress_plugin_switcher()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-ovenpress-plugin-switcher-deactivator.php';
	Ovenpress_Plugin_Switcher_Deactivator::deactivate();

	if (empty(get_option('ovenpress-plugin-switcher-status')) || get_option('ovenpress-plugin-switcher-status')) {
		update_option('ovenpress-plugin-switcher-status', 'deactive');
	} else {
		add_option('ovenpress-plugin-switcher-status', 'deactive');
	}

	$mu_plugins_dir_path = WP_CONTENT_DIR . '/' . 'mu-plugins';
	$mu_plugin_file_path = $mu_plugins_dir_path . '/class-ovenpress-plugin-switcher-mu-plugin.php';
	if (file_exists($mu_plugin_file_path)) {
		wp_delete_file($mu_plugin_file_path);
	}
}

register_activation_hook(__FILE__, 'activate_ovenpress_plugin_switcher');
register_deactivation_hook(__FILE__, 'deactivate_ovenpress_plugin_switcher');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-ovenpress-plugin-switcher.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ovenpress_plugin_switcher()
{
	$plugin = new Ovenpress_Plugin_Switcher();
	$plugin->run();
}
run_ovenpress_plugin_switcher();

function ovenpress_plugin_switcher_plugin_settings_link($links)
{

	$settings_link = '<a href="' . admin_url('admin.php?page=' . OVENPRESS_PLUGIN_SWITCHER_SLUG) . '">Settings</a>';

	array_push($links, $settings_link);
	return $links;
}

add_filter('plugin_action_links_' . OVENPRESS_PLUGIN_SWITCHER_PLUGIN_BASE, 'ovenpress_plugin_switcher_plugin_settings_link');
