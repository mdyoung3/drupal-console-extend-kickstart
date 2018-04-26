# RTD Kickstart command for Drupal Console

Provides a Drupal console command to set up RTD sites.

### Installation
- Install [Drupal Console launcher](https://github.com/hechoendrupal/drupal-console-launcher)
- Install [Drupal Console Extend](https://github.com/hechoendrupal/drupal-console-extend)  
- Install RTD Kickstart command
```
cd ~/.console/extend/

composer require asu-rtd/console-extend-kickstart

cp vendor/asu-rtd/console-extend-kickstart/chain/* ~/.console/chain

cd path/to/workspace
```

### Usage
After installing the items listed above, run the command below and answer a few questions to set up your brand new RTD site:
```
drupal rtd:new-site
```
