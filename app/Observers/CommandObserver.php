<?php

namespace App\Observers;

use App\Models\Command;
use Illuminate\Support\Facades\Cache;

class CommandObserver
{
    /**
     * Handle the Command "created" event.
     *
     * @param  \App\Models\Command  $command
     * @return void
     */
    public function created(Command $command)
    {
        $this->clearCommandsCache($command);
    }

    /**
     * Handle the Command "updated" event.
     *
     * @param  \App\Models\Command  $command
     * @return void
     */
    public function updated(Command $command)
    {
        $this->clearCommandsCache($command);
    }

    /**
     * Handle the Command "deleted" event.
     *
     * @param  \App\Models\Command  $command
     * @return void
     */
    public function deleted(Command $command)
    {
        $this->clearCommandsCache($command);
    }

    /**
     * Handle the Command "restored" event.
     *
     * @param  \App\Models\Command  $command
     * @return void
     */
    public function restored(Command $command)
    {
        $this->clearCommandsCache($command);
    }

    /**
     * Handle the Command "force deleted" event.
     *
     * @param  \App\Models\Command  $command
     * @return void
     */
    public function forceDeleted(Command $command)
    {
        $this->clearCommandsCache($command);
    }

    public function clearCommandsCache($command)
    {
        Cache::forget("userCommands." . $command->collection->user_id);
        Cache::forget("userCollections." . $command->collection->user_id);
    }
}
