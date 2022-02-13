<?php
namespace App\Repositories;

use App\Models\Command;
use Illuminate\Support\Facades\Cache;
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
    public function saveCommand(string $title, int $userID): Command
    {
        $command = Command::create([
            "title" => $title,
            "user_id" => $userID,
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
    public function updateCommand(string $title, Command $command): Command
    {
        $command->title = $title;
        $command->save();

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
     * Get all user's Commands from Database
     *
     * @param [type] $userID
     * @return EloquentCollection
     */
    public function getUserCommands($userID): EloquentCollection
    {
        $commands = Cache::remember("userCommands." . $userID, $this->cacheDuration, function () use ($userID) {
            $commands = Command::where("user_id", $userID)
                ->orderBy("title", "asc")
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
