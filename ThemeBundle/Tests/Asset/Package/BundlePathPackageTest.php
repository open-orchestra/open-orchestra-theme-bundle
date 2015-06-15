<?php

namespace OpenOrchestra\ThemeBundle\Tests\Asset\Package;

use OpenOrchestra\ThemeBundle\Asset\Package\BundlePathPackage;
use Phake;

/**
 * Unit tests of BundlePathPackage
 */
class BundlePathPackageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BundlePathPackage
     */
    protected $bundlePathPackage;

    protected $versionStrategy;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->versionStrategy = Phake::mock('Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface');

        $this->bundlePathPackage = new BundlePathPackage($this->versionStrategy);
    }

    /**
     * @param string $expectedUrl
     * @param string $bundle
     * @param string $path
     *
     * @dataProvider getUrlData
     */
    public function testGetUrl($expectedUrl, $bundle, $path)
    {
        if (isset($bundle)) {
            $this->bundlePathPackage->setBundlePath($bundle);
        }
        Phake::when($this->versionStrategy)->applyVersion(Phake::anyParameters())->thenReturn($expectedUrl);

        $resultURL = $this->bundlePathPackage->getUrl($path);

        $this->assertEquals($expectedUrl, $resultURL);
        Phake::verify($this->versionStrategy)->applyVersion($expectedUrl);
    }

    /**
     * Data provider for getUrl
     * @return array
     */
    public function getUrlData()
    {
        return array(
            array('/bundles/dummy/themes/some/path',          'DummyBundle', '/some/path'),
            array('/some/path',                        null,          '/some/path'),
            array('/bundles/dummy/themes/other/path/longer/', 'DummyBundle', 'other/path/longer/'),
            array('other/path/longer/',               null,          'other/path/longer/'),
        );
    }

    /**
     * @param string $expectedBundlePath
     * @param string $bundle
     *
     * @dataProvider setBundlePathData
     */
    public function testSetBundlePath($expectedBundlePath, $bundle)
    {
        $this->bundlePathPackage->setBundlePath($bundle);

        $this->assertEquals(
            $expectedBundlePath,
            $this->bundlePathPackage->getBundleDir()
        );
    }

    /**
     * Data provider for setBundlePath
     * @return array
     */
    public function setBundlePathData()
    {
        return array(
            array('bundles/example',            'ExampleBundle'),
            array('bundles/longnamewithsuffix', 'LongNameWithSuffixBundle'),
            array('bundles/withoutsuffix',      'WithoutSuffix'),
            array('bundles/', ''),
            array('bundles/double', 'DoubleBundleBundle'),
        );
    }
}
