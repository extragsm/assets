<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Extragsm\Assets\Configuration;

/**
 * Description of ConfigInterface
 *
 * @author razvandubau
 */
interface AssetsConfigurationInterface
{
    public function getPathForExtended();
    
    public function getPathForDestination();
    
    public function getGroups();
    
    public function getGroup($name);
}
