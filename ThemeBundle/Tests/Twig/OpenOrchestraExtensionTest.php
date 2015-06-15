<?php

namespace OpenOrchestra\ThemeBundle\Tests\Twig;

use OpenOrchestra\ThemeBundle\Twig\OpenOrchestraExtension;
use Phake;

/**
 * OpenOrchestraExtensionTest class
 */
class OpenOrchestraExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OpenOrchestraExtension
     */
    protected $extension;

    protected $assetsHelper;
    protected $themes;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->assetsHelper = Phake::mock('Symfony\Bundle\FrameworkBundle\Templating\Helper\AssetsHelper');

        $this->extension = new OpenOrchestraExtension($this->assetsHelper, $this->getFakeThemes());
    }

    /**
     * Test get fuctions
     */
    public function testGetFunctions()
    {
        $functions = $this->extension->getFunctions();

        $this->assertCount(2, $functions);
        $this->assertContainsOnlyInstancesOf('Twig_SimpleFunction', $functions);
    }

    /**
     * Test css balise creation
     */
    public function testOpenOrchestraCss()
    {
        Phake::when($this->assetsHelper)->getUrl(Phake::anyParameters())->thenReturn('webDirectory/themes/pathToFile1.css');

        $this->assertEquals(
            '<link type="text/css" rel="stylesheet" href="webDirectory/themes/pathToFile1.css">' . PHP_EOL,
            $this->extension->openOrchestraCss('cssTheme')
        );
        Phake::verify($this->assetsHelper)->getUrl('cssTheme/pathToFile1.css', 'otherBundle');
    }

    /**
     * Test js link creation
     */
    public function testOpenOrchestraJs()
    {
        Phake::when($this->assetsHelper)->getUrl(Phake::anyParameters())->thenReturn('webDirectory/themes/pathToFile1.js');

        $this->assertEquals(
            '<script type="text/javascript" src="webDirectory/themes/pathToFile1.js"></script>' . PHP_EOL,
            $this->extension->openOrchestraJs('jsTheme')
        );
        Phake::verify($this->assetsHelper)->getUrl('jsTheme/pathToFile1.js', 'someBundle');
    }

    /**
     * Test get name
     */
    public function testGetName()
    {
        $this->assertEquals('open_orchestra_extension', $this->extension->getName());
    }

    /**
     * @return array
     */
    public function getFakeThemes()
    {
        return array(
            'jsTheme' => array(
                'name' => 'Thème JS',
                'javascripts' => array('someBundle:jsTheme:pathToFile1.js')
            ),
            'cssTheme' => array(
                'name' => 'Thème CSS',
                'stylesheets' => array('otherBundle:cssTheme:pathToFile1.css')
            )
        );
    }
}
