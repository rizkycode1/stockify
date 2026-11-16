<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class RiwayatAktivitasController extends Controller
{
    public function index()
    {
        $aktivitas = ActivityLog::with('user')
            ->latest()
            ->paginate(15);

        return view('aktivitas.index', compact('aktivitas'));
    }
}
