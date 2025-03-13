<?php
namespace INITP\NAS\Core;

defined( 'ABSPATH' ) || exit;

use INITP\NAS\Core\Log;
use INITP\NAS\Config;

class TopLevelRemoveSubmenuPage
{
    public static function handle()
    {
        //
        // AdminMenuEvent calls this handler 
        //

        // Remove the default/placeholder submenu page that is blank.
        if( menu_page_url('initp', false) )
        {
            remove_submenu_page( 'initp', 'initp' );
        }
    } // handle() close

}