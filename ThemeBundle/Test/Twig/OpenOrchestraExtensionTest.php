<?php

/*
 * Business & Decision - Commercial License
 *
 * Copyright 2014 Business & Decision.
 *
 * All rights reserved. You CANNOT use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell this Software or any parts of this
 * Software, without the written authorization of Business & Decision.
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * See LICENSE.txt file for the full LICENSE text.
 */

namespace OpenOrchestra\ThemeBundle\Test\Twig;

use \OpenOrchestra\ThemeBundle\Twig\OpenOrchestraExtension;

/**
 * Unit tests of OpenOrchestraExtension
 *
 * @author Nicolas BOUQUET <nicolas.bouquet@businessdecision.com>
 */
class OpenOrchestraExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $mockTplHelper = $this->getMockBuilder('\\Symfony\\Component\\Templating\\Helper\\CoreAssetsHelper')
            ->disableOriginalConstructor()
            ->getMock();
        $mockTplHelper->expects($this->any())
            ->method('getUrl')
            ->will($this->returnValue('webDirectory/'));
        
        $this->container = $this->getMock('\\Symfony\\Component\\DependencyInjection\\ContainerInterface');
        $this->container->expects($this->any())
                        ->method('getParameter')
                        ->with('open_orchestra_theme.themes')
                        ->will($this->returnValue($this->getFakeThemes()));
                        
        $this->container->expects($this->any())
                        ->method('get')
                        ->with('templating.helper.assets')
                        ->will($this->returnValue($mockTplHelper));
                        
        $this->extension = new OpenOrchestraExtension($this->container);
    }
    
    
    public function testGetFunctions()
    {
        $functions = $this->extension->getFunctions();
        
        $this->assertCount(2, $functions);
        $this->assertContainsOnlyInstancesOf(
            '\\Twig_SimpleFunction',
            $functions
        );
    }
    
    /**
     * Test OpenOrchestraExtension::openOrchestraCss
     * 
     * @dataProvider openOrchestraCssJsData
     * 
     * @param string $themeId
     * @param string $expectedCssTag
     * @param string $expectedJsTag
     */
    public function testOpenOrchestraCss($themeId, $expectedCss, $expectedJs)
    {
        $this->assertEquals(
            $expectedCss,
            $this->extension->openOrchestraCss($themeId)
        );
    }
    
    /**
     * Test OpenOrchestraExtension::openOrchestraJs
     * 
     * @dataProvider openOrchestraCssJsData
     * 
     * @param string $themeId
     * @param string $expectedCssTag
     * @param string $expectedJsTag
     */
    public function testOpenOrchestraJs($themeId, $expectedCss, $expectedJs)
    {
        $this->assertEquals(
            $expectedJs,
            $this->extension->openOrchestraJs($themeId)
        );
    }
    
    public function testGetName()
    {
        $this->assertEquals(
            'open_orchestra_extension',
            $this->extension->getName()
        );
    }
    
    /**
     * Data provider for openOrchestraCss and openOrchestraJs
     * @return array
     */
    public function openOrchestraCssJsData()
    {
        $dirSep = DIRECTORY_SEPARATOR;
        return array(
            array(
                'jsTheme',
                '',
                '<script type="text/javascript" src="'
                    . 'webDirectory/themes' . $dirSep . 'jsTheme' . $dirSep . 'pathToFile1.js'
                    . '"></script>' . PHP_EOL,
            ),
            array(
                'cssTheme',
                '<link type="text/css" rel="stylesheet" href="'
                    . 'webDirectory/themes' . $dirSep . 'cssTheme' . $dirSep . 'pathToFile1.css'
                    . '">' . PHP_EOL,
                ''
            ),
            array(
                'unknownTheme',
                '',
                ''
            )
        );
    }
    
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
