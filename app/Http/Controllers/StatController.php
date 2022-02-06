<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatVisit;
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use Illuminate\Support\Facades\Cache;

class StatController extends Controller
{
    
    public function index()
    {
        $statDataProvider = new EloquentDataProvider(StatVisit::query());
        return view('stat-visit', ['dataProvider' => $statDataProvider]);
    }
}
