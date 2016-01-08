<?php

namespace OpenOrchestra\ThemeBundle\Tests\DependencyInjection;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractBaseTestCase;
use \OpenOrchestra\ThemeBundle\DependencyInjection\Configuration;

/**
 * ConfigurationTest class
 */
class ConfigurationTest extends AbstractBaseTestCase
{
    public function testGetConfigTreeBuilder()
    {
        $configuration = new Configuration();
        $treeBuilder   = $configuration->getConfigTreeBuilder();

        $this->assertInstanceOf(
            '\\Symfony\\Component\\Config\\Definition\\Builder\\TreeBuilder',
            $treeBuilder
        );
    }
}
