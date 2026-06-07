<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::with('creator')->latest()->paginate(15);
        return view('activities.index', compact('activities'));
    }

    public function create()
    {
        return view('activities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'is_recurring' => 'boolean',
        ]);

        Activity::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'] ?? null,
            'is_recurring' => $request->boolean('is_recurring', true),
            'is_active' => true,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('activities.index')
            ->with('success', 'Activity created successfully.');
    }

    public function edit(Activity $activity)
    {
        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'is_recurring' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $activity->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'] ?? null,
            'is_recurring' => $request->boolean('is_recurring', true),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('activities.index')
            ->with('success', 'Activity updated successfully.');
    }

    public function destroy(Activity $activity)
    {
        $activity->update(['is_active' => false]);
        return redirect()->route('activities.index')
            ->with('success', 'Activity deactivated successfully.');
    }
}
