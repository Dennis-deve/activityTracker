<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityUpdate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->subDays(7)->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());
        $activityId = $request->input('activity_id');
        $status = $request->input('status');
        $userId = $request->input('user_id');

        $query = ActivityUpdate::with(['dailyLog.activity', 'user'])
            ->whereHas('dailyLog', function ($q) use ($startDate, $endDate, $activityId) {
                $q->whereBetween('log_date', [$startDate, $endDate]);
                if ($activityId) {
                    $q->where('activity_id', $activityId);
                }
            })
            ->orderBy('updated_at_time', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $updates = $query->paginate(25)->withQueryString();

        // Summary stats
        $summaryQuery = ActivityUpdate::whereHas('dailyLog', function ($q) use ($startDate, $endDate) {
            $q->whereBetween('log_date', [$startDate, $endDate]);
        });
        $totalUpdates = (clone $summaryQuery)->count();
        $doneUpdates = (clone $summaryQuery)->where('status', 'done')->count();
        $pendingUpdates = (clone $summaryQuery)->where('status', 'pending')->count();

        $activities = Activity::orderBy('title')->get();
        $users = User::orderBy('name')->get();

        return view('reports.index', compact(
            'updates', 'startDate', 'endDate', 'activityId', 'status', 'userId',
            'activities', 'users', 'totalUpdates', 'doneUpdates', 'pendingUpdates'
        ));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->subDays(7)->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());
        $activityId = $request->input('activity_id');
        $status = $request->input('status');
        $userId = $request->input('user_id');

        $query = ActivityUpdate::with(['dailyLog.activity', 'user'])
            ->whereHas('dailyLog', function ($q) use ($startDate, $endDate, $activityId) {
                $q->whereBetween('log_date', [$startDate, $endDate]);
                if ($activityId) {
                    $q->where('activity_id', $activityId);
                }
            })
            ->orderBy('updated_at_time', 'desc');

        if ($status) {
            $query->where('status', $status);
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }

        $updates = $query->get();

        $response = new StreamedResponse(function () use ($updates) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Date', 'Activity', 'Status', 'Updated By', 'Employee ID', 'Department', 'Remark', 'Time']);

            foreach ($updates as $update) {
                fputcsv($handle, [
                    $update->dailyLog->log_date->format('Y-m-d'),
                    $update->dailyLog->activity->title ?? 'N/A',
                    ucfirst($update->status),
                    $update->user->name ?? 'N/A',
                    $update->user->employee_id ?? 'N/A',
                    $update->user->department ?? 'N/A',
                    $update->remark ?? '',
                    $update->updated_at_time->format('H:i:s'),
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="activity-report-' . $startDate . '-to-' . $endDate . '.csv"');

        return $response;
    }
}
