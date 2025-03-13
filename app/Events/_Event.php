<?php /*
namespace INITP\NAS\Events;

defined( 'ABSPATH' ) || exit;

use INITP\NAS\Core\Log;
use INITP\NAS\Config;
// use INITP\NAS\Handlers\<name>;

class <name>Event
{
    public static function register()
    {
        add_action( '<name>', array( __CLASS__, '<name>Cb' ) );
        add_filter( '<name>', array( __CLASS__, '<name>Cb' ) );
        add_shortcode( '<name>', array( __CLASS__, '<name>Cb' ) );
    }

    public static function <name>Cb()
    {
        // Hint: don't forget sometimes you need to prefix the handler class with return!
        // <name>::handle();
        // new <name>();
    }
}