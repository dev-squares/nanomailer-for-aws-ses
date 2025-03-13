<?php
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

    protected function route_wp_mail_to_ses( $value )
    {
        // Only allow 'disabled' or 'enabled'
        return ($value === 'enabled' || $value === 'disabled') ? $value : $this->failureMessage('The value must be either enabled or disabled.');
        
    } // method close

    protected function region($value)
    {
        // AWS region regex pattern
        $pattern = '/^(us|ca|sa|eu|ap|me|af)-(gov-)?(north|south|east|west|central)-\d$/';
    
        // Validate region format
        return (is_string($value) && preg_match($pattern, $value)) ? $value : $this->failureMessage('The value must be a valid AWS region.');
    
    } // method close

    protected function send_from_email_identity($value)
    {
        // Validate email format
        return (is_string($value) && filter_var($value, FILTER_VALIDATE_EMAIL)) ? $value : $this->failureMessage('The value must be a valid email address.');

    } // method close

}