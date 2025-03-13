<?php
namespace INITP\NAS\Events;

defined( 'ABSPATH' ) || exit;

use INITP\NAS\Core\Log;
use INITP\NAS\Config;
use INITP\NAS\Handlers\RouteWpMailToSes;

class WpMailEvent
{
    public static function register()
    {
        add_filter( 'wp_mail', array( __CLASS__, 'routeWpMailToSesCb' ), PHP_INT_MAX );
    }

    public static function routeWpMailToSesCb( $args )
    {
        // Hint: don't forget sometimes you need to prefix the handler class with return!
        return RouteWpMailToSes::handle( $args );
        // new <name>();
    }
}