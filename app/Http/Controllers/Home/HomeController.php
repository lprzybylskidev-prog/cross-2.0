<?php

declare(strict_types=1);

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Cross\Application\Home\GetHomePageData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class HomeController extends Controller
{
    public function __invoke(Request $request, GetHomePageData $getHomePageData): Response
    {
        return Inertia::render('Welcome', $getHomePageData->handle($request->user()));
    }
}
