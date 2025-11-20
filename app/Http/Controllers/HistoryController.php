<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $history = Auth::user()->calculationHistories()->latest()->get(); 
        return view('history.index', compact('history'));
    }
}
