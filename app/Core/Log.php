<?php
namespace INITP\NAS\Core;

defined('ABSPATH') || exit;

use INITP\OptionPageBuilder\Classes\BaseLog;
use INITP\NAS\Config;

class Log extends BaseLog
{
    private static function formatMessage( $message )
    {
        return Config::logPrefix() . " :: " . print_r($message, true);
    }

    public static function info( $message )
    {
        parent::info(self::formatMessage( $message ));
    }

    public static function error( $message )
    {
        parent::error(self::formatMessage( $message ));
    }
}