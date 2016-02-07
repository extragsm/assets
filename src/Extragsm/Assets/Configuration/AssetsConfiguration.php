<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Extragsm\Assets\Configuration;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * A representation of config.yml
 *
 * @author razvandubau
 */
class AssetsConfiguration implements AssetsConfigurationInterface
{
    /**
     * @var array 
     */
    protected $paths;

    /**
     * @var array 
     */
    protected $groups;

    
    public function __construct(array $config)
    {
        $this->paths = $config['paths'];
        $this->groups = $config['groups'];
        
        foreach ($this->groups as $name => &$group) {
            
            if (!isset($group['files'])) {
                throw new InvalidConfigurationException(sprintf('Group "%s" does not have any files[] specified', $name));
            }
            
            if (!isset($group['destination'])) {
                throw new InvalidConfigurationException(sprintf('Group "%s" does not have any destination specified', $name));
            }
            
            foreach ($group['files'] as &$file) {
                $file = $this->getPathForExtended() . $file;
            }
            
            foreach ($group['destination'] as &$dest) {
                $dest = $this->getPathForDestination() . $dest;
            }
        }
    }

    /**
     * 
     * @param type $name
     * @return type
     */
    public function getGroup($name)
    {
        return !isset($this->groups[$name]) ? null : $this->groups[$name];
    }

    /**
     * 
     * @return type
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * 
     * @return type
     */
    public function getPathForDestination()
    {
        return rtrim($this->paths['destination'], '/') . '/';
    }

    /**
     * 
     * @return type
     */
    public function getPathForExtended()
    {
        return rtrim($this->paths['extended'], '/') . '/';
    }
}
