<?php
namespace INITP\NAS\Core;

defined( 'ABSPATH' ) || exit;

use INITP\OptionPageBuilder\Classes\Builder;
use INITP\OptionPageBuilder\Classes\BasePage;
use INITP\NAS\Core\Log;
use INITP\NAS\Config;
use INITP\NAS\Pages\Page;

class TestPage extends BasePage
{
    public function __construct( $title, $validation_class )
    {
        // Pass the title to the parent constructor
        parent::__construct( $title, $validation_class );

        // Set ALL tabbed setting pages here
        // $this->setTabs();

    }

    /*
    protected function setTabs()
    {
        // Create new tabs here and UNCOMMENT this method AND the $this->setTabs() in the constructor above.
    }
    */


} // class close