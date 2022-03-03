<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hashids\Hashids;
use App\Models\Command;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\CommandRepository;

class CommandController extends Controller
{
    protected $commandRepo;

    public function __construct(CommandRepository $commandRepo)
    {
        $this->commandRepo = $commandRepo;
    }

    /**
     * Display all Commands
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        $search = $request["search"];
        $sort = $request["sort"];
        $commands = $this->commandRepo->getPaginatedCommands($search, $sort);

        return response($commands, 200);
    }

    /**
     * Display a user's Commands
     *
     * @param integer $userID
     * @return Response
     */
    public function userCommands(int $userID): Response
    {
        $commands = $this->commandRepo->getUserCommands($userID);

        return response($commands, 200);
    }

    /**
     * Display a user's Command
     *
     * @param User $user
     * @param Command $command
     * @return Response
     */
    public function userCommand(User $user, Command $command): Response
    {
        if ($user->cannot("view", $command)) {
            abort(403);
        }

        return response($command, 200);
    }

    /**
     * Display a Collection's Commands
     *
     * @param integer $userID
     * @return Response
     */
    public function collectionCommands(Request $request, string $encryptedID): Response
    {
        if (!empty($encryptedID)) {
            $hashids = new Hashids("", 10);
            $collectionID = $hashids->decode($encryptedID);
            $collection = Collection::where("id", $collectionID[0])->first();
            if (!empty($collection)) {
                $search = $request["search"];
                $sort = $request["sort"];

                $commands = $this->commandRepo->getPaginatedCommands($search, $sort, $collection->id);
                return response($commands, 200);
            }
        }

        return response("", 404);
    }

    /**
     * Sort a user's Commands
     *
     * @param integer $userID
     * @return Response
     */
    public function sortCollectionCommands(string $encryptedID, Request $request): Response
    {
        if (!empty($encryptedID)) {
            $hashids = new Hashids("", 10);
            $collectionID = $hashids->decode($encryptedID);
            $collection = Collection::where("id", $collectionID[0])->first();
            if (!empty($collection)) {
                $commands = $this->commandRepo->sortCollectionCommands($collection->id, $request["commands"]);

                return response($commands, 200);
            }
        }

        return response("", 404);
    }

    /**
     * Save a Command
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $request->validate([
            "command" => ["required", "string", "max:150"],
            "description" => ["nullable", "string", "max:150"],
            "collection" => ["required", "exists:collections,id"],
        ]);
        $this->commandRepo->saveCommand($request["command"], $request["description"], $request["collection"]);

        if (!empty($request["copy_id"])) {
            $this->commandRepo->updateCommandAdditions($request["copy_id"]);
        }
        $commands = $this->commandRepo->getPaginatedCommands("", 4);
        return response($commands, 200);
    }

    /**
     * Update a Command
     *
     * @param Request $request
     * @param Command $command
     * @return Response
     */
    public function update(Request $request, Command $command): Response
    {
        $request->validate([
            "command" => ["required", "string", "max:255"],
            "description" => ["nullable", "string", "max:50"],
            "collection" => ["required", "exists:collections,id"],
        ]);

        $user = User::where("id", $request["user_id"])->firstOrFail();

        if ($user->cannot("update", $command)) {
            abort(403);
        }

        $command = $this->commandRepo->updateCommand($request["command"], $request["description"], $request["collection"], $command);
        $commands = $this->commandRepo->getPaginatedCommands("", 4);
        return response($commands, 200);
    }

    /**
     * Delete a Command
     *
     * @param Request $request
     * @param Command $command
     * @return void
     */
    public function destroy(Request $request, Command $command)
    {
        $user = User::where("id", $request["userID"])->firstOrFail();
        if ($user->cannot("delete", $command)) {
            abort(403);
        }

        $command->delete();
        $commands = $this->commandRepo->getPaginatedCommands("", 4);
        return response($commands, 200);
    }
}
