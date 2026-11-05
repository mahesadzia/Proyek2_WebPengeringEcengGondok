<?php

namespace App\Http\Controllers;

use App\Models\Batch;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::orderBy('nama')->get();

        return view('batches.index', compact('batches'));
    }
}