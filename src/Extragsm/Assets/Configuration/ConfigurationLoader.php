<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Extragsm\Assets\Configuration;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

/**
 * Description of ConfigLoader
 *
 * @author razvandubau
 */
class ConfigurationLoader extends FileLoader
{
    /**
     * Load the config file, validate and build an object representation of it
     * 
     * @param string $resource
     * @param type $type
     * @return AssetsConfiguration
     */
    public function load($resource, $type = null)
    {
        $file = $this->getLocator()->locate($resource, __DIR__ . '/../../../..');
        $configs = Yaml::parse(file_get_contents($file));
        
        // Build the configuration tree
        $configBuilder = new AssetsConfigurationBuilder();
        
        // Validate the existing config against the configuration tree
        $processor = new Processor();
        $config = $processor->processConfiguration($configBuilder, array($configs));
        
        return new AssetsConfiguration($config);
    }

    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yml' === pathinfo(
            $resource,
            PATHINFO_EXTENSION
        );
    }
}
