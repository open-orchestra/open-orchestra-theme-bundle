<?php

namespace OpenOrchestra\ThemeBundle\EventSubscriber;

use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;
use OpenOrchestra\ThemeBundle\Asset\Package\BundlePathPackage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class AssetPackageInjectorSubscriber
 *
 * Add all the bundles to the custom Path generator
 */
class AssetPackageInjectorSubscriber implements EventSubscriberInterface
{
    protected $kernel;
    protected $assetsPackages;
    protected $versionStrategy;

    /**
     * @param KernelInterface          $kernel
     * @param Packages                 $assetPackages
     * @param VersionStrategyInterface $versionStrategy
     */
    public function __construct(KernelInterface $kernel, Packages $assetPackages, VersionStrategyInterface $versionStrategy)
    {
        $this->kernel = $kernel;
        $this->assetsPackages = $assetPackages;
        $this->versionStrategy = $versionStrategy;
    }

    /**
     * Inject custom Asset package to Kernel assets helper
     */
    public function onKernelRequest()
    {
        foreach ($this->kernel->getBundles() as $bundle) {
            $bundlePathPackage = new BundlePathPackage($this->versionStrategy);
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
}
