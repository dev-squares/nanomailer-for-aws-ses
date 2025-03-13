<?php
namespace INITP\NAS\Services;

defined( 'ABSPATH' ) || exit;

use INITP\NAS\Core\Log;
use INITP\NAS\Config;

class AwsSesApiSendEmail
{
    public static function process( $to_email, $subject, $message, $from_email, $access_key, $secret_key, $region ) 
    {
        // AWS credentials and region
        // $access_key is passed
        // $secret_key is passed
        // $region is passed
        $service = 'ses';
        $method = 'POST';
        $uri = '/v2/email/outbound-emails';
    
        // Email payload (JSON body)
        $body = json_encode([
            'FromEmailAddress' => $from_email,
            'Destination' => [
                'ToAddresses' => [$to_email],
            ],
            'Content' => [
                'Simple' => [
                    'Subject' => [
                        'Data' => $subject,
                        'Charset' => 'UTF-8',
                    ],
                    'Body' => [
                        'Text' => [
                            'Data' => $message,
                            'Charset' => 'UTF-8',
                        ],
                        // Optionally, add HTML content
                        'Html' => [
                            'Data' => "<p>$message</p>",
                            'Charset' => 'UTF-8',
                        ],
                    ],
                ],
            ],
        ]);
    
        // Generate AWS Signature Version 4 headers
        $headers = self::AwsSignRequest($method, $uri, '', $body, $region, $service, $access_key, $secret_key);

        Log::info($body);
        Log::info('SES API Request Headers: ' . print_r($headers, true));
    
        // Make the API request using wp_remote_post
        $response = wp_remote_post("https://email.$region.amazonaws.com$uri", [
            'method' => $method,
            'headers' => $headers,
            'body' => $body,
            'timeout' => 15,
        ]);
    
        // Handle the response
        if (is_wp_error($response))
        {
            return [
                'success' => false,
                'error' => $response->get_error_message(),
            ];
        }
    
        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
    
        if ($response_code === 200)
        {
            return [
                'success' => true,
                'message_id' => json_decode($response_body)->MessageId,
            ];
        }
        else
        {
            return [
                'success' => false,
                'error' => "Failed to send email. HTTP Code: $response_code. Response: $response_body",
            ];
        }
    } // method close


    private static function awsSignRequest( $method, $uri, $query_params, $body, $region, $service, $access_key, $secret_key )
    {
        $host = "email.$region.amazonaws.com";
        $endpoint = "https://$host$uri";
        $timestamp = gmdate('Ymd\THis\Z');
        $date = gmdate('Ymd');
    
        // Step 1: Canonical Request
        $hashed_body = hash('sha256', $body);
        $canonical_request = "$method\n$uri\n$query_params\nhost:$host\n\nhost\n$hashed_body";
    
        // Step 2: String to Sign
        $algorithm = 'AWS4-HMAC-SHA256';
        $credential_scope = "$date/$region/$service/aws4_request";
        $string_to_sign = "$algorithm\n$timestamp\n$credential_scope\n" . hash('sha256', $canonical_request);
    
        // Step 3: Signing Key
        $k_date = hash_hmac('sha256', $date, 'AWS4' . $secret_key, true);
        $k_region = hash_hmac('sha256', $region, $k_date, true);
        $k_service = hash_hmac('sha256', $service, $k_region, true);
        $k_signing = hash_hmac('sha256', 'aws4_request', $k_service, true);
    
        // Step 4: Signature
        $signature = hash_hmac('sha256', $string_to_sign, $k_signing);
    
        // Step 5: Authorization Header
        $authorization = "$algorithm Credential=$access_key/$credential_scope, SignedHeaders=host, Signature=$signature";
    
        return [
            'Host' => $host,
            'X-Amz-Date' => $timestamp,
            'Authorization' => $authorization,
            'Content-Type' => 'application/json',
        ];
    } // method close
}