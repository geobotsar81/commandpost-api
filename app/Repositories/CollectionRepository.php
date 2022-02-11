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
}
