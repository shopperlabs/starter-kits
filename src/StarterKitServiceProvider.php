<?php

declare(strict_types=1);

namespace Shopper\StarterKit;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

final class StarterKitServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Console\InstallCommand::class,
        ]);
    }

    public function provides(): array
    {
        return [Console\InstallCommand::class];
    }
}
