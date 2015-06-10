<?php

namespace OpenOrchestra\ThemeBundle\Tests\Form\Type;

use OpenOrchestra\ThemeBundle\Form\Type\ThemeChoiceType;
use Phake;

/**
 * Description of ThemeChoiceTypeTest
 */
class ThemeChoiceTypeTest extends \PHPUnit_Framework_TestCase
{
    protected $themeChoiceType;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $themes = array(
            'themeId1' => array('name' => 'Dummy theme #1'),
            'themeId2' => array('name' => 'Dummy theme #2'),
        );
        
        $this->themeChoiceType = new ThemeChoiceType($themes);
    }

    /**
     * Test set default options
     */
    public function testSetDefaultOptions()
    {
        $choices = array(
            'themeId1' => 'Dummy theme #1',
            'themeId2' => 'Dummy theme #2',
        );
        
        $resolverMock = Phake::mock('Symfony\Component\OptionsResolver\OptionsResolver');

        $this->themeChoiceType->configureOptions($resolverMock);

        Phake::verify($resolverMock)->setDefaults(array('choices' => $choices));
    }

    /**
     * Test get parent
     */
    public function testGetParent()
    {
        $this->assertEquals('choice', $this->themeChoiceType->getParent());
    }

    /**
     * Test name
     */
    public function testGetName()
    {
        $this->assertEquals('orchestra_theme_choice', $this->themeChoiceType->getName());
    }
}
