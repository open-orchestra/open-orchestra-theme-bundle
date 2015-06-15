<?php

namespace OpenOrchestra\ThemeBundle\Tests\DependencyInjection;

use \OpenOrchestra\ThemeBundle\DependencyInjection\OpenOrchestraThemeExtension;

/**
 * OpenOrchestraThemeExtensionTest class
 */
class OpenOrchestraThemeExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $configs = array();

        $container = $this
            ->getMockBuilder('\\Symfony\\Component\\DependencyInjection\\ContainerBuilder')
            ->disableOriginalConstructor()
            ->getMock();

        $container
            ->expects($this->exactly(1))
            ->method('addResource')
            ->with($this->isInstanceOf('\\Symfony\\Component\\Config\\Resource\\FileResource'));

        $extension = new OpenOrchestraThemeExtension();
        $extension->load($configs, $container);
    }
}
