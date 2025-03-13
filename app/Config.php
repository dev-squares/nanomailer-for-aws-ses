<?php
namespace INITP\NAS;

defined( 'ABSPATH' ) || exit;

use INITP\OptionPageBuilder\Classes\BaseConfig;

// The app class is only used to provide a path and url
class Config extends BaseConfig
{
    
    public static function pluginTitle()
    {
        return 'Nanomailer for AWS SES';
    }

    public static function validationClass() 
    {
        return \INITP\NAS\Services\Validation::class;
        //return \INITP\OptionPageBuilder\Classes\BaseValidation::class;
    }
    
}