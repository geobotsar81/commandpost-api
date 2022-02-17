<?php

namespace App\Observers;

use App\Models\Collection;
use Illuminate\Support\Facades\Cache;

class CollectionObserver
{
    /**
     * Handle the Collection "created" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function created(Collection $collection)
    {
        $this->clearCollectionsCache($collection);
    }

    /**
     * Handle the Collection "updated" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function updated(Collection $collection)
    {
        $this->clearCollectionsCache($collection);
    }

    /**
     * Handle the Collection "deleted" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function deleted(Collection $collection)
    {
        $this->clearCollectionsCache($collection);
    }

    /**
     * Handle the Collection "restored" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function restored(Collection $collection)
    {
        $this->clearCollectionsCache($collection);
    }

    /**
     * Handle the Collection "force deleted" event.
     *
     * @param  \App\Models\Collection  $collection
     * @return void
     */
    public function forceDeleted(Collection $collection)
    {
        $this->clearCollectionsCache($collection);
    }

    public function clearCollectionsCache($collection)
    {
        Cache::forget("userCollections." . $collection->user_id);
    }
}
