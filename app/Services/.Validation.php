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

}