<?php

/*
Plugin Name: Nanomailer for AWS SES
Description: Base option page builder plugin description.
Version: 1.0.0
Author: Init & Play
Author URI: https://initandplay.com
*/

defined( 'ABSPATH' ) || exit; // Direct access forbidden, stop.

// Helpers
require 'lib/helpers/dvsq-wp-common.php';

// Lib Autoload
if( !class_exists( 'INITP\OptionPageBuilder\Classes\Builder') )
{
    require 'lib/autoload.php'; // Conditionally load the lib autoloader
}

// App Autoload
require 'app/autoload.php';


// Check if Config exists before proceeding to bootstrap
if (!class_exists('INITP\NAS\Config')) 
{
    add_action('admin_notices', function () {
        echo '<div class="notice notice-error"><p>Plugin error for <strong>Base Option Page Builder.</strong> The <strong>Config</strong> class is missing or corrupted. The plugin cannot function properly.</p></div>';
    });

    // Prevent the plugin from executing further
    return;
}

// App Bootstrap
require 'app/bootstrap.php';