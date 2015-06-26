<?php

namespace OpenOrchestra\ThemeBundle\Asset\Package;

use Symfony\Component\Asset\Package;

/**
 * Alternative package for assets
 * Give the location of an asset from a bundle
 */
class BundlePathPackage extends Package
{
    const THEMES_FOLDER = 'themes';

    /**
     * Bundle assets web directory
     *
     * @var string
     */
    protected $bundleDir;

    /**
     * @param string $path
     *
     * @return string
     */
    public function getUrl($path)
    {
        if (isset($this->bundleDir)) {
            $path = '/' . $this->bundleDir . '/' . self::THEMES_FOLDER . '/' . ltrim($path, '/');
        }

        return parent::getUrl($path);
    }

    /**
     * Set the bundle assets web path according to the bundle name
     *
     * @param string $bundleName
     */
    public function setBundlePath($bundleName)
    {
        $this->bundleDir = 'bundles/' . strtolower(str_replace('Bundle', '', $bundleName));
    }

    /**
     * Get bundle asset path (relative to web)
     *
     * @return string
     */
    public function getBundleDir()
    {
        return $this->bundleDir;
    }
}
