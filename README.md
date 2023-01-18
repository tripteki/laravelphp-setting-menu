<h1 align="center">Setting-Menu</h1>

This package provides is an implementation of setting menu in repository pattern for Lumen and Laravel.

Getting Started
---

Installation :

```
$ composer require tripteki/laravelphp-setting-menu
```

How to use it :

- Put `Tripteki\SettingMenu\Providers\SettingMenuServiceProvider` to service provider configuration list.

- Put `Tripteki\SettingMenu\Traits\MenuTrait` to auth's provider model.

- Migrate.

```
$ php artisan migrate
```

- Sample :

```php
use Tripteki\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository;
use Tripteki\SettingMenu\Contracts\Repository\ISettingMenuRepository;

$menuRepository = app(ISettingMenuDetailRepository::class);

// $menuRepository->create("headernavbar", "home", [ "category" => "base", "icon" => "md-home", "title" => "Home", "description" => "Home Page", ]); //
// $menuRepository->delete("headernavbar", "home"); //
// $menuRepository->update("headernavbar", "home", [ "icon" => "fa-home", ]); //
// $menuRepository->get("headernavbar", "home"); //
// $menuRepository->all("headernavbar"); //

$repository = app(ISettingMenuRepository::class);
// $repository->setUser(...); //
// $repository->getUser(); //

// $repository->move(null, "dashboard", "sidenavbar"); //
// $repository->move(null, "home", "headernavbar"); //
// $repository->move(null, "profile", "headernavbar"); //
// $repository->move(null, "about", "headernavbar"); //
// $repository->move(null, "media", "sidenavbar"); //
// $repository->move("media", null, "sidenavbar"); //
// $repository->move("about", null, "headernavbar"); //
// $repository->move("profile", null, "headernavbar"); //
// $repository->move("home", null, "headernavbar"); //
// $repository->move("dashboard", null, "sidenavbar"); //
// $repository->move("media", "dashboard", "sidenavbar"); //
// $repository->move("profile", "home", "headernavbar"); //
// $repository->move("about", "home.profile", "headernavbar"); //
// $repository->move("home.profile.about", "home", "headernavbar"); //
// $repository->all(); //
```

Author
---

- Trip Teknologi ([@tripteki](https://linkedin.com/company/tripteki))
- Hasby Maulana ([@hsbmaulana](https://linkedin.com/in/hsbmaulana))
