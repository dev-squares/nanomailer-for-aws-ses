<?php
namespace INITP\NAS;

defined( 'ABSPATH' ) || exit;

use INITP\OptionPageBuilder\Classes\BaseConfig;

// The app class is only used to provide a path and url

class Config extends BaseConfig
{
    public static function validationClass() 
    {
        return \INITP\NAS\Services\Validation::class;
        //return \INITP\OptionPageBuilder\Classes\BaseValidation::class;
    }

    public static function logPrefix()
    {
        // Uses the final part of the namespace (e.g. BOBP) as the log prefix
        return substr(__NAMESPACE__, strrpos(__NAMESPACE__, '\\') + 1);        
    }
}