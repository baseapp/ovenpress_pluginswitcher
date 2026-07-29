<?php

if (! defined('ABSPATH')) exit;

require_once __DIR__ . '/libraries/plugin-update-checker/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/baseapp/ovenpress_pluginswitcher',
    OVENPRESS_PLUGIN_SWITCHER_ROOT_PL,
    'ovenpress-plugin-switcher'
);

$myUpdateChecker->getVcsApi()->enableReleaseAssets();
