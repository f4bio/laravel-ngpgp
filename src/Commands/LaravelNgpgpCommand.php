<?php

namespace F4bio\LaravelNgpgp\Commands;

use Illuminate\Console\Command;

class LaravelNgpgpCommand extends Command
{
    public $signature = 'laravel-ngpgp';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
