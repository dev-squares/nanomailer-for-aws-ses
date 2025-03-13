<?php
namespace INITP\NAS\Core;

defined( 'ABSPATH' ) || exit;

use INITP\NAS\Core\Log;
use INITP\NAS\Config;
use INITP\NAS\Core\TopLevelMenuPage;
use INITP\NAS\Core\TopLevelRemoveSubmenuPage;
use INITP\NAS\Core\TestPage;

class TestAdminMenuEvent
{
    public static function register()
    {
        // Default
        add_action( 'admin_menu', array( __CLASS__, 'testPageCb' ), 10 ); // The Builder makes additional calls to admin_menu with priority 20
    }

    public static function testPageCb()
    {
        // Hint: don't forget sometimes you need to prefix the handler class with return!
        // <name>::handle();
        new TestPage('Test Page', Config::validationClass() );
    }

} // class close