<?php

namespace OpenOrchestra\ThemeBundle\Tests\EventSubscriber;

use OpenOrchestra\ThemeBundle\EventSubscriber\AssetPackageInjectorSubscriber;
use Phake;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * AssetPackageInjectorSubscriberTest class
 */
class AssetPackageInjectorSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AssetPackageInjectorSubscriber
     */
    protected $injector;

    protected $kernel;
    protected $assetsPackages;
    protected $versionStrategy;

    /**
     * Set Up the test
     */
    public function setUp()
    {
        $this->kernel = Phake::mock('Symfony\Component\HttpKernel\KernelInterface');
        $this->assetsPackages = new Packages();
        $this->versionStrategy = Phake::mock('Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface');

        $this->injector = new AssetPackageInjectorSubscriber($this->kernel, $this->assetsPackages, $this->versionStrategy);
    }

    /**
     * Test instance
     */
    public function testInstance()
    {
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\EventSubscriberInterface', $this->injector);
    }

    /**
     * Test event subscribed
     */
    public function testEventSubscribed()
    {
        $this->assertArrayHasKey(KernelEvents::REQUEST, $this->injector->getSubscribedEvents());
        $this->assertTrue(method_exists($this->injector, 'onKernelRequest'));
    }

    /**
     * Test onKernelRequest
     */
    public function testOnKernelRequest()
    {
        $bundleName = 'fakeBundle';
        $bundle = Phake::mock('Symfony\Component\HttpKernel\Bundle\Bundle');
        Phake::when($bundle)->getName()->thenReturn($bundleName);

        Phake::when($this->kernel)->getBundles()->thenReturn(array($bundle));

        $this->injector->onKernelRequest();

        $this->assertInstanceOf('Symfony\Component\Asset\PackageInterface', $this->assetsPackages->getPackage($bundle->getName()));
    }
}
