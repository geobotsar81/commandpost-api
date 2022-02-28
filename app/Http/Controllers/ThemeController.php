<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Repositories\CollectionRepository;
use Illuminate\Http\Response;

class ThemeController extends Controller
{
    /**
     * Get a User's theme
     *
     * @param User $user
     * @return Response
     */
    public function get(User $user): Response
    {
        return response($user->theme, 200);
    }

    /**
     * Update a User's theme
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user): Response
    {
        $theme = $request["themeID"];
        $user->update([
            "theme" => $theme,
        ]);

        return response($user->theme, 200);
    }
}
