<?php
namespace INITP\NAS\Core;

defined( 'ABSPATH' ) || exit;

use INITP\NAS\Core\Log;
use INITP\NAS\Config;

class TestShutdown
{
    public static function register()
    {
        add_action( 'shutdown', array(__CLASS__, 'testShutdownCb') );
    }

    public static function testShutdownCb() 
    {
        //
        // Simple test with no handler.
        //
        
        // A simple script to test that these actions are loading
        echo '<style>body{background:red!important;}</style>';
    }

}