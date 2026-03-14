<?php

declare(strict_types=1);

namespace App\Http\Controllers\Debtors;

use App\Http\Controllers\Controller;
use Cross\Application\Debtors\GetDebtorsPageData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class DebtorsIndexController extends Controller
{
    public function __invoke(Request $request, GetDebtorsPageData $getDebtorsPageData): Response
    {
        return Inertia::render('Debtors/Index', $getDebtorsPageData->handle($request->user()));
    }
}
