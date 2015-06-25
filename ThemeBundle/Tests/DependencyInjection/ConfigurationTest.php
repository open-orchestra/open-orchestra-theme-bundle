<?php

namespace OpenOrchestra\ThemeBundle\Tests\DependencyInjection;

use \OpenOrchestra\ThemeBundle\DependencyInjection\Configuration;

/**
 * ConfigurationTest class
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
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
