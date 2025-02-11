<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use App\Models\Rarity;
use App\Models\MonsterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MonsterController extends Controller
{
    public function index()
    {
        $monsters = Monster::with(['type', 'rarety'])
            ->orderBy('created_at', 'desc')
            ->paginate(9); 

        return view('monsters.monsters', compact('monsters'));
    }
}
