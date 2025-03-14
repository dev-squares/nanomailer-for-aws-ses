<?php /*
namespace INITP\NAS\Core;

defined( 'ABSPATH' ) || exit;

use INITP\OptionPageBuilder\Classes\BasePage;
use INITP\OptionPageBuilder\Classes\Builder;
use INITP\NAS\Core\Log;
use INITP\NAS\Config;

class TestPage extends BasePage
{
    public function __construct( $title )
    {
        parent::__construct( $title ); // Pass the title to the parent constructor
        // $this->setTabs(); / Set ALL tabbed setting pages here
    }

    //protected function setTabs()
    //{
        // Create new tabs here and UNCOMMENT this method AND the $this->setTabs() in the constructor above.
    //} // method close



} // class close