<?php

namespace App\Http\Controllers;

use App\Models\AlumniStory;
use Illuminate\Http\Request;

class AlumniStoryController extends Controller
{
    /**
     * Display a listing of active alumni for public view.
     */
    public function index()
    {
        $alumni = AlumniStory::where('is_active', true)
            ->orderBy('angkatan', 'desc')
            ->get()
            ->groupBy('angkatan');
            
        return view('alumni-story.index', compact('alumni'));
    }
}
