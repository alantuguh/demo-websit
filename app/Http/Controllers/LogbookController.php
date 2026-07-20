<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function getRecentLogbook()
    {
        return Logbook::recent();
    }
}
