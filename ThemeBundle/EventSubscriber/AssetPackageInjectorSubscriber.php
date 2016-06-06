<?php

namespace OpenOrchestra\ThemeBundle\EventSubscriber;

use OpenOrchestra\ThemeBundle\Asset\Package\BundlePathPackage;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class AssetPackageInjectorSubscriber
 *
 * Add all the bundles to the custom Path generator
 */
class AssetPackageInjectorSubscriber implements ContainerAwareInterface, EventSubscriberInterface
{
    use ContainerAwareTrait;

    protected $kernel;
    protected $assetsPackages;
    protected $defaultVersionStrategy;

    /**
     * @param KernelInterface          $kernel
     * @param Packages                 $assetPackages
     * @param VersionStrategyInterface $versionStrategy
     */
    public function __construct(
        KernelInterface $kernel,
        Packages $assetPackages,
        VersionStrategyInterface $defaultVersionStrategy
    ) {
        $this->kernel = $kernel;
        $this->assetsPackages = $assetPackages;
        $this->defaultVersionStrategy = $defaultVersionStrategy;
    }

    /**
     * Inject custom Asset package to Kernel assets helper
     */
    public function onKernelRequest()
    {
        foreach ($this->kernel->getBundles() as $bundle) {
            $bundlePathPackage = new BundlePathPackage($this->getVersionStrategy());
            $bundlePathPackage->setBundlePath($bundle->getName());
            $this->assetsPackages->addPackage($bundle->getName(), $bundlePathPackage);
        }
    }

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => 'onKernelRequest',
            KernelEvents::EXCEPTION => array('onKernelRequest', 100),
        );
    }

    /**
     * Returns the version strategy to use.
     *
     * @return VersionStrategyInterface
     */
    protected function getVersionStrategy()
    {
        return $this->container->has('assets._version__default')
            ? $this->container->get('assets._version__default')
            : $this->defaultVersionStrategy;
    }
}
