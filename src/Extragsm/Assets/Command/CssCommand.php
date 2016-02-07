<?php

/*
 * This file is part of the Extragsm package.
 *
 * (c) Razvan Dubau <dubau_razvan@yahoo.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Extragsm\Assets\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Filesystem\Filesystem;
use Extragsm\Assets\Configuration\ConfigurationLoader;
use Extragsm\Assets\Compiler\CssCompiler;

/**
 * Command to run the compiler for CSS assets
 */
class CssCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('compile:css')
            ->setDescription('Create a single css file from many files. Specify an array of files and a destination file')
            ->addOption(
               '--group',
               '-g',
               InputOption::VALUE_OPTIONAL,
               'Specify a which group to compile'
            )
            ->addOption(
               '--compile-all',
               null,
               InputOption::VALUE_NONE,
               'Compile all groups'
            )
            ->addOption(
               'list',
               '-l',
               InputOption::VALUE_NONE,
               'Lists all the available groups declared in the config'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configLoader = new ConfigurationLoader(new FileLocator);
        $config = $configLoader->load('config.yml');

        // Print the list of available groups
        if ($input->getOption('list')) {
            foreach (array_keys($config->getGroups()) as $item) {
                $output->writeln(sprintf('<comment>%s</comment>', $item));
            }
            
            return;
        }
        
        // Compile all assets declred in config
        if ($input->getOption('compile-all')) {
            // Do the Compile
            $compiler = new CssCompiler(new Filesystem);
            
            foreach ($config->getGroups() as $name => $group) {
                $compiler->compile($group['files'], $group['destination']);
                
                $output->writeLn(sprintf('Group <info>%s</info> [OK]', $name));
            }
            
            return;
        }
        
        // Compile the specified group, if one is specified
        $groupName = $input->getOption('group');
        $group = $config->getGroup($groupName);
        
        if (is_null($group)) {
            throw new \Exception('The group you have specified does not exist in your config file');
        }
        
        // Do the Compile
        $compiler = new CssCompiler(new Filesystem);
        $compiler->compile($group['files'], $group['destination']);
        
        $output->writeLn(sprintf('Group <info>%s</info> [OK]', $groupName));
    }
    
}