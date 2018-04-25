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
use Drupal\Console\Kickstart\Generator\KickstartGenerator;

/**
 * Class KickstartCommand
 *
 * TODO: Perform the following actions:
 * - Generate .lando file
 * - Install drupal-composer
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

  private $siteInfo = [
    'site_name' => [
      'prompt' => 'Enter site name',
      'filter' => 'enforce_alphanumeric',
      'value'  => 'mysite',
    ]
  ];

  /**
   * ExampleCommand constructor.
   */
  public function __construct(KickstartGenerator $generator) {
    $this->generator = $generator;
    parent::__construct();
  }

  protected function configure() {
    $this->setName('extend:rtd:kickstart')
      ->setDescription('Set un RTD site.');
  }

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $io = new DrupalStyle($input, $output);
    foreach ($this->siteInfo as $key => $attributes) {
      $raw_value = $io->ask($attributes['prompt'], $attributes['value']);
      $this->siteInfo[$key]['value'] = $this->enforce_alphanumeric($raw_value);
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $io = new DrupalStyle($input, $output);

    $this->generator->addSkeletonDir( __DIR__ . '/../../templates');

    $this->generator->generate([
      'io' => $io,
      'site_info' => $this->siteInfo,
    ]);

//    $io->commentBlock('Site Name: ' . $this->siteInfo['site_name']['value']);

  }

  /**
   * Make sure string only contains alphanumeric characters.
   */
  protected function enforce_alphanumeric($string) {
    $string = preg_replace("/[^A-Za-z0-9 ]/", '', $string);
    return strtolower($string);
  }
}
