<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::latest()->paginate(10);
        return view('plans.index', compact('plans'));
    }

    public function create()
    {
        return view('plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'duration_hours' => 'nullable|integer|min:0',
            'duration_days' => 'nullable|integer|min:0',
            'validity_days' => 'nullable|integer|min:0',
            'pause_limit' => 'nullable|integer|min:0',
            'download_speed_mbps' => 'nullable|numeric|min:0',
            'upload_speed_mbps' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['data_limit_mb'] = null; // Enforce unlimited data limit

        Plan::create($validated);

        return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
    }

    public function show(Plan $plan)
    {
        return view('plans.show', compact('plan'));
    }

    public function edit(Plan $plan)
    {
        return view('plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'duration_hours' => 'nullable|integer|min:0',
            'duration_days' => 'nullable|integer|min:0',
            'validity_days' => 'nullable|integer|min:0',
            'pause_limit' => 'nullable|integer|min:0',
            'download_speed_mbps' => 'nullable|numeric|min:0',
            'upload_speed_mbps' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['data_limit_mb'] = null; // Enforce unlimited data limit

        $plan->update($validated);

        return redirect()->route('plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('plans.index')->with('success', 'Plan deleted successfully.');
    }
}

