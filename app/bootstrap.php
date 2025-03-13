<?php
// No namespace for bootstrap.php


defined( 'ABSPATH' ) || exit;

// Check for Config.php before bootstrapping
if( !class_exists('INITP\NAS\Config') )
{
    exit('No class');
}


// CORE
\INITP\NAS\Core\AdminMenuEvent::register(); // Required


// TESTS
//\INITP\NAS\Core\TestShutdown::register(); // Outputs background-color red on <body>
//\INITP\NAS\Core\TestAdminMenuEvent::register(); // Creates the Test Page with example options.
// \INITP\NAS\Tests\ShutdownTest::register(); // Changeable


// Register all events (actions, filters, shortcodes) in the events array below.
$events = [
    \INITP\NAS\Events\AdminMenuEvent::class,
    \INITP\NAS\Events\WpMailEvent::class,
];


// Loop and register events
foreach ( $events as $event )
{
    $event::register();
}