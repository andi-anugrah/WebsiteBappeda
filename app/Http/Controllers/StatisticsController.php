<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    /**
     * Display statistics for frontend
     */
    public function statistics()
    {
        $statistics = Statistic::active()->ordered()->get();
        
        return view('statistics', compact('statistics'));
    }
}