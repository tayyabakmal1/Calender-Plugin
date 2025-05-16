@extends('core/base::layouts.master')

@section('content')
<div class="container">
    <h1>{{ __('calendar::calendar.calendar') }}</h1>
    <a href="{{ route('admin.calendar.index') }}" class="btn btn-secondary mb-3">{{ __('calendar::calendar.list_view') }}</a>
    <div id="calendar"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="taskModalLabel">Task Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="taskModalBody">
        <!-- Task details will be injected here -->
      </div>
      <div class="modal-footer">
        <a href="#" id="editTaskLink" class="btn btn-primary">Edit Task</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('header')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
@endpush

@push('footer')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: {
                    url: '{{ route('admin.calendar.calendar.events') }}',
                    method: 'GET',
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    // Show modal with task details
                    var event = info.event;
                    var modal = new bootstrap.Modal(document.getElementById('taskModal'));
                    var body = document.getElementById('taskModalBody');
                    var editLink = document.getElementById('editTaskLink');
                    body.innerHTML = `
                        <p><strong>Task Name:</strong> ${event.title}</p>
                        <p><strong>Date:</strong> ${event.startStr}</p>
                    `;
                    // If the event id is in the format 'id-YYYYMMDD', extract the id
                    var taskId = event.id.split('-')[0];
                    editLink.href = '{{ url('admin/calendar') }}/' + taskId + '/edit';
                    modal.show();
                }
            });
            calendar.render();
        });
    </script>
@endpush 