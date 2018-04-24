<?php

/**
 * @file
 * Contains \Drupal\Console\ExtendExample\Command\ExampleCommand
 */

namespace Drupal\Console\Kickstart\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Drupal\Console\Core\Command\Shared\CommandTrait;
use Drupal\Console\Core\Style\DrupalStyle;

/**
 * Class KickstartCommand
 *
 * @package Drupal\Console\Kickstart\Command
 */
class KickstartCommand extends Command
{
    use CommandTrait;
    /**
     * {@inheritdoc}
     */

    /**
     * ExampleCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('extend:rtd:kickstart')
            ->setDescription('Set un RTD site.');
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new DrupalStyle($input, $output);
        $io->commentBlock('RTD Kickstart command.');
    }
}
