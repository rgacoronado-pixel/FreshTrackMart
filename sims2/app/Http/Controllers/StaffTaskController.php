<?php

namespace App\Http\Controllers;

use App\Models\StaffTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffTaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tasks = StaffTask::query()
            ->where('assigned_to', $user->id)
            ->orWhere('created_by', $user->id)
            ->orderByRaw("case when status = 'pending' then 1 when status = 'in_progress' then 2 else 3 end")
            ->latest('updated_at')
            ->get();

        return view('staff.tasks', compact('tasks'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'area' => 'required|string|max:120',
            'due_at' => 'nullable|date',
        ]);

        StaffTask::create([
            'task_code' => $this->nextTaskCode(),
            'description' => $validated['description'],
            'area' => $validated['area'],
            'status' => 'pending',
            'assigned_to' => $request->user()?->id,
            'created_by' => $request->user()?->id,
            'due_at' => $validated['due_at'] ?? null,
        ]);

        return redirect()->route('staff.tasks')->with('success', 'New task added successfully.');
    }

    public function updateStatus(Request $request, StaffTask $staffTask): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $userId = $request->user()?->id;
        $canUpdate = (int) $staffTask->assigned_to === (int) $userId || (int) $staffTask->created_by === (int) $userId;
        if (!$canUpdate) {
            return redirect()->route('staff.tasks')->with('error', 'You are not allowed to update this task.');
        }

        $staffTask->status = $validated['status'];
        $staffTask->save();

        return redirect()->route('staff.tasks')->with('success', 'Task status updated.');
    }

    private function nextTaskCode(): string
    {
        $latestId = StaffTask::query()->latest('id')->value('id') ?? 0;

        return sprintf('TSK-%03d', $latestId + 1);
    }
}
