<?php

declare(strict_types=1);

namespace Shopper\StarterKit\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;

#[AsCommand('shopper:starter-kit:install')]
final class InstallCommand extends Command implements PromptsForMissingInput
{
    use InstallLivewireStarterKit;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shopper:starter-kit:install {stack : The development stack that should be installed (blade,livewire,react,vue)}
                            {--pest : Indicate that Pest should be installed}
                            {--ssr : Indicates if Inertia SSR support should be installed}
                            {--typescript : Indicates if TypeScript is preferred for the Inertia stack}
                            {--eslint : Indicates if ESLint with Prettier should be installed}
                            {--composer=global : Absolute path to the Composer binary which should be used to install packages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Shopper starter kits components and resources';

    /**
     * Execute the console command.
     */
    public function handle(): ?int
    {
        if ($this->argument('stack') === 'livewire') {
            return $this->installLivewireStaterKit();
        }

        $this->components->error('Invalid stack. Supported stacks are [livewire].');

        return self::FAILURE;
    }

    /**
     * Install Breeze's tests.
     *
     * @return bool
     */
    protected function installTests(): bool
    {
        (new Filesystem)->ensureDirectoryExists(base_path('tests/Feature'));

        $stubStack = match ($this->argument('stack')) {
            'livewire' => 'livewire',
            default => null,
        };

        if (! $stubStack) {
            return false;
        }

        if ($this->option('pest') || $this->isUsingPest()) {
            if ($this->hasComposerPackage('phpunit/phpunit')) {
                $this->removeComposerPackages(['phpunit/phpunit'], true);
            }

            if (! $this->requireComposerPackages(['pestphp/pest', 'pestphp/pest-plugin-laravel'], true)) {
                return false;
            }

            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/'.$stubStack.'/tests/Feature', base_path('tests/Feature'));
            (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/'.$stubStack.'/tests/Unit', base_path('tests/Unit'));
            (new Filesystem)->copy(__DIR__.'/../../stubs/'.$stubStack.'/tests/Pest.php', base_path('tests/Pest.php'));
        }


        return true;
    }

    /**
     * Install the given middleware names into the application.
     *
     * @param  array|string  $names
     * @param  string  $group
     * @param  string  $modifier
     * @return void
     */
    protected function installMiddleware(array|string $names, string $group = 'web', string $modifier = 'append'): void
    {
        $bootstrapApp = file_get_contents(base_path('bootstrap/app.php'));

        collect(Arr::wrap($names))
            ->filter(fn ($name) => ! Str::contains($bootstrapApp, $name))
            ->whenNotEmpty(function ($names) use ($bootstrapApp, $group, $modifier) {
                $names = $names->map(fn ($name) => "$name")->implode(','.PHP_EOL.'            ');

                $bootstrapApp = str_replace(
                    '->withMiddleware(function (Middleware $middleware) {',
                    '->withMiddleware(function (Middleware $middleware) {'
                    .PHP_EOL."        \$middleware->$group($modifier: ["
                    .PHP_EOL."            $names,"
                    .PHP_EOL.'        ]);'
                    .PHP_EOL,
                    $bootstrapApp,
                );

                file_put_contents(base_path('bootstrap/app.php'), $bootstrapApp);
            });
    }

    /**
     * Determine if the given Composer package is installed.
     *
     * @param  string  $package
     * @return bool
     */
    protected function hasComposerPackage(string $package): bool
    {
        $packages = json_decode(file_get_contents(base_path('composer.json')), true);

        return array_key_exists($package, $packages['require'] ?? [])
            || array_key_exists($package, $packages['require-dev'] ?? []);
    }

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param array $packages
     * @param bool $asDev
     * @return bool
     */
    protected function requireComposerPackages(array $packages, bool $asDev = false): bool
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            $packages,
            $asDev ? ['--dev'] : [],
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
                ->setTimeout(null)
                ->run(function ($type, $output) {
                    $this->output->write($output);
                }) === 0;
    }

    /**
     * Removes the given Composer Packages from the application.
     *
     * @param array $packages
     * @param bool $asDev
     * @return bool
     */
    protected function removeComposerPackages(array $packages, bool $asDev = false): bool
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'remove'];
        }

        $command = array_merge(
            $command ?? ['composer', 'remove'],
            $packages,
            $asDev ? ['--dev'] : [],
        );

        return (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
                ->setTimeout(null)
                ->run(function ($type, $output) {
                    $this->output->write($output);
                }) === 0;
    }

    /**
     * Update the scripts in the "package.json" file.
     *
     * @param callable $callback
     * @return void
     */
    protected static function updateComposerAutoloadFiles(callable $callback): void
    {
        if (! file_exists(base_path('composer.json'))) {
            return;
        }

        $content = json_decode(file_get_contents(base_path('composer.json')), true);

        $content['autoload']['files'] = $callback(
            array_key_exists('files', $content['autoload']) ? $content['autoload']['files'] : $content['autoload']
        );

        file_put_contents(
            base_path('composer.json'),
            json_encode($content, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Update the dependencies in the "package.json" file.
     *
     * @param callable $callback
     * @param bool $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, bool $dev = true): void
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Update the scripts in the "package.json" file.
     *
     * @param callable $callback
     * @return void
     */
    protected static function updateNodeScripts(callable $callback): void
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $content = json_decode(file_get_contents(base_path('package.json')), true);

        $content['scripts'] = $callback(
            array_key_exists('scripts', $content) ? $content['scripts'] : []
        );

        file_put_contents(
            base_path('package.json'),
            json_encode($content, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Delete the "node_modules" directory and remove the associated lock files.
     */
    protected static function flushNodeModules(): void
    {
        tap(new Filesystem, function ($files) {
            $files->deleteDirectory(base_path('node_modules'));

            $files->delete(base_path('pnpm-lock.yaml'));
            $files->delete(base_path('yarn.lock'));
            $files->delete(base_path('bun.lockb'));
            $files->delete(base_path('deno.lock'));
            $files->delete(base_path('package-lock.json'));
        });
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile(string $search, string $replace, string $path): void
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    /**
     * Get the path to the appropriate PHP binary.
     *
     * @return string
     */
    protected function phpBinary(): string
    {
        if (function_exists('Illuminate\Support\php_binary')) {
            return \Illuminate\Support\php_binary();
        }

        return (new PhpExecutableFinder)->find(false) ?: 'php';
    }

    /**
     * Run the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function runCommands(array $commands): void
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'stack' => fn () => select(
                label: 'Which Starter kit would you like to install?',
                options: [
                    // 'blade' => 'Blade with Alpine (soon)',
                    'livewire' => 'Livewire with Alpine',
                    // 'react' => 'React with Inertia (soon)',
                    // 'vue' => 'Vue with Inertia (soon)',
                ],
                scroll: 5,
            ),
        ];
    }

    /**
     * Interact further with the user if they were prompted for missing arguments.
     *
     * @return void
     */
    protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output): void
    {
        $stack = $input->getArgument('stack');

        if (in_array($stack, ['react', 'vue'])) {
            collect(multiselect(
                label: 'Would you like any optional features?',
                options: [
                    'ssr' => 'Inertia SSR',
                    'typescript' => 'TypeScript',
                    'eslint' => 'ESLint with Prettier',
                ],
                hint: 'Use the space bar to select options.'
            ))->each(fn ($option) => $input->setOption($option, true));
        }
    }

    /**
     * Determine whether the project is already using Pest.
     *
     * @return bool
     */
    protected function isUsingPest(): bool
    {
        return class_exists(\Pest\TestSuite::class);
    }
}
