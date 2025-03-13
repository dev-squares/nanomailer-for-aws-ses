<?php
namespace INITP\OptionPageBuilder\Classes;

defined( 'ABSPATH' ) || exit;

use INITP\OptionPageBuilder\Classes\Page;
use INITP\OptionPageBuilder\Classes\Log;

class Builder
{
    private string $page_title = '';
    private string $page_id = '';
    private string $page_slug = '';
    private array $page_tabs = [];
    private array $page_tabs_nav =[];
    private string $validation_class = '';
    private string $error_notices = '';
    

    function __construct(  $page_setup, $page_tabs, $page_tabs_nav, $validation_class )
    {
        $this->page_title = $page_setup['title'];
        $this->page_id = $page_setup['id'];
        $this->page_slug = $page_setup['slug'];
        $this->page_tabs = $page_tabs;
        $this->page_tabs_nav = $page_tabs_nav;
        $this->validation_class = $validation_class;

        $this->registerSetting();
        $this->addSubmenuPage();
        $this->addSettingsSectionsAndFields();

        add_action( 'admin_notices', [$this, 'getErrorNotices'] );

    } // method close


    private function registerSetting() 
    {
        register_setting(
            $this->page_id, // options group
            $this->page_id, // options name
            [
                'sanitize_callback' => function( $options ) {
                    return self::saveAllAndValidate( $options );
                }
            ]
        );
    } // method close


    private function addSubmenuPage() 
    {
        add_submenu_page(
            'initp', // parent slug
            $this->page_title, // page title
            $this->page_title, // menu title
            'manage_options', // capability
            $this->page_slug, // menu slug
            function() {
                return Page::tabbed($this->page_title, $this->page_id, $this->page_slug, $this->page_tabs_nav);
            },
            null // position
        );
    } // method close


    private function addSettingsSectionsAndFields()
    {        
        // Loop through all tabs to create its related sections and fields
        foreach ( $this->page_tabs as $tab )
        {
            foreach ( $tab['sections'] as $section )
            {
                add_settings_section(
                    $section['id'], // id
                    $section['title'], // title
                    $section['callback'], // callback 
                    $this->page_slug . '&tab=' . $tab['slug'] // page slug that shows section
                );

                foreach( $section['fields'] as $field )
                {
                    add_settings_field(
                        $field['id'],
                        $field['title'], 
                        function($args) use ($field) {
                            $field_instance = new Field($args);
                            echo $field_instance->render( $field['callback'] );
                        },
                        $this->page_slug . '&tab=' . $tab['slug'],
                        $section['id'],
                        array_merge($field['args'], [ 'label_for' => $field['id'], 'option_name' => $this->page_id ] )
                    );
                } 
            }
        }
    } // method close
    

    private function saveAllAndValidate( $saved_options )
    {
        // Retrieve existing settings from the database
        $existing_options = get_option( $this->page_id, [] );
        $validated_passed = [];
        $validated_failed = [];

        foreach ( $saved_options as $field_id => $value )
        {
            if( $value === '' )
            {
                // There is NO value to validate
                $validated_passed[$field_id] = $value;
                continue;
            }

            // Still here

            $validation_instance = new $this->validation_class( $field_id, $value );

            // An array should never be returned. If any array fails validation
            // ALL values should be removed and a string returned.
            if( 
                !is_array($validation_instance->getResponse()) &&
                str_starts_with( $validation_instance->getResponse(), 'Field not saved. Validation failed for' ) 
            ){
                $validated_failed[$field_id] = $validation_instance->getResponse(); // Failed. Set failed
            }
            else
            {
                $validated_passed[$field_id] = $validation_instance->getResponse(); // Passed
            }

        }

        // Handle failed
        if( !empty($validated_failed) )
        {
            foreach( $validated_failed as $field_id => $validation_message )
            {
                $this->setErrorNotices( $validation_message );
            }
        }

        // Merge existing with values that passed validation
        return array_merge($existing_options, $validated_passed);

    } // method close


    private function setErrorNotices($validation_message)
    {
        $this->error_notices .= '<div class="notice notice-error"><p>' . $validation_message . '</p></div>';
        set_transient('initp_error_notices', $this->error_notices, 30); // Store temporarily for 30 seconds
    } // method close


    public function getErrorNotices()
    {
        $this->error_notices = get_transient('initp_error_notices');
    
        if (!empty($this->error_notices))
        {
            echo $this->error_notices;
            delete_transient('initp_error_notices'); // Remove after displaying
        }
    } // method close

} // class close
