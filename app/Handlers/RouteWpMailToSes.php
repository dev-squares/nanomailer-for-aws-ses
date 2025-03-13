<?php 
namespace INITP\NAS\Handlers;

defined( 'ABSPATH' ) || exit;

use INITP\NAS\Core\Log;
use INITP\NAS\Config;
use INITP\NAS\Services\AwsSesApiSendEmail;

class RouteWpMailToSes
{

    public static function handle( $args )
    {
        //
        // WpMailEvent calls this handler 
        //

        // Get the related option and return conditionally return
        //$option = get_option($id);
        $option = get_option('initp_nanomailer_aws_ses') ?? false;
        if (!$option) { 
            return $args; 
        }

        switch( true )
        {
            case empty($option['route_wp_mail_to_ses']) || $option['route_wp_mail_to_ses'] === 'disabled':
                return $args; // Gracefully return.
            case !defined('NAS_AWS_ACCESS_KEY') || empty(NAS_AWS_ACCESS_KEY):
            case !defined('NAS_AWS_SECRET_KEY') || empty(NAS_AWS_SECRET_KEY):
            case empty($option['region']):
            case empty($option['send_from_email_identity']):
                // Error
                Log::error('Routing wp_mail() to AWS SES failed. Please check all values in the Settings tab are correct.');
                return $args; // Gracefully return.
        }

        // Still here...

        $result = AwsSesApiSendEmail::process( $args['to'], $args['subject'], $args['message'], $option['send_from_email_identity'], NAS_AWS_ACCESS_KEY, NAS_AWS_SECRET_KEY, $option['region'] );
    
        if ( !$result['success'] )
        {
            Log::error( 'Failed to send SES email: ' . $result['error'] );
            return $args; // Gracefully return.
        }

         // Still here...

         // Success!
         return false; // Return false to prevent further wp_mail() processing/sending
        
    } // method close

} // clase close