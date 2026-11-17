<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class RiwayatAktivitasController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company_id;

        $aktivitas = ActivityLog::with('user')
            ->where('company_id', $companyId)
            ->latest()
            ->paginate(15);

        return view('aktivitas.index', compact('aktivitas'));
    }
}
