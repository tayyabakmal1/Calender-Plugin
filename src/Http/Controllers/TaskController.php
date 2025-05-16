<?php

namespace Platform\Plugins\Calendar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Platform\Plugins\Calendar\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('start_date', 'asc')->get();
        return view('calendar::calendar.index', compact('tasks'));
    }

    public function create()
    {
        return view('calendar::calendar.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'task_type' => 'required|string|max:255',
            'repetition' => 'required|in:one_time,monthly,every_6_months,yearly',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'task_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);
        Task::create($data);
        return redirect()->route('admin.calendar.index')->with('success', __('calendar::calendar.task_created'));
    }

    public function edit(Task $task)
    {
        return view('calendar::calendar.form', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'task_type' => 'required|string|max:255',
            'repetition' => 'required|in:one_time,monthly,every_6_months,yearly',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'task_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);
        $task->update($data);
        return redirect()->route('admin.calendar.index')->with('success', __('calendar::calendar.task_updated'));
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.calendar.index')->with('success', __('calendar::calendar.task_deleted'));
    }

    public function calendar()
    {
        return view('calendar::calendar.calendar');
    }

    public function calendarEvents(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $tasks = Task::where(function ($query) use ($start, $end) {
            $query->whereBetween('start_date', [$start, $end]);
            if ($end) {
                $query->orWhere(function ($q) use ($end) {
                    $q->where('repetition', '!=', 'one_time')
                      ->where('start_date', '<=', $end);
                });
            }
        })->get();

        $events = [];
        foreach ($tasks as $task) {
            // Always add the original occurrence as a single-day event
            $events[] = [
                'id' => $task->id,
                'title' => $task->task_name,
                'start' => $task->start_date->format('Y-m-d'),
                'allDay' => true,
            ];
            // Add repeated occurrences as single-day events
            if ($task->repetition !== 'one_time') {
                $current = $task->start_date->copy();
                $repeatEnd = $task->end_date ? $task->end_date->copy() : ($end ? \Carbon\Carbon::parse($end) : $current->copy()->addYear());
                while (true) {
                    switch ($task->repetition) {
                        case 'monthly':
                            $current = $current->copy()->addMonth();
                            break;
                        case 'every_6_months':
                            $current = $current->copy()->addMonths(6);
                            break;
                        case 'yearly':
                            $current = $current->copy()->addYear();
                            break;
                    }
                    if ($current->gt($repeatEnd)) break;
                    if ($current->lt($task->start_date)) continue;
                    if ($start && $current->lt(\Carbon\Carbon::parse($start))) continue;
                    if ($end && $current->gt(\Carbon\Carbon::parse($end))) break;
                    $events[] = [
                        'id' => $task->id . '-' . $current->format('Ymd'),
                        'title' => $task->task_name,
                        'start' => $current->format('Y-m-d'),
                        'allDay' => true,
                    ];
                }
            }
        }
        return response()->json($events);
    }
} 