<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Repositories\CollectionRepository;
use Illuminate\Http\Response;

class CollectionController extends Controller
{
    protected $collectionRepo;

    public function __construct(CollectionRepository $collectionRepo)
    {
        $this->collectionRepo = $collectionRepo;
    }

    /**
     * Display all Collections
     *
     * @return Response
     */
    public function index(): Response
    {
        $collections = $this->collectionRepo->getAllCollections();

        return response($collections, 200);
    }

    /**
     * Display a user's Collections
     *
     * @param integer $userID
     * @return Response
     */
    public function userCollections(int $userID): Response
    {
        $collections = $this->collectionRepo->getUserCollections($userID);

        return response($collections, 200);
    }

    /**
     * Display a user's Collection
     *
     * @param User $user
     * @param Collection $collection
     * @return Response
     */
    public function userCollection(User $user, Collection $collection): Response
    {
        if ($user->cannot("view", $collection)) {
            abort(403);
        }

        return response($collection, 200);
    }

    /**
     * Save a Collection
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $request->validate([
            "title" => ["required", "string", "max:50"],
            "user_id" => ["required", "exists:users,id"],
        ]);

        $this->collectionRepo->saveCollection($request["title"], $request["user_id"]);
        $collections = $this->collectionRepo->getUserCollections($request["user_id"]);
        return response($collections, 200);
    }

    /**
     * Update a Collection
     *
     * @param Request $request
     * @param Collection $collection
     * @return Response
     */
    public function update(Request $request, Collection $collection): Response
    {
        $request->validate([
            "title" => ["required", "string", "max:50"],
            "user_id" => ["required", "exists:users,id"],
        ]);

        $user = User::where("id", $request["user_id"])->firstOrFail();

        if ($user->cannot("update", $collection)) {
            abort(403);
        }

        $collection = $this->collectionRepo->updateCollection($request["title"], $collection);

        return response($collection, 200);
    }

    /**
     * Delete a Collection
     *
     * @param Request $request
     * @param Collection $collection
     * @return void
     */
    public function destroy(Request $request, Collection $collection)
    {
        $user = User::where("id", $request["userID"])->firstOrFail();
        if ($user->cannot("delete", $collection)) {
            abort(403);
        }

        $collection->delete();
        $collections = $this->collectionRepo->getUserCollections($user->id);
        return response($collections, 200);
    }
}
