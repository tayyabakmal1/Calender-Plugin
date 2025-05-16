@extends('core/base::layouts.master')

@section('content')
    <div class="container">
        <h1>{{ __('calendar::calendar.calendar') }}</h1>
        <a href="{{ route('admin.calendar.calendar') }}" class="btn btn-info mb-3">{{ __('calendar::calendar.calendar_view') }}</a>
        <a href="{{ route('admin.calendar.create') }}" class="btn btn-primary mb-3">{{ __('calendar::calendar.add_task') }}</a>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{ __('calendar::calendar.task_name') }}</th>
                    <th>{{ __('calendar::calendar.task_type') }}</th>
                    <th>{{ __('calendar::calendar.repetition') }}</th>
                    <th>{{ __('calendar::calendar.start_date') }}</th>
                    <th>{{ __('calendar::calendar.end_date') }}</th>
                    <th>{{ __('calendar::calendar.phone_number') }}</th>
                    <th>{{ __('calendar::calendar.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr>
                        <td>{{ $task->task_name }}</td>
                        <td>{{ $task->task_type }}</td>
                        <td>{{ __('calendar::calendar.repetition_' . $task->repetition) }}</td>
                        <td>{{ $task->start_date->format('Y-m-d') }}</td>
                        <td>{{ $task->end_date ? $task->end_date->format('Y-m-d') : '-' }}</td>
                        <td>{{ $task->phone_number }}</td>
                        <td>
                            <a href="{{ route('admin.calendar.edit', $task) }}" class="btn btn-sm btn-warning">{{ __('calendar::calendar.edit') }}</a>
                            <form action="{{ route('admin.calendar.destroy', $task) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('calendar::calendar.confirm_delete') }}')">{{ __('calendar::calendar.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">{{ __('calendar::calendar.no_tasks') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection 