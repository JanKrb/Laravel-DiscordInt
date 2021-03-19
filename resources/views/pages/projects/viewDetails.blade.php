@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => $project->title,
        'description' => 'Project #' . $project->id,
        'class' => 'col-lg-12'
    ])

    <div class="container-fluid">
        <div class="container-m-nx border-right-0 border-left-0 ui-bordered mb-4">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-9">
                    <div class="media-body container-p-x py-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div><strong class="text-primary text-large"><strike>67%</strong> completed</strike></div>
                            <div class="text-muted small"><strike>15 opened tasks, 29 tasks completed</strike></div>
                        </div>
                        <div class="progress" style="height: 4px;">
                            <div class="progress-bar" style="width: 67%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">

                <!-- Description -->
                <div class="card mb-4">
                    <h6 class="card-header">Description</h6>
                    <div class="card-body">
                        {{ $project->description }}
                    </div>
                </div>
                <!-- / Description -->

                <!-- Recent Activity -->
                <div class="card mb-4">
                    <div class="card-body">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="card mb-4">
                                <div class="card-body d-flex justify-content-between align-items-start pb-3">
                                    <div>
                                        <a href="javascript:void(0)" class="text-body text-big font-weight-semibold">example.com design</a>
                                        <div class="text-muted small mt-1">03/21/2021</div>
                                    </div>
                                </div>

                                <div class="card-body pb-3">
                                    Jan Ruhfus has commented on the ticket: This is the comment function
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                <!-- / Recent Activity -->
            </div>

            <div class="col-md-4 col-xl-3">
                <!-- Views -->
                <div class="card mb-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('project.view.list', ['projectid' => $project->id]) }}">{{ __('List View') }}</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('project.view.kanban', ['projectid' => $project->id]) }}">{{ __('Kanban View') }}</a>
                        </li>
                    </ul>
                </div>
                <!-- / Views -->

                <!-- Project details -->
                <div class="card mb-4">
                    <h6 class="card-header">Project details</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">Created by</div>
                            <div>{{ $creator->name }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">Created at</div>
                            <div>{{ date('m/d/Y', strtotime($project->created_at)) }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">Last update</div>
                            <div>{{ date('m/d/Y', strtotime($project->updated_at)) }}</div>
                        </li>
                    </ul>
                </div>
                <!-- / Project details -->

                <!-- Leaders -->
                <div class="card mb-4">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">Leaders</span>
                        <div class="card-header-elements ml-auto">
                            <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#add-leader">
                                <span class="ion ion-md-add"></span> Add
                            </button>
                        </div>
                    </h6>
                    <ul class="list-group list-group-flush">
                        @foreach($participants as $participant)
                            @if($participant->leader)
                                <li class="list-group-item">
                                    <div class="media align-items-center">
                                        @if ($participant->user->profile_picture != null)
                                            <img src="{{ $participant->user->profile_picture }}" alt="Profile Picture" class="d-block rounded-circle" style="width: 10% !important;">
                                        @else
                                            <img src="{{ e(asset('argon')) }}/img/theme/team-4-800x800.jpg" alt="Profile Picture" class="d-block rounded-circle" style="width: 10% !important;">
                                        @endif
                                        <div class="media-body px-2">
                                            {{ $participant->user->name }}
                                        </div>
                                        <a class="d-block text-light text-large font-weight-light delete_leader" data-leader-id="{{ $participant->id }}">×</a>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <!-- / Leaders -->

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
                        @foreach($participants as $participant)
                            @if(!$participant->leader)
                                <li class="list-group-item">
                                    <div class="media align-items-center">
                                        @if ($participant->user->profile_picture != null)
                                            <img src="{{ $participant->user->profile_picture }}" alt="Profile Picture" class="d-block rounded-circle" style="width: 10% !important;">
                                        @else
                                            <img src="{{ e(asset('argon')) }}/img/theme/team-4-800x800.jpg" alt="Profile Picture" class="d-block rounded-circle" style="width: 10% !important;">
                                        @endif
                                        <div class="media-body px-2">
                                            {{ $participant->user->name }}
                                        </div>
                                        <a class="d-block text-light text-large font-weight-light delete_participant" data-participant-id="{{ $participant->id }}">×</a>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <!-- / Participants -->
            </div>
        </div>

        <!-- Add Leader Modal -->
        <div class="modal fade" id="add-leader" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="edit-form" class="form-horizontal" method="post" action="{{ route('project.leader.add', $project->id) }}" autocomplete="off">
                        @method('put')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Add Project Leader</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="edit-body-content">
                            <div class="card-body">
                                <!-- mail -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">E-Mail</label>
                                    <input type="text" name="leader-mail" class="form-control" id="modal-input-mail" placeholder="Mail of new leader" required autofocus>
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

        <!-- Delete Leader Modal -->
        <div class="modal fade" id="delete-leader" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="delete-form" class="form-horizontal" method="post" action="{{ route('project.leader.delete', $project->id) }}" autocomplete="off">
                        @method('delete')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Delete Leader</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button></div>

                        <div class="modal-body" id="edit-body-content">
                            <div class="card-body">
                                <input type="hidden" name="leader-id" id="modal-delete-leader-input-id">

                                <p>Are you sure, that you want to delete this leader?</p>
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
        <!-- /Delete Leader Modal -->

        <!-- Add Leader Modal -->
        <div class="modal fade" id="add-participant" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="edit-form" class="form-horizontal" method="post" action="{{ route('project.participant.add', $project->id) }}" autocomplete="off">
                        @method('put')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Add Project Participant</h5>
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
                    <form id="delete-form" class="form-horizontal" method="post" action="{{ route('project.participant.delete', $project->id) }}" autocomplete="off">
                        @method('delete')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Delete Participant</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button></div>

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
            $(document).on('click', ".delete_leader", function() {
                $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
                var options = {
                    'backdrop': 'static'
                };
                $('#delete-leader').modal(options)
            })
            $('#delete-leader').on('show.bs.modal', function() {
                var el = $(".edit-item-trigger-clicked"); // See how its usefull right here?
                var row = el.closest(".data-row");
                // get the data
                var id = el.data('leader-id');
                // fill the data in the input fields
                $("#modal-delete-leader-input-id").val(id);
            })
            // on modal hide
            $('#delete-leader').on('hide.bs.modal', function() {
                $('.delete-item-trigger-clicked').removeClass('delete-item-trigger-clicked')
                $("#delete-form").trigger("reset");
            })
            ////////////////////////////
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
