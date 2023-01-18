<?php

namespace Tripteki\SettingMenu\Providers;

use Tripteki\Repository\Providers\RepositoryServiceProvider as ServiceProvider;

class SettingMenuServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $repositories =
    [
        \Tripteki\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository::class => \Tripteki\SettingMenu\Repositories\Eloquent\Admin\SettingMenuDetailRepository::class,
        \Tripteki\SettingMenu\Contracts\Repository\ISettingMenuRepository::class => \Tripteki\SettingMenu\Repositories\Eloquent\SettingMenuRepository::class,
    ];

    /**
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * @return bool
     */
    public static function shouldRunMigrations()
    {
        return static::$runsMigrations;
    }

    /**
     * @return void
     */
    public static function ignoreMigrations()
    {
        static::$runsMigrations = false;
    }

    /**
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->registerPublishers();
        $this->registerMigrations();
    }

    /**
     * @return void
     */
    protected function registerMigrations()
    {
        if ($this->app->runningInConsole() && static::shouldRunMigrations()) {

            $this->loadMigrationsFrom(__DIR__."/../../database/migrations");
        }
    }

    /**
     * @return void
     */
    protected function registerPublishers()
    {
        if (! static::shouldRunMigrations()) {

            $this->publishes(
            [
                __DIR__."/../../database/migrations" => database_path("migrations"),
            ],

            "tripteki-laravelphp-setting-menu-migrations");
        }
    }
};
