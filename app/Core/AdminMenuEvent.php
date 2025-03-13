<?php
namespace INITP\NAS\Core;

defined( 'ABSPATH' ) || exit;

use INITP\NAS\Core\Log;
use INITP\NAS\Config;
use INITP\NAS\Core\TopLevelMenuPage;
use INITP\NAS\Core\TopLevelRemoveSubmenuPage;
use INITP\NAS\Pages\DemoPage;

class AdminMenuEvent
{
    public static function register()
    {
        // Default
        add_action( 'admin_menu', array( __CLASS__, 'topLevelMenuPageCb' ), 1); // Add the top level menu with the highest priority
        add_action( 'admin_menu', array( __CLASS__, 'topLevelRemoveSubmenuPageCb' ), 99 ); // Remove the top level menu placeholder page with low priority
    }

    // Default
    public static function topLevelMenuPageCb()
    {
        TopLevelMenuPage::handle();
    }

    public static function topLevelRemoveSubmenuPageCb()
    {
        TopLevelRemoveSubmenuPage::handle();
    }

} // class close