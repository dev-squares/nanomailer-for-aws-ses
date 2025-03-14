<?php
namespace INITP\OptionPageBuilder\Classes;

defined( 'ABSPATH' ) || exit;

// The app class is only used to provide a path and url
class BaseConfig
{
    public static function pluginTitle()
    {
        return 'Option Page Builder Base';
    }

    public static function validationClass() 
    {
        //return \INITP\OPBB\Services\Validation::class;
        return \INITP\OptionPageBuilder\Classes\BaseValidation::class;
    }

    public static function topLevelMenuTitle() 
    {
        return 'Init & Play';
    }

    public static function topLevelMenuSlug() 
    {
        return 'initp';
    }
    
    public static function path() 
    {
        return dirname(__DIR__, 2);
    }

    public static function url() 
    {
        return untrailingslashit( plugin_dir_url( dirname(__DIR__, 1) ) );
    }

}