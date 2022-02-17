<?php

namespace App\Policies;

use App\Models\Command;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommandPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Command $command)
    {
        return $user->id === $command->collection->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Command $command)
    {
        return $user->id === $command->collection->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Command  $command
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Command $command)
    {
        return $user->id === $command->collection->user_id;
    }
}
