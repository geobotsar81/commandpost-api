<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Display the jobs sitemap
     *
     * @return Response
     */
    public function index(): Response
    {
        $collections = Collection::orderBy("created_at", "desc")->get();

        return response()
            ->view("sitemap", [
                "collections" => $collections,
            ])
            ->header("Content-Type", "text/xml");
    }
}
