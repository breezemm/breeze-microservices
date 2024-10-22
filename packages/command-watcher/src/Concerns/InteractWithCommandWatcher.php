<?php

namespace MyanmarCyberYouths\CommandWatcher\Concerns;

use MyanmarCyberYouths\CommandWatcher\Contracts\HasFilePaths;
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
        $this->line('<options=bold;bg=blue> INFO </> Command Watcher Started');

        if (! $this->startFileWatcher()) {
            return 1;
        }

        $this->listenForFileChanges();

        return 0;
    }

    public function startFileWatcher(): bool
    {
        $this->process = Process::fromShellCommandline($this->shellCommand())
            ->setTty(Process::isTtySupported())
            ->setTimeout(null);

        $this->process->start(fn ($type, $output) => $this->info($output));

        return ! $this->process->isTerminated();
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

        if ($this instanceof HasFilePaths) {
            $filePaths = array_merge($filePaths, $this->getFilePaths());
        }

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
        $this->line('<options=bold;bg=blue> INFO </> Restarting Command Watcher');
        $this->startFileWatcher();
    }
}
