<?php

namespace App\Http\Controllers;

use App\Models\ActivityUpdate;
use App\Models\DailyActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandoverController extends Controller
{
    public function assign(Request $request, DailyActivityLog $dailyActivityLog)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
            'remark' => 'nullable|string|max:1000',
        ]);

        $assignee = User::findOrFail($validated['assigned_to']);
        $assigner = Auth::user();

        // Update the daily log assignment
        $dailyActivityLog->update([
            'assigned_to' => $assignee->id,
            'assigned_by' => $assigner->id,
            'assigned_at' => Carbon::now(),
        ]);

        // Create an audit trail entry
        $remarkText = "Handed over to {$assignee->name} by {$assigner->name}";
        if (!empty($validated['remark'])) {
            $remarkText .= ". Note: " . $validated['remark'];
        }

        ActivityUpdate::create([
            'daily_activity_log_id' => $dailyActivityLog->id,
            'user_id' => $assigner->id,
            'status' => $dailyActivityLog->current_status,
            'remark' => $remarkText,
            'updated_at_time' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', "Activity handed over to {$assignee->name} successfully.");
    }
}
