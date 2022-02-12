<?php
namespace App\Repositories;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class CollectionRepository
{
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
        $collection->title = $title;
        $collection->save();

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
        $collections = Collection::where("user_id", $userID)
            ->orderBy("title", "asc")
            ->get();

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
