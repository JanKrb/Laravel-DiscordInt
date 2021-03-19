@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
         'title' => 'Projects',
         'description' => 'Here you can find your own or shared projects',
         'class' => 'col-lg-12',
         'actions' => '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-modal">Create new Project</button>'
     ])

    <div class="container-fluid mt--7">
        <div class="row">
            @foreach($projects as $project)
                <div class="col-sm-6 col-xl-4">
                    <div class="card mb-4">
                        <div class="card-body d-flex justify-content-between align-items-start pb-3">
                            <div>
                                <a href="javascript:void(0)" class="text-body text-big font-weight-semibold">{{ $project->title }}</a>
                                <span class="badge badge-success align-text-bottom ml-1"><strike>Active</strike></span>
                                <div class="text-muted small mt-1"><strike>6 opened tasks, 48 tasks completed</strike></div>
                            </div>
                            <div class="btn-group project-actions">
                                <button type="button" class="btn btn-sm btn-default icon-btn borderless rounded-pill md-btn-flat dropdown-toggle hide-arrow" data-toggle="dropdown"></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('project.view', ['projectid' => $project->id]) }}">View</a>
                                    <button class="dropdown-item" id="edit_project" data-project-id="{{ $project->id }}" data-prev-title="{{ $project->title }}" data-prev-desc="{{ $project->description }}" data-prev-img="{{ $project->img }}">Edit</button>
                                    <button class="dropdown-item" id="delete_project" data-project-id="{{ $project->id }}">Remove</button>
                                </div>
                            </div>
                        </div>
                        <div class="progress rounded-0" style="height: 3px;">
                            <div class="progress-bar" style="width: 89%;"></div>
                        </div>
                        <div class="card-body small pt-2 pb-0">
                            <strike><strong>89%</strong> completed</strike>
                        </div>
                        <div class="card-body pb-3">
                            {{ $project->description }}
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col">
                                    <div class="text-muted small">Created</div>
                                    <div class="font-weight-bold">{{ date('m/d/Y', strtotime($project->created_at)) }}</div>
                                </div>
                                <div class="col">
                                    <div class="text-muted small">Updated</div>
                                    <div class="font-weight-bold">{{ date('m/d/Y', strtotime($project->updated_at)) }}</div>
                                </div>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="card-body py-3">
                            <div class="text-muted small mb-2">Team</div>
                            <div class="d-flex flex-wrap">
                                @foreach($project->participants as $participant)
                                <div class="d-block mr-1 mb-1">
                                    @if ($participant->user->profile_picture != null)
                                        <img src="{{ $participant->user->profile_picture }}" class="rounded-circle" style="width: 10% !important;">
                                    @else
                                        <img src="{{ e(asset('argon')) }}/img/theme/team-4-800x800.jpg" class="rounded-circle w-10" style="width: 10% !important;">
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Add Project Modal -->
        <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="edit-form" class="form-horizontal" method="post" action="{{ route('projects.create') }}" autocomplete="off">
                        @method('put')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Create Project</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="edit-body-content">
                            <div class="card-body">
                                <!-- name -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">Name</label>
                                    <input type="text" name="project-title" class="form-control" id="modal-input-name" placeholder="Title of your project" required autofocus>
                                </div>
                                <!-- /name -->

                                <!-- description -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-description">Description</label>
                                    <textarea name="project-desc" class="form-control" id="modal-input-desc" placeholder="Give your project a description" required></textarea>
                                </div>
                                <!-- /description -->

                                <!-- image url -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-image">Picture URL</label>
                                    <input type="url" name="project-img" class="form-control" id="modal-input-img" placeholder="https://.../image.png">
                                </div>
                                <!-- /image url -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Add Project Modal -->

        <!-- Edit Project Modal -->
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="edit-form" class="form-horizontal" method="post" action="{{ route('projects.edit') }}" autocomplete="off">
                        @method('patch')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Edit Project</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="edit-body-content">
                            <div class="card-body">
                                <!-- id -->
                                <input type="hidden" name="project-id" id="modal-input-id">
                                <!-- /id -->

                                <!-- title -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">Title</label>
                                    <input type="text" name="project-title" class="form-control" id="modal-input-title_edit" required autofocus>
                                </div>
                                <!-- /title -->

                                <!-- desc -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-description">Description</label>
                                    <textarea name="project-desc" class="form-control" id="modal-input-desc_edit" placeholder="Give your project a description" required></textarea>
                                </div>
                                <!-- /desc -->

                                <!-- image url -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-image">Picture URL</label>
                                    <input type="url" name="project-img" class="form-control" id="modal-input-img_edit" placeholder="https://.../image.png">
                                </div>
                                <!-- /image url -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Done</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Edit Project Modal -->

        <!-- Delete Project Modal -->
        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="delete-form" class="form-horizontal" method="post" action="{{ route('projects.delete') }}" autocomplete="off">
                        @method('delete')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Delete Project</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button></div>

                        <div class="modal-body" id="edit-body-content">
                            <div class="card-body">
                                <input type="hidden" name="project-id" id="modal-delete-input-id">

                                <p>Are you sure, that you want to delete this project?</p>
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
        <!-- /Edit Project Modal -->

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            /**
             * for showing edit item popup
             */
            $(document).on('click', "#edit_project", function() {
                $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
                var options = {
                    'backdrop': 'static'
                };
                $('#edit-modal').modal(options)
            })
            // on modal show
            $('#edit-modal').on('show.bs.modal', function() {
                var el = $(".edit-item-trigger-clicked"); // See how its usefull right here?
                var row = el.closest(".data-row");
                // get the data
                var id = el.data('project-id');
                var title = el.data('prev-title');
                var desc = el.data('prev-desc');
                var img = el.data('prev-img');
                // fill the data in the input fields
                $("#modal-input-id").val(id);
                $("#modal-input-title_edit").val(title);
                $("#modal-input-desc_edit").html(desc);
                $("#modal-input-img_edit").val(img);
            })
            // on modal hide
            $('#edit-modal').on('hide.bs.modal', function() {
                $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
                $("#edit-form").trigger("reset");
            })
            ////////////////////////////////////////////////////////////////////////
            $(document).on('click', "#delete_project", function() {
                $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
                var options = {
                    'backdrop': 'static'
                };
                $('#delete-modal').modal(options)
            })
            $('#delete-modal').on('show.bs.modal', function() {
                var el = $(".edit-item-trigger-clicked"); // See how its usefull right here?
                var row = el.closest(".data-row");
                // get the data
                var id = el.data('project-id');
                // fill the data in the input fields
                $("#modal-delete-input-id").val(id);
            })
            // on modal hide
            $('#delete-modal').on('hide.bs.modal', function() {
                $('.delete-item-trigger-clicked').removeClass('delete-item-trigger-clicked')
                $("#delete-form").trigger("reset");
            })
        })
    </script>
@endpush
