@extends('core/base::layouts.master')

@section('content')
    <div class="container">
        <h1>{{ isset($task) ? __('calendar::calendar.edit_task') : __('calendar::calendar.add_task') }}</h1>
        <form method="POST" action="{{ isset($task) ? route('admin.calendar.update', $task) : route('admin.calendar.store') }}">
            @csrf
            @if(isset($task))
                @method('PUT')
            @endif
            <div class="mb-3">
                <label for="task_name" class="form-label">{{ __('calendar::calendar.task_name') }}</label>
                <input type="text" class="form-control" id="task_name" name="task_name" value="{{ old('task_name', $task->task_name ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="task_type" class="form-label">{{ __('calendar::calendar.task_type') }}</label>
                <input type="text" class="form-control" id="task_type" name="task_type" value="{{ old('task_type', $task->task_type ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label for="repetition" class="form-label">{{ __('calendar::calendar.repetition') }}</label>
                <select class="form-control" id="repetition" name="repetition" required>
                    <option value="one_time" {{ old('repetition', $task->repetition ?? '') == 'one_time' ? 'selected' : '' }}>{{ __('calendar::calendar.repetition_one_time') }}</option>
                    <option value="monthly" {{ old('repetition', $task->repetition ?? '') == 'monthly' ? 'selected' : '' }}>{{ __('calendar::calendar.repetition_monthly') }}</option>
                    <option value="every_6_months" {{ old('repetition', $task->repetition ?? '') == 'every_6_months' ? 'selected' : '' }}>{{ __('calendar::calendar.repetition_every_6_months') }}</option>
                    <option value="yearly" {{ old('repetition', $task->repetition ?? '') == 'yearly' ? 'selected' : '' }}>{{ __('calendar::calendar.repetition_yearly') }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">{{ __('calendar::calendar.start_date') }}</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', isset($task) ? $task->start_date->format('Y-m-d') : '') }}" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">{{ __('calendar::calendar.end_date') }}</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', isset($task) && $task->end_date ? $task->end_date->format('Y-m-d') : '') }}">
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">{{ __('calendar::calendar.phone_number') }}</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $task->phone_number ?? '') }}">
            </div>
            <button type="submit" class="btn btn-success">{{ isset($task) ? __('calendar::calendar.update') : __('calendar::calendar.create') }}</button>
            <a href="{{ route('admin.calendar.index') }}" class="btn btn-secondary">{{ __('calendar::calendar.cancel') }}</a>
        </form>
    </div>
@endsection 