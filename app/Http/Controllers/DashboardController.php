<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $batches = Batch::orderBy('nama')->get();

        return view('dashboard.index', compact('batches'));
    }
}