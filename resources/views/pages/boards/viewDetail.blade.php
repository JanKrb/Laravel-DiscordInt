@extends('layouts.app')

@section('content')
@include('users.partials.header', [
'title' => $task->title,
'class' => 'col-lg-12'
])

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">

            <!-- Description -->
            <div class="card mb-4">
                <h6 class="card-header">Description</h6>
                <div class="card-body">
                    {{ $task->description }}
                </div>
            </div>
            <!-- / Description -->

            <!-- Recent Activity -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card mb-4">
                        <form role="form" method="POST" action="{{ route('project.view.answer', ["projectid" => $task->project_id, "taskid" => $task->id]) }}">
                            @method('put')
                            @csrf
                            <div class="card-body d-flex justify-content-between align-items-start pb-3">
                                <input type="text" class="form-control" name="answer-text" placeholder="Answer..">
                                <button type="submit" class="btn btn-success ml-3">Send</button>
                            </div>
                        </form>
                    </div>

                    @foreach ($answers as $answer)
                        <div class="card mb-4">
                            <div class="card-body d-flex justify-content-between align-items-start pb-3">
                                <div>
                                    <div>{{ $answer->user->name }}</div>
                                    <div class="text-muted small mt-1">{{ date('m/d/Y', strtotime($answer->created_at)) }}</div>
                                </div>
                            </div>

                            <div class="card-body pb-3">
                                {{ $answer->description }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- / Recent Activity -->
        </div>

        <div class="col-md-4 col-xl-3">
            <!-- Project details -->
            <div class="card mb-4">
                <h6 class="card-header">Project details</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Created by</div>
                        <div>{{ $user->name }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Created at</div>
                        <div>{{ date('m/d/Y', strtotime($task->created_at)) }}</div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="text-muted">Last update</div>
                        <div>{{ date('m/d/Y', strtotime($task->updated_at)) }}</div>
                    </li>
                </ul>
            </div>
            <!-- / Project details -->

            <!-- Participants -->
            <div class="card mb-4">
                <h6 class="card-header with-elements">
                    <span class="card-header-title">Participants</span>
                    <div class="card-header-elements ml-auto">
                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#add-participant">
                            <span class="ion ion-md-add"></span> Add
                        </button>
                    </div>
                </h6>
                <ul class="list-group list-group-flush">
                    @foreach($assignments as $assignment)
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            @if ($assignment->user->profile_picture != null)
                                <img src="{{ $assignment->user->profile_picture }}" alt="Profile Picture" class="d-block rounded-circle" style="width: 10% !important;">
                            @else
                                <img src="{{ e(asset('argon')) }}/img/theme/team-4-800x800.jpg" alt="Profile Picture" class="d-block rounded-circle" style="width: 10% !important;">
                            @endif
                            <div class="media-body px-2">
                                {{ $assignment->user->name }}
                            </div>
                            <a class="d-block text-light text-large font-weight-light delete_participant" data-participant-id="{{ $assignment->user->id }}">×</a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <!-- / Participants -->

            <!-- Tags -->
            <div class="card mb-4">
                <h6 class="card-header with-elements">
                    <span class="card-header-title">Tags</span>
                </h6>
                <ul class="list-group list-group-flush">
                    {{ $tag }}
                    <div class="list-group-item">
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                </ul>
            </div>
            <!-- / Tags -->
        </div>
    </div>

    <!-- Add Leader Modal -->
    <div class="modal fade" id="add-participant" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="edit-form" class="form-horizontal" method="post" action="{{ route('project.task.addParticipant', ['projectid' => $project->id, 'taskid' => $task->id]) }}" autocomplete="off">
                    @method('put')
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="edit-modal-label">Add Participant</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="edit-body-content">
                        <div class="card-body">
                            <!-- mail -->
                            <div class="form-group">
                                <label class="col-form-label" for="modal-input-name">E-Mail</label>
                                <input type="text" name="participant-mail" class="form-control" id="modal-input-mail" placeholder="Mail of new participant" required autofocus>
                            </div>
                            <!-- /mail -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Leader Modal -->

    <!-- Delete Participants Modal -->
    <div class="modal fade" id="delete-participant" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="delete-form" class="form-horizontal" method="post" action="{{ route('project.task.deleteParticipant', ['projectid' => $project->id, 'taskid' => $task->id]) }}" autocomplete="off">
                    @method('delete')
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="edit-modal-label">Delete Participant</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" id="edit-body-content">
                        <div class="card-body">
                            <input type="hidden" name="participant-id" id="modal-delete-participant-input-id">

                            <p>Are you sure, that you want to delete this participant?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Delete Participants Modal -->

    @include('layouts.footers.auth')
</div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            $(document).on('click', ".delete_participant", function() {
                $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
                var options = {
                    'backdrop': 'static'
                };
                $('#delete-participant').modal(options)
            })
            $('#delete-participant').on('show.bs.modal', function() {
                var el = $(".edit-item-trigger-clicked"); // See how its usefull right here?
                var row = el.closest(".data-row");
                // get the data
                var id = el.data('participant-id');
                // fill the data in the input fields
                $("#modal-delete-participant-input-id").val(id);
            })
            // on modal hide
            $('#delete-participant').on('hide.bs.modal', function() {
                $('.delete-item-trigger-clicked').removeClass('delete-item-trigger-clicked')
                $("#delete-form").trigger("reset");
            })
        })
    </script>
@endpush
