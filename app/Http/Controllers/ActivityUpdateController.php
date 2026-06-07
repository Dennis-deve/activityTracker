<?php

namespace App\Http\Controllers;

use App\Models\ActivityUpdate;
use App\Models\DailyActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityUpdateController extends Controller
{
    public function store(Request $request, DailyActivityLog $dailyActivityLog)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,done',
            'remark' => 'nullable|string|max:1000',
        ]);

        // Create the update record
        ActivityUpdate::create([
            'daily_activity_log_id' => $dailyActivityLog->id,
            'user_id' => Auth::id(),
            'status' => $validated['status'],
            'remark' => $validated['remark'] ?? null,
            'updated_at_time' => Carbon::now(),
        ]);

        // Update the parent log's current status
        $dailyActivityLog->update(['current_status' => $validated['status']]);

        return redirect()->back()->with('success', 'Activity status updated successfully.');
    }
}
