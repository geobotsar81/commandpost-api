<?php
namespace App\Repositories;

use App\Models\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class CommandRepository
{
    protected $cacheDuration;

    public function __construct()
    {
        $this->cacheDuration = config("cache.duration");
    }

    /**
     * Save a Command in Database
     *
     * @param string $title
     * @param integer $userID
     * @return Command
     */
    public function saveCommand(string $command, ?string $description, int $collectionID): Command
    {
        $command = Command::create([
            "command" => $command,
            "description" => $description ?? null,
            "collection_id" => $collectionID,
        ]);

        return $command;
    }

    /**
     * Update a Command in Database
     *
     * @param string $title
     * @param Command $command
     * @return Command
     */
    public function updateCommand(string $commandCode, ?string $description, int $collectionID, Command $command): Command
    {
        $command->update([
            "command" => $commandCode,
            "description" => $description ?? null,
            "collection_id" => $collectionID,
        ]);

        return $command;
    }

    /**
     * Get all Commands from Database
     *
     * @return EloquentCollection
     */
    public function getAllCommands(): EloquentCollection
    {
        $commands = Command::orderBy("title", "asc")->get();

        return $commands;
    }

    /**
     * Get a paginated list of commands
     *
     * @param String $search
     * @return LengthAwarePaginator
     */
    public function getPaginatedCommands(?string $search, int $sort): ?LengthAwarePaginator
    {
        $sortOptions = [];
        switch ($sort) {
            case 1:
                $sortOptions["field"] = "command";
                $sortOptions["order"] = "asc";
                break;
            case 2:
                $sortOptions["field"] = "command";
                $sortOptions["order"] = "desc";
                break;
            case 3:
                $sortOptions["field"] = "created_at";
                $sortOptions["order"] = "asc";
                break;
            case 4:
                $sortOptions["field"] = "created_at";
                $sortOptions["order"] = "desc";
                break;
        }

        $commands = Command::with(["collection"])
            ->where("command", "LIKE", "%{$search}%")
            ->orWhereHas("collection", function ($q) use ($search) {
                $q->where("title", "LIKE", "%{$search}%");
            })
            ->orderBy($sortOptions["field"], $sortOptions["order"])
            ->paginate(8);

        return $commands;
    }

    /**
     * Get all user's Commands from Database
     *
     * @param [type] $userID
     * @return EloquentCollection
     */
    public function getUserCommands($userID): EloquentCollection
    {
        $commands = Cache::remember("userCommands." . $userID, $this->cacheDuration, function () use ($userID) {
            $commands = Command::whereHas("collection", function ($q) use ($userID) {
                $q->where("user_id", "=", $userID);
            })
                ->with("collection")
                ->orderBy("command", "asc")
                ->get();

            return $commands;
        });

        return $commands;
    }

    /**
     * Get a single Command from Database
     *
     * @param Command $command
     * @return EloquentCollection
     */
    public function getSingleCommand(Command $command): EloquentCollection
    {
        return $command;
    }
}
