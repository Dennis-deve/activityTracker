<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\DailyActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $selectedDate = Carbon::parse($date);
        $dateString = $selectedDate->format('Y-m-d');
        
        // Auto-create daily logs for active activities that don't have one for this date
        $activeActivities = Activity::active()->get();
        foreach ($activeActivities as $activity) {
            $exists = DailyActivityLog::where('activity_id', $activity->id)
                ->whereDate('log_date', $dateString)
                ->exists();
            
            if (!$exists) {
                DailyActivityLog::create([
                    'activity_id' => $activity->id,
                    'log_date' => $dateString,
                    'current_status' => 'pending',
                ]);
            }
        }
        
        // Get all daily logs for this date with relationships
        $dailyLogs = DailyActivityLog::with([
                'activity', 
                'updates' => function($q) { $q->with('user')->orderBy('updated_at_time', 'desc'); },
                'assignedUser',
                'assignedByUser'
            ])
            ->whereDate('log_date', $dateString)
            ->get()
            ->sortBy('activity.title');
        
        // Statistics
        $totalActivities = $dailyLogs->count();
        $doneCount = $dailyLogs->where('current_status', 'done')->count();
        $pendingCount = $dailyLogs->where('current_status', 'pending')->count();
        $assignedCount = $dailyLogs->whereNotNull('assigned_to')->count();
        
        // Team members for assignment dropdown
        $teamMembers = User::orderBy('name')->get();
        
        return view('dashboard', compact(
            'dailyLogs', 'selectedDate', 'totalActivities', 
            'doneCount', 'pendingCount', 'assignedCount', 'teamMembers'
        ));
    }
}
