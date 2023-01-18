<?php

namespace Tripteki\SettingMenu\Console\Commands;

use Tripteki\Helpers\Contracts\AuthModelContract;
use Tripteki\Helpers\Helpers\ProjectHelper;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = "adminer:install:setting:menu";

    /**
     * @var string
     */
    protected $description = "Install the setting menu stack";

    /**
     * @var \Tripteki\Helpers\Helpers\ProjectHelper
     */
    protected $helper;

    /**
     * @param \Tripteki\Helpers\Helpers\ProjectHelper $helper
     * @return void
     */
    public function __construct(ProjectHelper $helper)
    {
        parent::__construct();

        $this->helper = $helper;
    }

    /**
     * @return int
     */
    public function handle()
    {
        $this->call("adminer:install:setting");
        $this->installStack();

        return 0;
    }

    /**
     * @return int|null
     */
    protected function installStack()
    {
        (new Filesystem)->ensureDirectoryExists(base_path("routes/user"));
        (new Filesystem)->ensureDirectoryExists(base_path("routes/admin"));
        (new Filesystem)->ensureDirectoryExists(base_path("routes/user/setting"));
        (new Filesystem)->ensureDirectoryExists(base_path("routes/admin/setting"));
        (new Filesystem)->copy(__DIR__."/../../../stubs/routes/user/setting/menu.php", base_path("routes/user/setting/menu.php"));
        (new Filesystem)->copy(__DIR__."/../../../stubs/routes/admin/setting/menu.php", base_path("routes/admin/setting/menu.php"));
        $this->helper->putRoute("api.php", "user/setting/menu.php");
        $this->helper->putRoute("api.php", "admin/setting/menu.php");
        
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Controllers/Setting/Menu"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Controllers/Setting/Menu", app_path("Http/Controllers/Setting/Menu"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Requests/Settings/Menus"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Requests/Settings/Menus", app_path("Http/Requests/Settings/Menus"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Controllers/Admin/Setting/Menu"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Controllers/Admin/Setting/Menu", app_path("Http/Controllers/Admin/Setting/Menu"));
        (new Filesystem)->ensureDirectoryExists(app_path("Imports/Settings/Menus"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Imports/Settings/Menus", app_path("Imports/Settings/Menus"));
        (new Filesystem)->ensureDirectoryExists(app_path("Exports/Settings/Menus"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Exports/Settings/Menus", app_path("Exports/Settings/Menus"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Requests/Admin/Settings/Menus"));
        (new Filesystem)->copyDirectory(__DIR__."/../../../stubs/app/Http/Requests/Admin/Settings/Menus", app_path("Http/Requests/Admin/Settings/Menus"));
        (new Filesystem)->ensureDirectoryExists(app_path("Http/Responses"));

        $this->helper->putTrait($this->helper->classToFile(get_class(app(AuthModelContract::class))), \Tripteki\SettingMenu\Traits\MenuTrait::class);

        $this->info("Adminer Setting Menu scaffolding installed successfully.");
    }
};
