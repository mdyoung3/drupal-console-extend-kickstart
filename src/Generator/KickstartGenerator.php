<?php

/**
 * @file
 * Contains Drupal\Console\Kickstart\Generator\KickstartGenerator.
 */
namespace Drupal\Console\Kickstart\Generator;

use Symfony\Component\Filesystem\Filesystem;
use Drupal\Console\Core\Generator\Generator;
use Drupal\Console\Core\Style\DrupalStyle;

/**
 * Class KickstartGenerator
 *
 * @package Drupal\Console\Kickstart\Generator
 */
class KickstartGenerator extends Generator
{
  /**
   * {@inheritdoc}
   */
  public function generate(array $parameters)
  {
    $io = $parameters['io'];
    $siteInfo = $parameters['site_info'];
    $fs = new Filesystem();

    if (!$fs->exists($siteInfo['site_name'])) {
      $io->error("The {$siteInfo['site_name']} directory already exists.");
      return;
    }

    $fs->mkdir($siteInfo['site_name'], 0755);

    $this->renderFile(
      '.lando.yml.twig',
       "./{$siteInfo['site_name']}/.lando.yml" ,
      $siteInfo
    );

    $io->success(".lando.yml has been created.");
  }
}