<?php

namespace MyanmarCyberYouths\CommandWatcher\Concerns;

use CommandWatcher\CommandWatcher\CommandWatcher\Contracts\ShouldWatch;
use Spatie\Watcher\Exceptions\CouldNotStartWatcher;
use Spatie\Watcher\Watch;
use Symfony\Component\Process\Process;


trait InteractWithCommandWatcher
{
    public Process $process;

    /**
     * @throws CouldNotStartWatcher
     */
    public function handle(): int
    {
        if (!$this instanceof ShouldWatch) {
            $this->line("<options=bold;bg=red> ERROR </> Command does not implement " . ShouldWatch::class . " interface");
            return 1;
        }

        $this->line("<options=bold;bg=blue> INFO </> Command Watcher Started");

        if (!$this->startFileWatcher()) {
            return 1;
        }

        $this->listenForFileChanges();

        return 0;
    }

    public
    function startFileWatcher(): bool
    {
        $this->process = Process::fromShellCommandline($this->shellCommand())
            ->setTty(Process::isTtySupported())
            ->setTimeout(null);

        $this->process->start(fn($type, $output) => $this->info($output));

        return !$this->process->isTerminated();
    }

    /**
     * @throws CouldNotStartWatcher
     */
    public function listenForFileChanges(): void
    {
        $filePaths = [
            app_path(),
            config_path(),
            database_path(),
            resource_path('views'),
            base_path('.env'),
            base_path('composer.lock'),
        ];

        Watch::paths($filePaths)
            ->onAnyChange(function () {
                $this->restartFileWatcher();
            })
            ->shouldContinue(function (): bool {
                return true;
            })
            ->start();
    }

    public function restartFileWatcher(): void
    {
        $this->line("<options=bold;bg=blue> INFO </> Restarting Command Watcher");
        $this->startFileWatcher();
    }
}
