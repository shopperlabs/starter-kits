<?php

declare(strict_types=1);

namespace Shopper\StarterKit\Console;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

trait InstallLivewireStarterKit
{
    protected function installLivewireStaterKit()
    {
        // Helper...
        copy(__DIR__.'/../../stubs/shared/app/helpers.php', app_path('helpers.php'));

        $this->updateComposerAutoloadFiles(function ($files) {
            return $files + ['app/helpers.php'];
        });

        // Install Livewire and necessary packages...
        if (! $this->requireComposerPackages([
            'darryldecode/cart:^4.2',
            'laravelcm/livewire-slide-overs:^1.0',
            'livewire/volt:^1.0',
            'wire-elements/modal:^2.0'
        ])) {
            return self::FAILURE;
        }

        $this->updateNodePackages(function ($packages) {
            return [
                '@tailwindcss/aspect-ratio' => '^0.4.2',
                '@tailwindcss/forms' => '^0.5.2',
                '@tailwindcss/typography' => "^0.5.13",
                'autoprefixer' => '^10.4.2',
                'postcss' => '^8.4.31',
                'prettier' => '^3.2.5',
                'prettier-plugin-blade' => '^2',
                'prettier-plugin-tailwindcss' => '^0.5.14',
                'tailwindcss' => '^3.4.0',
            ] + $packages;
        });

        $this->updateNodeScripts(function ($scripts) {
            return $scripts + [
                'prettier' => 'npx prettier --write ./resources',
            ];
        });

        // Install Volt...
        (new Process([$this->phpBinary(), 'artisan', 'volt:install'], base_path()))
            ->setTimeout(null)
            ->run();

        $sharedFoldersToCopy = ['Actions', 'Contracts', 'DTO', 'Enums', 'Filament', 'Models', 'Traits'];

        foreach ($sharedFoldersToCopy as $folder) {
            (new Filesystem)->ensureDirectoryExists(app_path($folder));
            (new Filesystem)->copyDirectory(
                __DIR__.'/../../stubs/shared/app/'. $folder,
                app_path($folder),
            );
        }

        // Controllers
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers/Auth'));
        (new Filesystem)->copy(
            __DIR__.'/../../stubs/shared/app/Http/Controllers/Auth/VerifyEmailController.php',
            app_path('Http/Controllers/Auth/VerifyEmailController.php'),
        );

        // Middlewares
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Middleware'));
        (new Filesystem)->copy(
            __DIR__.'/../../stubs/shared/app/Http/Middleware/ZoneDetector.php',
            app_path('Http/Middleware/ZoneDetector.php'),
        );

        $this->installMiddleware('\App\Http\Middleware\ZoneDetector::class');

        // Views Components...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/components'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/blade-common/resources/views/components', resource_path('views/components'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/livewire/resources/views/components', resource_path('views/components'));

        // Livewire Views...
        (new Filesystem)->ensureDirectoryExists(resource_path('views/livewire'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/livewire/resources/views/livewire', resource_path('views/livewire'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/livewire/resources/views/components', resource_path('views/components'));

        // Livewire Pages & Components...
        (new Filesystem)->ensureDirectoryExists(app_path('Livewire'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/livewire/app/Livewire', app_path('Livewire'));

        // Tests...
        if (! $this->installTests()) {
            return self::FAILURE;
        }

        // Config...
        copy(__DIR__.'/../../stubs/shared/config/shopper/models.php', config_path('shopper/models.php'));
        copy(__DIR__.'/../../stubs/shared/config/starterkit.php', config_path('starterkit.php'));

        // Routes...
        copy(__DIR__.'/../../stubs/livewire/routes/web.php', base_path('routes/web.php'));
        copy(__DIR__.'/../../stubs/livewire/routes/auth.php', base_path('routes/auth.php'));

        // Tailwind / Vite...
        copy(__DIR__.'/../../stubs/livewire/vite.config.js', base_path('vite.config.js'));
        copy(__DIR__.'/../../stubs/shared/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__.'/../../stubs/shared/postcss.config.js', base_path('postcss.config.js'));
        copy(__DIR__.'/../../stubs/shared/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__.'/../../stubs/shared/resources/css/links.css', resource_path('css/links.css'));
        copy(__DIR__.'/../../stubs/shared/resources/css/swiper.css', resource_path('css/swiper.css'));

        $this->components->info('Installing and building Node dependencies 🔽.');

        if (file_exists(base_path('pnpm-lock.yaml'))) {
            $this->runCommands(['pnpm install', 'pnpm run build']);
        } elseif (file_exists(base_path('yarn.lock'))) {
            $this->runCommands(['yarn install', 'yarn run build']);
        } elseif (file_exists(base_path('bun.lockb'))) {
            $this->runCommands(['bun install', 'bun run build']);
        } elseif (file_exists(base_path('deno.lock'))) {
            $this->runCommands(['deno install', 'deno task build']);
        } else {
            $this->runCommands(['npm install', 'npm run build']);
        }

        $this->components->info('Livewire starter kit installed successfully 🚀.');
    }
}
