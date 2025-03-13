<?php
namespace INITP\NAS\Core;

defined( 'ABSPATH' ) || exit;

use INITP\NAS\Core\Log;
use INITP\NAS\Config;
use INITP\NAS\Core\TestAdminHead;

class AdminHeadEvent
{
    public static function register()
    {
        add_action( 'admin_head', array(__CLASS__, 'testAdminHeadCb') );
    }

    public static function testAdminHeadCb() 
    {
        TestAdminHead::handle();
    }

}