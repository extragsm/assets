<?php

namespace Extragsm\Assets\Compiler;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class CssCompiler
{
    protected $fs;
    
    public function __construct(Filesystem $fs)
    {
        $this->fs = $fs;
    }
    
    public function compile(array $from, array $into)
    {
        $compiledContent = '';
        
        foreach ($from as $file) {
            if (!$this->fs->exists($file)) {
                throw new FileNotFoundException(sprintf('The \'%s\' file not found', $file));
            }
            
            $compiledContent .= file_get_contents($file);
        }
        
        $compiledContent = preg_replace('/(\n|\t|\r)/', '', $compiledContent);
        $compiledContent = preg_replace('/\/\*.+?\*\//', '', $compiledContent);
        while (preg_match('/\s\s/', $compiledContent)) {
            $compiledContent = preg_replace('/\s\s/', ' ', $compiledContent);
        }
        
        foreach ($into as $destinationFile) {
            $this->fs->dumpFile($destinationFile, $compiledContent);
        }
    }
    
}
