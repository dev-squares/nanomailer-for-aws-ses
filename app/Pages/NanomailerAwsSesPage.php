<?php
namespace INITP\NAS\Pages;

defined( 'ABSPATH' ) || exit;

use INITP\OptionPageBuilder\Classes\BasePage;
use INITP\OptionPageBuilder\Classes\Builder;
use INITP\NAS\Core\Log;
use INITP\NAS\Config;

class NanomailerAwsSesPage extends BasePage
{
    public function __construct( $title, $validation_class)
    {
        // Pass the title to the parent constructor
        parent::__construct( $title, $validation_class );

        // Set ALL tabbed setting pages here
        $this->setTabs();

    }

    protected function setTabs()
    {
        $this->setSettingsTab();
    } // method close

    protected function setSettingsTab()
    {
        $this->page_tabs[] = [
            'id' => 'settings',
            'title' => 'Settings',
            'slug' => 'settings',
            // Sections
            'sections' => [
                [
                    'id' => 'behaviour',
                    'title' => 'Behaviour',
                    'callback' => '__return_false',
                    'slug' => 'behaviour',
                    // Fields
                    'fields' => [
                        [
                            'id' => 'route_wp_mail_to_ses',
                            'title' => 'Route All wp_mail() Emails to AWS SES',
                            'callback' => 'radio', // text|textInfo|email|number|textarea|select|radio|checkbox
                            'args' => [ 
                                'field_options' => [
                                    'disabled' => 'Disabled',
                                    'enabled' => 'Enabled'
                                ],
                                'desc' => 'When enabled all emails sent via wp_mail() will be routed to AWS SES. Selecting disabled stops all plugin features.',
                            ]
                        ],
                    ], // fields close
                ], // section close
                [
                    'id' => 'aws_details',
                    'title' => 'AWS Details',
                    'callback' => '__return_false',
                    'slug' => 'aws-details',
                    // Fields
                    'fields' => [
                        [
                            'id' => 'UNUSED_nas_aws_access_key',
                            'title' => 'AWS Access Key',
                            'callback' => 'textInfo', // text|textInfo|email|number|textarea|select|radio|checkbox
                            'args' => [ 
                                'class' => 'regular-text',
                                'mask' => false, // true|false - only applies to textInfo
                                'readonly' => true, // true|false
                                'constant' => 'NAS_AWS_ACCESS_KEY', // constant name - only applies to textInfo
                                'desc' => 'The Access Key for an IAM user with permission to access the SES SendEmail action. This should be defined as the php constant \'NAS_AWS_ACCESS_KEY\' in either wp-config.php or another configuration file.', 
                                ]
                        ],
                        [
                            'id' => 'UNUSED_nas_aws_secret_key',
                            'title' => 'AWS Secret Key',
                            'callback' => 'textInfo', // text|textInfo|email|number|textarea|select|radio|checkbox
                            'args' => [ 
                                'class' => 'regular-text',
                                'mask' => true, // true|false - only applies to textInfo
                                'readonly' => true, // true|false
                                'constant' => 'NAS_AWS_SECRET_KEY', // constant name - only applies to textInfo
                                'desc' => 'The Secret Key for an IAM user with permission to access the SES SendEmail action. This should be defined as the php constant \'NAS_AWS_SECRET_KEY\' in either wp-config.php or another configuration file.<br>This value will be masked for security.', 
                                ]
                        ],
                        [
                            'id' => 'region',
                            'title' => 'Region',
                            'callback' => 'text',
                            'args' => [ 
                                'mask' => false, // true|false - only applies to textInfo
                                'readonly' => false, // true|false
                                'desc' => 'The chosen AWS SES region (e.g. eu-west-2, us-east-1).',
                            ]
                        ],
                        [
                            'id' => 'send_from_email_identity',
                            'title' => 'Send From Email Identity',
                            'callback' => 'email',
                            'args' => [ 
                                'class' => 'regular-text',
                                'mask' => false, // true|false - only applies to textInfo
                                'readonly' => false, // true|false
                                'desc' => 'The email address that emails will be sent from. IMPORTANT: Either the full email address (test@example.com), or domain (@example.com), must appear with a Verified status in your AWS SES indentities list.',
                            ]
                        ],
                    ], // fields close
                ], // section close
            ], // sectionS close
        ]; // tab close
    } // method close


} // class close