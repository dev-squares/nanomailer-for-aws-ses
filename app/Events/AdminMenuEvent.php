<?php
namespace INITP\NAS\Events;

defined( 'ABSPATH' ) || exit;

use INITP\NAS\Core\Log;
use INITP\NAS\Config;
use INITP\NAS\Pages\NanomailerAwsSesPage;

class AdminMenuEvent
{
    public static function register()
    {
        add_action( 'admin_menu', array( __CLASS__, 'nanomailerAwsSesPageCb' ), 10 ); // The Builder makes additional calls to admin_menu with priority 20
    }

    // Plugin Specific
    public static function nanomailerAwsSesPageCb()
    {
        new NanomailerAwsSesPage( 'Nanomailer for AWS SES', Config::validationClass() );
    }

} // class close