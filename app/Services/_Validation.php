<?php /*
namespace INITP\NAS\Services;

defined('ABSPATH') || exit;

use INITP\OptionPageBuilder\Classes\BaseValidation;
use INITP\NAS\Core\Log;
use INITP\NAS\Config;

class Validation extends BaseValidation
{

    public function __construct($field_id, $value)
    {
        parent::__construct($field_id, $value);
    }

    //
    //protected function <field_id>( $value )
    //{
    //    return is_numeric($value) ? $value : $this->failureMessage('value must be numeric.');
    //}

    /* UNCOMMENT TO OVERRIDE the BaseValidation sanitiseString method

    protected function sanitiseString( $value )
    {
        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8'); // Convert encoding
        $value = trim($value); // Trim spaces
        $value = str_replace(["\r\n", "\r"], "\n", $value); // Normalize line breaks
        $value = preg_replace('/[\x00-\x1F\x7F]/u', '', $value); // Remove control characters
        $value = strip_tags($value); // Strip HTML tags

        return $value;
    } // method close
        
    
}