<?php
namespace INITP\OptionPageBuilder\Classes;

defined( 'ABSPATH' ) || exit;

use INITP\OptionPageBuilder\Classes\Log;

class Page
{
    public static function tabbed( $page_title, $page_id, $page_slug, $page_tabs )
    {
        // Get settings updated message(s) or error(s)
        if ( isset( $_GET['settings-updated'] ) )
        {
            //add settings saved message with the class of "updated"
            add_settings_error( $page_id . '_messages', $page_id . '_message', __( 'Settings Saved', $page_id ), 'updated' );
        }
       
        // Get settings updated message/error
        settings_errors( $page_id . '_messages' );

        $current_tab = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : array_key_first($page_tabs);

        ?>
        <div class="wrap">
            <h1><?php echo $page_title; ?></h1>
            <h2 class="nav-tab-wrapper">
                <?php foreach ($page_tabs as $tab_slug => $tab_title): ?>
                    <a href="?page=<?php echo $page_slug; ?>&tab=<?php echo $tab_slug; ?>" 
                       class="nav-tab <?php echo $current_tab === $tab_slug ? 'nav-tab-active' : ''; ?>">
                        <?php echo $tab_title; ?>
                    </a>
                <?php endforeach; ?>
            </h2>
            <form method="post" action="options.php">
                <?php
                settings_fields( $page_id );
                do_settings_sections( $page_slug .'&tab=' . $current_tab );
                submit_button();
                ?>
            </form>
        </div>
        <?php
        
    } // tabbed close

} // class close