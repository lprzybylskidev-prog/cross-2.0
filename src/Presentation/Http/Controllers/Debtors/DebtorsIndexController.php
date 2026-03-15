<?php

declare(strict_types=1);

namespace Cross\Presentation\Http\Controllers\Debtors;

use App\Http\Controllers\Controller;
use Cross\Application\Debtors\GetDebtorsPageData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class DebtorsIndexController extends Controller
{
    public function __invoke(Request $request, GetDebtorsPageData $getDebtorsPageData): Response
    {
        $userId = $request->user()?->getKey();

        return Inertia::render('Debtors/Index', $getDebtorsPageData->handle($userId));
    }
}
