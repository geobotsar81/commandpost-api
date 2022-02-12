<?php
namespace App\Repositories;

use App\Models\Collection;

class CollectionRepository
{
    public function getAllCollections()
    {
        $collections = Collection::orderBy("title", "asc")->get();

        return $collections;
    }

    public function getUserCollections($userID)
    {
        $collections = Collection::where("user_id", $userID)
            ->orderBy("title", "asc")
            ->get();

        return $collections;
    }

    public function getSingleCollection($collectionID)
    {
        $collections = Collection::where("id", $collectionID)
            ->orderBy("title", "asc")
            ->first();

        return $collections;
    }
}
