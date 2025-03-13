<?php
namespace INITP\NAS\Core;

defined( 'ABSPATH' ) || exit;

use INITP\NAS\Core\Log;
use INITP\NAS\Config;

class TopLevelMenuPage
{

    public static function handle()
    {
        //
        // AdminMenuEvent calls this handler 
        //

        // Avoid duplicate Init Plugin menus by checking if the menu_page_url exists.
        if ( !menu_page_url(Config::topLevelMenuSlug(), false) )
        {
            add_menu_page(
                Config::topLevelMenuTitle(), // Page Title
                Config::topLevelMenuTitle(), // Menu Title
                'edit_users', // Capability
                Config::topLevelMenuSlug(), // Slug
                '__return_true', // callback
                'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 126.71 99.77"><path d="M11.31 88.46L22.63 99.77 66.88 55.52c3.12-3.12 3.12-8.19 0-11.31L22.63 0 11.31 11.31 49.86 49.91 11.31 88.46z" fill="black"/></svg>'),

                95,
            );
        } 
    } // handle() close

}