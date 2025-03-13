<?php
// No namespace for dvsq-common.php

defined( 'ABSPATH' ) || exit;

if (!function_exists('wpdd'))
{
    function wpdd( $data )
    {
        echo '<pre style="padding:20px;background-color:black;color:yellow;">';
        var_dump($data);
        echo '</pre>';
        exit();
    }
}
