<?php

namespace App\Http\Controllers\Dashboard\Configurations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activityLogs = ActivityLog::orderBy('created_at','desc')->paginate(10);
        
        return view('dashboard.config.activity-log.index')->with([ 
            'activityLogs' => $activityLogs,
            'request' => null,
        ]);
    }
}
