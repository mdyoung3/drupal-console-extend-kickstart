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
  public function generate(array $parameters) {
    $io = $parameters['io'];
    $siteInfo = $parameters['site_info'];
    $fs = new Filesystem();

    $this->generateLandoFile($fs, $io, $siteInfo);
    $this->generateDrushAliasesFile($fs, $io, $siteInfo);

  }

  public function generateLandoFile($fs, $io, $siteInfo) {
//     if ($fs->exists("./{$siteInfo['site_name']}/.lando.yml")) {
//      $io->error("{$siteInfo['site_name']}/.lando.yml already exists.");
//      return;
//    }
    $fs->mkdir($siteInfo['site_name'], 0755);
    $this->renderFile(
      '.lando.yml.twig',
       "./{$siteInfo['site_name']}/.lando.yml" ,
      $siteInfo
    );

    $io->success(".lando.yml has been created.");
  }

  public function generateDrushAliasesFile($fs, $io, $siteInfo) {
//    if ($fs->exists("./{$siteInfo['site_name']}/drush/sites/{$siteInfo['site_name']}.site.yml")) {
//      $io->error("{$siteInfo['site_name']}/drush/sites/{$siteInfo['site_name']}.site.yml already exists.");
//      return;
//    }
    $dirPath = "{$siteInfo['site_name']}/drush/sites";
    $fs->mkdir($dirPath, 0755);
    $this->renderFile(
      'drush-aliases.site.yml.twig',
      "$dirPath/{$siteInfo['site_name']}.site.yml" ,
      $siteInfo
    );

    $io->success("{$siteInfo['site_name']}.site.yml has been created.");
  }
}