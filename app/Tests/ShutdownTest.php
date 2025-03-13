<?php
namespace INITP\NAS\Tests;

defined( 'ABSPATH' ) || exit;

use INITP\NAS\Utilities\Log;
use INITP\NAS\Config\Plugin;

class ShutdownTest
{
    public static function register()
    {
        add_action( 'shutdown', array(__CLASS__, 'shutdownTestCb') );
    }

    public static function shutdownTestCb() 
    {
        //
        // TestShutdownEvent calls this handler 
        //
        
        // A simple script to test that these actions are loading
        // echo '<style>body{background:red!important;}</style>';

        $to = 'stephen_spary@hotmail.com'; // Change this to your test email
        $subject = 'WP Mail Test';
        $message = 'This is a test email from ' . get_bloginfo('name') . '.';
        $headers = ['Content-Type: text/html; charset=UTF-8'];

        $sent = wp_mail($to, $subject, $message, $headers);
    }

}