<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Ambil perPage dari query string, default 10
        $perPage = request()->query('perPage', 10);

        $logs = ActivityLog::with('user')
            ->latest()
            ->paginate($perPage);

        return view('activity_logs.index', compact('logs', 'perPage'));
    }
}
