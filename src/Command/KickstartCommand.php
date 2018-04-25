<?php

/**
 * @file
 * Contains \Drupal\Console\ExtendExample\Command\ExampleCommand
 */

namespace Drupal\Console\Kickstart\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Drupal\Console\Core\Command\Shared\CommandTrait;
use Drupal\Console\Core\Style\DrupalStyle;
use Drupal\Console\Kickstart\Generator\KickstartGenerator;

/**
 * Class KickstartCommand
 *
 * TODO: Perform the following actions:
 * - Generate .lando file
 * - Generate drush site aliases
 * - Generate README
 *
 * @package Drupal\Console\Kickstart\Command
 */
class KickstartCommand extends Command {

  use CommandTrait;

  /**
   * {@inheritdoc}
   */

  /**
   * @var KickstartGenerator
   */
  protected $generator;

  /**
   * KickstartCommand constructor.
   */
  public function __construct(KickstartGenerator $generator) {
    $this->generator = $generator;
    parent::__construct();
  }

  protected function configure() {
    $this->setName('extend:rtd:kickstart')
      ->setDescription('Set un RTD site.')
      ->addOption(
        'site-name',
        null,
        InputOption::VALUE_REQUIRED
      );
  }

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $io = new DrupalStyle($input, $output);

    $option = 'site-name';
    $prompt = 'Enter site name';
    if (!empty($input->getOption($option))) {
      $raw_value = $input->getOption($option);
    }
    else {
      $raw_value = $io->ask($prompt, 'mysite');
    }
    $input->setOption($option, $this->enforce_alphanumeric($raw_value));

  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $io = new DrupalStyle($input, $output);

    $this->generator->addSkeletonDir( __DIR__ . '/../../templates');

    $siteInfo = [];
    $siteInfo['site_name'] = $input->getOption('site-name');

    $this->generator->generate([
      'io' => $io,
      'site_info' => $siteInfo,
    ]);
  }

  /**
   * Make sure string only contains alphanumeric characters.
   */
  protected function enforce_alphanumeric($string) {
    $string = preg_replace("/[^A-Za-z0-9 ]/", '', $string);
    return strtolower($string);
  }
}
