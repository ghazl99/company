<?php

namespace Modules\Core\Providers;

use Modules\User\Models\User;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;
use Modules\WorkSession\Models\WorkSession;

class CoreServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Core';

    protected string $nameLower = 'core';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
        View::composer('core::admin.dashboard', function ($view) {
            $user = Auth::user(); // المستخدم الحالي

            if ($user->hasRole('superAdmin')) {
                $developersCount = Cache::remember('developers_count', now()->addMinutes(1), function () {
                    return User::role('developer')->count();
                });

                $assignedCount = Cache::remember('tasks_assigned_count', now()->addMinutes(1), function () {
                    return DB::table('tasks')->where('status', 'assignment')->count();
                });

                $acceptedCount = Cache::remember('tasks_accepted_count', now()->addMinutes(1), function () {
                    return DB::table('tasks')->where('status', 'accepted')->count();
                });

                $completedCount = Cache::remember('tasks_complete_count', now()->addMinutes(1), function () {
                    return DB::table('tasks')->where('status', 'complete')->count();
                });

                $view->with(compact(
                    'developersCount',
                    'assignedCount',
                    'acceptedCount',
                    'completedCount'
                ));
            } elseif ($user->hasRole('developer')) {
                $developerId = $user->id;

                $assignedCount = Cache::remember("dev_{$developerId}_assigned", now()->addMinutes(1), function () use ($developerId) {
                    return DB::table('task_assignments')->where('developer_id', $developerId)->where('status', 'candidate')->count();
                });

                $acceptedCount = Cache::remember("dev_{$developerId}_accepted", now()->addMinutes(1), function () use ($developerId) {
                    return DB::table('task_assignments')->where('developer_id', $developerId)->where('status', 'accepted')->count();
                });

                $completedCount = Cache::remember("dev_{$developerId}_done", now()->addMinutes(1), function () use ($developerId) {
                    return DB::table('task_assignments')->where('developer_id', $developerId)->where('status', 'done')->count();
                });

                $rejectedCount = Cache::remember("dev_{$developerId}_rejected", now()->addMinutes(1), function () use ($developerId) {
                    return DB::table('task_assignments')->where('developer_id', $developerId)->where('status', 'rejected')->count();
                });

                $expiredCount = Cache::remember("dev_{$developerId}_expired", now()->addMinutes(1), function () use ($developerId) {
                    return DB::table('task_assignments')->where('developer_id', $developerId)->where('status', 'expired')->count();
                });

                $todayHours = Cache::remember("dev_{$developerId}_today_hours", now()->addMinutes(1), function () use ($developerId) {
                    $totalSeconds = WorkSession::where('developer_id', $developerId)
                        ->whereDate('start_time', today())
                        ->sum('duration_seconds');

                    $hours = floor($totalSeconds / 3600);
                    $minutes = floor(($totalSeconds % 3600) / 60);

                    return "{$hours} ساعة و {$minutes} دقيقة";
                });

                $monthHours = Cache::remember("dev_{$developerId}_month_hours", now()->addMinutes(1), function () use ($developerId) {
                    $totalSeconds = WorkSession::where('developer_id', $developerId)
                        ->whereBetween('start_time', [now()->startOfMonth(), now()->endOfMonth()])
                        ->sum('duration_seconds');

                    $hours = floor($totalSeconds / 3600);
                    $minutes = floor(($totalSeconds % 3600) / 60);

                    return "{$hours} ساعة و {$minutes} دقيقة";
                });



                $view->with(compact(
                    'assignedCount',
                    'acceptedCount',
                    'completedCount',
                    'rejectedCount',
                    'expiredCount',
                    'todayHours',
                    'monthHours'
                ));
            }
        });
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        // $this->commands([]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->nameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->name, 'lang'), $this->nameLower);
            $this->loadJsonTranslationsFrom(module_path($this->name, 'lang'));
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $configPath = module_path($this->name, config('modules.paths.generator.config.path'));

        if (is_dir($configPath)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configPath));

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $config = str_replace($configPath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                    $config_key = str_replace([DIRECTORY_SEPARATOR, '.php'], ['.', ''], $config);
                    $segments = explode('.', $this->nameLower . '.' . $config_key);

                    // Remove duplicated adjacent segments
                    $normalized = [];
                    foreach ($segments as $segment) {
                        if (end($normalized) !== $segment) {
                            $normalized[] = $segment;
                        }
                    }

                    $key = ($config === 'config.php') ? $this->nameLower : implode('.', $normalized);

                    $this->publishes([$file->getPathname() => config_path($config)], 'config');
                    $this->merge_config_from($file->getPathname(), $key);
                }
            }
        }
    }

    /**
     * Merge config from the given path recursively.
     */
    protected function merge_config_from(string $path, string $key): void
    {
        $existing = config($key, []);
        $module_config = require $path;

        config([$key => array_replace_recursive($existing, $module_config)]);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->nameLower);
        $sourcePath = module_path($this->name, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->nameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->nameLower);

        Blade::componentNamespace(config('modules.namespace') . '\\' . $this->name . '\\View\\Components', $this->nameLower);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->nameLower)) {
                $paths[] = $path . '/modules/' . $this->nameLower;
            }
        }

        return $paths;
    }
}
