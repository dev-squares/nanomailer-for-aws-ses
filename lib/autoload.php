<?php
// No namespace in autoload.php

defined('ABSPATH') || exit;

spl_autoload_register(function ($class) 
{
    $namespace = 'INITP\\OptionPageBuilder\\Classes\\';
    $base_dir = __DIR__ . '/Classes/';

    // Check if the class starts with the namespace
    if (strncmp($class, $namespace, strlen($namespace)) === 0)
    {
        // Get the relative class name by removing the namespace prefix
        $relative_class = substr($class, strlen($namespace));

        // Convert namespace separators to directory separators
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        if (file_exists($file))
        {
            require $file;
        }
    }
});