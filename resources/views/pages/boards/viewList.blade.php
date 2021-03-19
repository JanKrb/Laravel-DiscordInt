@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
         'title' => 'Board #1',
         'description' => 'This is a sample description for your board',
         'class' => 'col-lg-12'
    ])

    <div class="container-fluid mt--7">
        <div class="row">

            <div class="col">

                <div class="card">
                    <div class="card-header py-3">
                        <button type="button" class="btn btn-primary"><i class="ion ion-md-add"></i>&nbsp; Add task</button>&nbsp;
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">Today</p>
                        <div class="task-list custom-controls-stacked">

                            @foreach($tasks as $task)
                                @if ($task->time_left != null && $task->time_left->d == 0)
                                    <div class="task-list-item display-">
                                        <label class="ui-todo-item custom-control d-inline-block">
                                            <input type="checkbox" class="custom-control-input">
                                            <span class="custom-control-label">{{ $task->title }}</span>

                                            @foreach($task['statuses'] as $status)
                                                <span class="badge badge-warning font-weight-normal ml-2" style="background-color: {{ $status->color }}">{{ $status->name }}</span>
                                            @endforeach

                                            <span class="ui-todo-badge badge badge-outline-default font-weight-normal ml-2">{{ $task->time_left->format('%d days') }}</span>
                                        </label>

                                        <a href="{{ route('project.view.details', ["projectid" => $task->project_id, "taskid" => $task->id]) }}"><i class="fas fa-ellipsis-v float-right open-details"></i></a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <hr class="m-0">
                    <div class="card-body">
                        <p class="text-muted small">Tomorrow</p>
                        <div class="task-list custom-controls-stacked">

                            @foreach($tasks as $task)
                                @if ($task->time_left != null && $task->time_left->d == 1)
                                    <div class="task-list-item">
                                        <label class="ui-todo-item custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input">
                                            <span class="custom-control-label">{{ $task->title }}</span>

                                            @foreach($task['statuses'] as $status)
                                                <span class="badge badge-warning font-weight-normal ml-2" style="background-color: {{ $status->color }}">{{ $status->name }}</span>
                                            @endforeach

                                            <span class="ui-todo-badge badge badge-outline-default font-weight-normal ml-2">{{ $task->time_left->format('%d days') }}</span>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <hr class="m-0">
                    <div class="card-body">
                        <p class="text-muted small">Next week</p>
                        <div class="task-list custom-controls-stacked">

                            @foreach($tasks as $task)
                                @if ($task->time_left != null && $task->time_left->d > 1 && $task->time_left->d <= 7)
                                    <div class="task-list-item">
                                        <label class="ui-todo-item custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input">
                                            <span class="custom-control-label">{{ $task->title }}</span>

                                            @foreach($task['statuses'] as $status)
                                                <span class="badge badge-warning font-weight-normal ml-2" style="background-color: {{ $status->color }}">{{ $status->name }}</span>
                                            @endforeach

                                            <span class="ui-todo-badge badge badge-outline-default font-weight-normal ml-2">{{ $task->time_left->format('%d days') }}</span>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <hr class="m-0">
                    <div class="card-body">
                        <p class="text-muted small">Next week</p>
                        <div class="task-list custom-controls-stacked">

                            @foreach($tasks as $task)
                                @if ($task->time_left == null || $task->time_left->d > 7)
                                    <div class="task-list-item">
                                        <label class="ui-todo-item custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input">
                                            <span class="custom-control-label">{{ $task->title }}</span>

                                            @foreach($task['statuses'] as $status)
                                            <span class="badge badge-warning font-weight-normal ml-2" style="background-color: {{ $status->color }}">{{ $status->name }}</span>
                                            @endforeach

                                            @if ($task->time_left != null)
                                            <span class="ui-todo-badge badge badge-outline-default font-weight-normal ml-2">{{ $task->time_left->format('%d days') }}</span>
                                            @endif
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
