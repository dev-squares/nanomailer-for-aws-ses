<?php
namespace INITP\OptionPageBuilder\Classes;

defined('ABSPATH') || exit;

class BaseValidation
{
    protected string|array $value = '';
    protected string $field_id = '';
    protected $response = '';


    public function __construct( $field_id, $value )
    {
        $this->field_id = $field_id;
        $this->setValue($value);
        $this->setResponse();
    } // method close


    protected function setValue( $value )
    {
        if ( is_string($value) )
        {
            $value = $this->sanitiseString($value);
        } 
        elseif ( is_array($value) )
        {
            $value = array_map( [$this, 'sanitiseString'], $value );
        }

        $this->value = $value;
    } // method close


    public function getValue()
    {
        return $this->value;
    } // method close

    
    protected function sanitiseString( $value )
    {
        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8'); // Convert encoding
        $value = trim($value); // Trim spaces
        $value = str_replace(["\r\n", "\r"], "\n", $value); // Normalize line breaks
        $value = preg_replace('/[\x00-\x1F\x7F]/u', '', $value); // Remove control characters
        $value = strip_tags($value); // Strip HTML tags

        return $value;
    } // method close


    protected function setResponse()
    {
        if ( method_exists($this, $this->field_id) )
        {
            $this->response = $this->{$this->field_id}( $this->getValue() );
        } 
        else 
        {
            $this->response = $this->getValue(); // No specific validator found, return original value
        }
    } // method close

    
    public function getResponse()
    {
        return $this->response;
    } // method close

    public function failureMessage( $message )
    {
        return 'Field not saved. Validation failed for "' . $this->field_id . '". ' . $message;
    }

}
