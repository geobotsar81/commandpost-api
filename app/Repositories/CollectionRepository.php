<?php
namespace App\Repositories;

use App\Models\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class CollectionRepository
{
    protected $cacheDuration;

    public function __construct()
    {
        $this->cacheDuration = config("cache.duration");
    }

    /**
     * Save a Collection in Database
     *
     * @param string $title
     * @param integer $userID
     * @return Collection
     */
    public function saveCollection(string $title, int $userID): Collection
    {
        $collection = Collection::create([
            "title" => $title,
            "user_id" => $userID,
        ]);

        return $collection;
    }

    /**
     * Update a Collection in Database
     *
     * @param string $title
     * @param Collection $collection
     * @return Collection
     */
    public function updateCollection(string $title, Collection $collection): Collection
    {
        $collection->update([
            "title" => $title,
        ]);

        return $collection;
    }

    /**
     * Update a Collection's views in Database
     *
     * @param Collection $collection
     * @return Collection
     */
    public function updateCollectionViews(Collection $collection): Collection
    {
        $views = $collection->views + 1;
        $collection->update([
            "views" => $views,
        ]);

        return $collection;
    }

    /**
     * Get all Collections from Database
     *
     * @return EloquentCollection
     */
    public function getAllCollections(): EloquentCollection
    {
        $collections = Collection::orderBy("title", "asc")->get();

        return $collections;
    }

    /**
     * Get all user's Collections from Database
     *
     * @param [type] $userID
     * @return EloquentCollection
     */
    public function getUserCollections($userID): EloquentCollection
    {
        $collections = Cache::remember("userCollections." . $userID, $this->cacheDuration, function () use ($userID) {
            $collections = Collection::where("user_id", $userID)
                ->with("commands")
                ->orderBy("order", "asc")
                ->get();

            return $collections;
        });

        return $collections;
    }

    /**
     * Sort user's Collections
     *
     * @param [type] $userID
     * @return EloquentCollection
     */
    public function sortUserCollections($userID, $sortedCollections): EloquentCollection
    {
        if (!empty($sortedCollections)) {
            $index = 0;
            foreach ($sortedCollections as $currentCollection) {
                $index++;
                $collection = Collection::where("id", $currentCollection["id"])->first();
                $collection->update([
                    "order" => $index,
                ]);
            }
        }

        $collections = $this->getUserCollections($userID);

        return $collections;
    }

    /**
     * Get a single Collection from Database
     *
     * @param Collection $collection
     * @return EloquentCollection
     */
    public function getSingleCollection(Collection $collection): EloquentCollection
    {
        return $collection;
    }
}
