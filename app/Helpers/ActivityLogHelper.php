<?php

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

if (! function_exists('activity_log')) {
    function activity_log($action, $description = null)
    {
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
