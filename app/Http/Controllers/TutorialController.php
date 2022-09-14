<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;

use App\Http\Resources\TutorialResource;

class TutorialController extends Controller
{
    public function index(Request $request)
    {
        $tutorials = Tutorial::enabled()
            ->orderBy('order')
            ->get();

        return TutorialResource::collection($tutorials);
    }
}
