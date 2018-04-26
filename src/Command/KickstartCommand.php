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
   * @var array
   */
  private $siteInfo = [
    'site_name' => [
      'prompt' => 'Enter site name',
      'filter' => 'enforce_alphanumeric',
      'value'  => '',
      'required'  => TRUE,
    ],
    'qa_url' => [
      'prompt' => 'Enter QA URL',
      'filter' => 'validateUrl',
      'value'  => '',
      'required'  => FALSE,
    ],
    'qa_user' => [
      'prompt' => 'Enter QA user.',
      'filter' => 'enforce_alphanumeric',
      'value'  => '',
      'required'  => FALSE,
    ],
    'prod_url' => [
      'prompt' => 'Enter Prod URL',
      'filter' => 'validateUrl',
      'value'  => '',
      'required'  => FALSE,
    ],
    'prod_user' => [
      'prompt' => 'Enter Prod user.',
      'filter' => 'enforce_alphanumeric',
      'value'  => '',
      'required'  => FALSE,
    ],
  ];

  /**
   * KickstartCommand constructor.
   */
  public function __construct(KickstartGenerator $generator) {
    $this->generator = $generator;
    parent::__construct();
  }

  protected function configure() {
    $this->setName('rtd:kickstart')
      ->setDescription('Set un RTD site.');

    foreach ($this->siteInfo as $option=>$props)
      $this->addOption(
        $option,
        null,
        $props['required'] ? InputOption::VALUE_REQUIRED : InputOption::VALUE_OPTIONAL
      );
  }

  /**
   * {@inheritdoc}
   */
  protected function interact(InputInterface $input, OutputInterface $output) {
    $io = new DrupalStyle($input, $output);

    foreach ($this->siteInfo as $option=>$props) {
      if (!empty($input->getOption($option))) {
        $rawValue = $input->getOption($option);
      }
      else {
        $rawValue = $io->ask($props['prompt']);
      }
      $input->setOption($option, $this->$props['filter']($rawValue));
    }

  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $io = new DrupalStyle($input, $output);

    $this->generator->addSkeletonDir( __DIR__ . '/../../templates');

    $siteInfo = [];
    foreach ($this->siteInfo as $option=>$props) {
      $siteInfo[$option] = $input->getOption($option);
    }

    $this->generator->generate([
      'io' => $io,
      'site_info' => $siteInfo,
    ]);
  }

  /**
   * Make sure string only contains alphanumeric characters.
   *
   * @param $string
   *
   * @return string
   */
  protected function enforce_alphanumeric($string) {
    $string = preg_replace("/[^A-Za-z0-9 ]/", '', $string);
    return strtolower($string);
  }

  /**
   * Make sure URL is valid; otherwise, return blank.
   *
   * @param $url
   *
   * @return string
   */
  protected function validateUrl($url) {
    return filter_var($url, FILTER_VALIDATE_URL) ? $url : '';
  }
}
