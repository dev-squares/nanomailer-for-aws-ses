<?php
namespace INITP\OptionPageBuilder\Classes;

defined( 'ABSPATH' ) || exit;

class BaseLog
{
    private static function logPath()
    {
        if( defined('DVSQ_LOG_STORAGE_PATH') )
        {
            return DVSQ_LOG_STORAGE_PATH . '/wp-initp.log'; // Minor integration for sites run by Init & Play sister company DevSquares.
        }
        else
        {
            return WP_CONTENT_DIR . '/wp-initp.log'; // Fallback
        }
    }

    private static function timestamp()
    {
        return date("d/m/Y h:i:s a", time());
    }

    public static function info( $message )
    {
        // Use print_r with return set to true to handle arrays and strings
        $log_data = "## [" . self::timestamp() . "] INFO :: " . print_r($message, true) . "\n";
        file_put_contents( self::logPath(), $log_data, FILE_APPEND );
    }

    public static function error( $message )
    {
        // Use print_r with return set to true to handle arrays and strings
        $log_data = "## [" . self::timestamp() . "] ERROR :: " . print_r($message, true) . "\n";
        file_put_contents( self::logPath(), $log_data, FILE_APPEND );
    }
    
} // Class close