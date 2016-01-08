<?php

namespace OpenOrchestra\ThemeBundle\Tests\DependencyInjection;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractBaseTestCase;
use \OpenOrchestra\ThemeBundle\DependencyInjection\OpenOrchestraThemeExtension;
use Phake;

/**
 * OpenOrchestraThemeExtensionTest class
 */
class OpenOrchestraThemeExtensionTest extends AbstractBaseTestCase
{
    public function testLoad()
    {
        $configs = array();

        $container = Phake::mock('\Symfony\Component\DependencyInjection\ContainerBuilder');

        $extension = new OpenOrchestraThemeExtension();
        $extension->load($configs, $container);

        Phake::verify($container)->addResource($this->isInstanceOf('\Symfony\Component\Config\Resource\FileResource'));
    }
}
