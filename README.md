<h1 align="center">Setting Menu</h1>

This package provides implementation of setting menu in repository pattern for Lumen and Laravel besides REST API starterpack of admin management with no intervention to codebase and keep clean.

Getting Started
---

Installation :

```
composer require tripteki/laravelphp-setting-menu
```

How to use it :

- Put `Tripteki\SettingMenu\Providers\SettingMenuServiceProvider` to service provider configuration list.

- Put `Tripteki\SettingMenu\Providers\SettingMenuServiceProvider::ignoreMigrations()` into `register` provider, then publish migrations file into your project's directory with running (optionally) :

```
php artisan vendor:publish --tag=tripteki-laravelphp-setting-menu-migrations
```

- Migrate.

```
php artisan migrate
```

- Publish tests file into your project's directory with running (optionally) :

```
php artisan vendor:publish --tag=tripteki-laravelphp-setting-menu-tests
```

- Sample :

```php
use Tripteki\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository;
use Tripteki\SettingMenu\Contracts\Repository\ISettingMenuRepository;

$menuRepository = app(ISettingMenuDetailRepository::class);

// $menuRepository->create("headernavbar", "home", [ "category" => null, "icon" => "md-home", "title" => "Home", "description" => "Home Page", ]); //
// $menuRepository->delete("headernavbar", "home"); //
// $menuRepository->update("headernavbar", "home", [ "icon" => "fa-home", ]); //
// $menuRepository->get("headernavbar", "home"); //
// $menuRepository->all("headernavbar"); //

$repository = app(ISettingMenuRepository::class);
// $repository->setUser(...); //
// $repository->getUser(); //

// $repository->move(null, "dashboard", "sidenavbar"); // Attach "dashboard" menu to "base" menu that is part of "sidenavbar"...
// $repository->move(null, "home", "headernavbar"); // Attach "home" menu to "base" menu that is part of "headernavbar"...
// $repository->move(null, "profile", "headernavbar"); // Attach "profile" menu to "base" menu that is part of "headernavbar"...
// $repository->move(null, "about", "headernavbar"); // Attach "about" menu to "base" menu that is part of "headernavbar"...
// $repository->move(null, "media", "sidenavbar"); // Attach "media" menu to "base" menu that is part of "sidenavbar"...
// $repository->move("media", null, "sidenavbar"); // Detach "media" menu from "base" menu that is part of "sidenavbar"...
// $repository->move("about", null, "headernavbar"); // Detach "about" menu from "base" menu that is part of "headernavbar"...
// $repository->move("profile", null, "headernavbar"); // Detach "profile" menu from "base" menu that is part of "headernavbar"...
// $repository->move("home", null, "headernavbar"); // Detach "home" menu from "base" menu that is part of "headernavbar"...
// $repository->move("dashboard", null, "sidenavbar"); // Attach "dashboard" menu to "base" menu that is part of "sidenavbar"...
// $repository->move("media", "dashboard", "sidenavbar"); // Move "media" menu from "base" menu to inside "dashboard" menu that is part of "sidenavbar"...
// $repository->move("profile", "home", "headernavbar"); // Move "profile" menu from "base" menu to inside "home" menu that is part of "headernavbar"...
// $repository->move("about", "home.profile", "headernavbar"); // Move "about" menu from "base" menu to inside "home"->"profile" menu that is part of "headernavbar"...
// $repository->move("home.profile.about", "home", "headernavbar"); // Move "about" menu from inside "profile"->"about" menu to inside "home" menu that is part of "headernavbar"...
// $repository->all("headernavbar"); //
// $repository->all("sidenavbar"); //
```

- Generate swagger files into your project's directory with putting this into your annotation configuration (optionally) :

```
base_path("app/Http/Controllers/SettingMenu")
```

```
base_path("app/Http/Controllers/Admin/SettingMenu")
```

Usage
---

`php artisan adminer:install:setting:menu`

Author
---

- Trip Teknologi ([@tripteki](https://linkedin.com/company/tripteki))
- Hasby Maulana ([@hsbmaulana](https://linkedin.com/in/hsbmaulana))
