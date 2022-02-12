<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Repositories\CollectionRepository;

class CollectionController extends Controller
{
    protected $collectionRepo;

    public function __construct(CollectionRepository $collectionRepo)
    {
        $this->collectionRepo = $collectionRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $collections = $this->collectionRepo->getAllCollections();

        return response($collections, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => ["required", "string", "max:50"],
            "user_id" => ["required", "exists:users,id"],
        ]);

        $collection = Collection::create([
            "title" => $request->title,
            "user_id" => $request->user_id,
        ]);

        return response("Collection was successfully added", 200);
    }

    /**
     * Display a listing of all user collections.
     *
     * @return \Illuminate\Http\Response
     */
    public function userCollections(int $userID)
    {
        $collections = $this->collectionRepo->getUserCollections($userID);

        return response($collections, 200);
    }

    /**
     * Display a single user collection.
     *
     * @return \Illuminate\Http\Response
     */
    public function userCollection(User $user, Collection $collection)
    {
        if ($user->cannot("view", $collection)) {
            abort(403);
        }

        return response($collection, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collection $collection)
    {
        $user = Auth::user();

        if ($user->cannot("update", $collection)) {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
