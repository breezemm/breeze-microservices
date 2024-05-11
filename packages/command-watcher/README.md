# Command Watcher

Watch your laravel long running task with command watcher in development.

## Installation

You can install the package via composer:

```bash
composer require myanmarcyberyouths/command-watcher --dev
```

## Prerequisites

In your project, you should have the JavaScript package `chokidar` installed. You can install it via npm:

```bash
bun add chokidar --save-dev
```

## Usage

You will need to implement the `ShouldWatch` interface and use the `InteractWithCommandWatcher` trait in your command
class. This will allow you to interact with the command watcher. When you run the command, it will be watched by the
command watcher.

```php
<?php


use Illuminate\Console\Command;
use Illuminate\Console\Command;
use MyanmarCyberYouths\CommandWatcher\Concerns\InteractWithCommandWatcher;
use MyanmarCyberYouths\CommandWatcher\Contracts\ShouldWatch;

class StreamerWatchCommand extends Command implements ShouldWatch
{
    use InteractWithCommandWatcher;

    protected $signature = 'streamer:watch';

    protected $description = 'Watch redis stream events';

    public function shellCommand(): string
    {
        return 'php artisan streamer:listen --all';
    }
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

