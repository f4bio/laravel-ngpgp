<?php

namespace F4bio\LaravelNgpgp;

use F4bio\LaravelNgpgp\Commands\LaravelNgpgpCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelNgpgpServiceProvider extends PackageServiceProvider
{
  public function configurePackage(Package $package): void
  {
    /*
     * This class is a Package Service Provider
     *
     * More info: https://github.com/spatie/laravel-package-tools
     */
    $package
      ->name("laravel-ngpgp")
      ->hasConfigFile()
      ->hasViews()
      ->hasMigration("create_laravel-ngpgp_table")
      ->hasCommand(LaravelNgpgpCommand::class);
  }
}
