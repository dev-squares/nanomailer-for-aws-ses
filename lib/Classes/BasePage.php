<?php
namespace INITP\OptionPageBuilder\Classes;

defined( 'ABSPATH' ) || exit;

use INITP\OptionPageBuilder\Classes\Builder;

class BasePage
{
    protected array $page_setup = [];
    protected array $page_tabs = [];
    protected array $page_tabs_nav = [];

    function __construct( $title, $validation_class )
    {
        // Pass the page title to the page setup method.
        // This will create the id used for options storage,
        // and the slug used for navigation and rendering sections/fields.
        $this->setPageSetup( $title );

        // Allow child classes to define their own tabs
        $this->setTabs();

        // setPageTabsNav must come after all tabs have been set
        $this->setPageTabsNav();

        // Send to builder
        new Builder( $this->getPageSetup(), $this->getPageTabs(), $this->getPageTabsNav(), $validation_class );
    }

    protected function setTabs()
    {
        $this->setFirstTab();
        $this->setSecondTab();
    } // method close


    protected function setFirstTab()
    {
        $this->page_tabs[] = [
            'id' => 'first_tab',
            'title' => 'First Tab',
            'slug' => 'first-tab',
            // Sections
            'sections' => [
                [
                    'id' => 'default_section',
                    'title' => 'Default Section',
                    'callback' => '__return_false',
                    // Fields
                    'fields' => [
                        [
                            'id' => 'example_text',
                            'title' => 'Example Text',
                            'callback' => 'text', // text|textInfo|email|number|textarea|select|radio|checkbox
                            'args' => [ 
                                'class' => 'regular-text',
                                'mask' => false, // true|false - only applies to textInfo
                                'readonly' => true, // true|false
                                'desc' => 'An example TEXT field with description.',
                            ]
                        ],
                        [
                            'id' => 'example_textarea',
                            'title' => 'Example Textarea',
                            'callback' => 'textarea',
                            'args' => [ 
                                'mask' => false, // true|false - only applies to textInfo
                                'readonly' => false, // true|false
                                'desc' => 'An example TEXTAREA field with description.',
                            ]
                        ],
                        [
                            'id' => 'example_number',
                            'title' => 'Example Number',
                            'callback' => 'number', // text|textInfo|email|number|textarea|select|radio|checkbox
                            'args' => [ 
                                'class' => 'small-text',
                                'mask' => false, // true|false - only applies to textInfo
                                'readonly' => false, // true|false
                                'constant' => 'DEMO_KEY', // constant name - only applies to textInfo
                                'min' => 0, // int
                                'max' => 100,  // int
                                'desc' => 'An example NUMBER field with description.', 
                            ]
                        ],
                        [
                            'id' => 'example_text_info',
                            'title' => 'Example Text Info',
                            'callback' => 'textInfo', // text|textInfo|email|number|textarea|select|radio|checkbox
                            'args' => [ 
                                'mask' => false, // true|false - only applies to textInfo
                                'readonly' => true, // true|false
                                'constant' => '', // constant name - only applies to textInfo
                                'desc' => 'An example text info field with description.', 
                            ]
                        ],
                    ], // fields close
                ], // section close
            ], // sectionS close
        ]; // tab close
    } // method close


    protected function setSecondTab()
    {
        $this->page_tabs[] = [
            'id' => 'second_tab',
            'title' => 'Second Tab',
            'slug' => 'second-tab',
            // Sections
            'sections' => [
                [
                    'id' => 'more_examples_default',
                    'title' => 'Default Section',
                    'callback' => '__return_false', // callback
                    // Fields
                    'fields' => [
                        [
                            'id' => 'example_select',
                            'title' => 'Example Select',
                            'callback' => 'select', // text|textInfo|email|number|textarea|select|radio|checkbox
                            'args' => [ 
                                'field_options' => [
                                    'disabled' => 'Disabled',
                                    'option a' => 'Option A',
                                    'option b' => 'Option B',
                                    'option c' => 'Option C',
                                ],
                                'desc' => 'An example SELECT field with description.',
                            ]
                        ],
                        [
                            'id' => 'example_radio',
                            'title' => 'Example Radio',
                            'callback' => 'radio', // text|textInfo|email|number|textarea|select|radio|checkbox
                            'args' => [ 
                                'field_options' => [
                                    'disabled' => 'Disabled',
                                    'option 1' => 'Option 1',
                                    'option 2' => 'Option 2',
                                    'option 3' => 'Option 3',
                                ],
                                'desc' => 'An example RADIO field with description.',
                            ]
                        ],
                        [
                            'id' => 'example_checkbox',
                            'title' => 'Example Checkbox',
                            'callback' => 'checkbox', // text|textInfo|email|number|textarea|select|radio|checkbox
                            'args' => [ 
                                'field_options' => [
                                    'option i' => 'Option i',
                                    'option ii' => 'Option ii',
                                    'option iii' => 'Option iii',
                                ],
                                'desc' => 'An example CHECKBOX field with description.',
                            ]
                        ],
                    ], // fields close
                ], // section close
            ], // sectionS close
        ]; // tab close
    } // fields close

    public function getPageTabs()
    {
        return $this->page_tabs;
    }

    protected function setPageSetup( $title )
    {
        $this->page_setup['title'] = $title;
        $title = strtolower( str_replace(['& ', '- ', 'for '], ['', '', ''], $title) ); // Note: also replaces trailing spaces
        $this->page_setup['id'] = 'initp_' .str_replace(' ', '_', $title);
        $this->page_setup['slug'] = 'initp-' . str_replace(' ', '-', $title);
    }

    public function getPageSetup()
    {
        return $this->page_setup;
    }

    protected function setPageTabsNav()
    {
        foreach ( $this->page_tabs as $tab )
        {
            $this->page_tabs_nav[ $tab['slug'] ] = $tab['title'];
        }
    }

    protected function getPageTabsNav()
    {
        return $this->page_tabs_nav;
    }

} // class close