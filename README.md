# DuCore - Dusky Core PHP framework

Lightweight collection of classes for setting up a small webpage in no time with no extra libraries.

This codebase borrows many ideas from many places to create very simple (or at least attempts to create a very simple) php "framework" that does not weight down onto the system too much.

> Note that this codebase was built for PHP 7.1+

### Autoloading rules:
+ All classes must be inside `classes` folder
+ All classes must be namespaced with their respective folder names (ex: `Controllers` inside controllers folder)
+ Classes may have underscore names but CamelCase naming is preferred

Example:
```php
// This will load file User.php inside folder classes/models
use Models\User;
// Also allowed
new Models_User;
// This should produce the same result but is not guaranteed
```

### Structure

All framework specific files are located in the root and in `ducore` folder.
This repository comes with basic configuration files added and basic `index.php` to allow for easy start of a new project.

Following is the current general code structure
```
root
|
|--classes # Should contain all project classes
|  |--controllers       # All your controllers should be here
|  |  `--BaseController # Basic controller included in the project
|  |--models            # All models must be here
|  |  `--User           # Basic model included in the project
|  `--views             # All view control classes must be here
|
|--config # Move all your config here to keep it organized
|  |--database.php # DB config for PDO
|  |--default.php  # General purpose configuration
|  `--routes.php   # URI to function call mapping
|
|--ducore # Framework classes
|  |--_readme.md
|  |--App        # Main application class
|  |--Arr        # Array utility class
|  |--BaseModel  # Base Model class
|  |--Database   # Database connection class
|  |--Json       # JSON utility class
|  |--Request    # Request utility class
|  |--Response   # Response utility class
|  |--Route      # Route handler
|  `--Strings    # String utility class
|
|--public # This should be your vhost root
|  |--.htaccess # Example htaccess for apache
|  `--index.php # Example index.php
|
|--bootstrap.php # Framework bootstrapper
|--phpinfo.php
`--README.md
```
