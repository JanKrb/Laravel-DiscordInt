@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
         'title' => 'Roles',
         'description' => 'Here you can find roles with their permissions.',
         'class' => 'col-lg-12',
         'actions' => '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-modal">Add Role</button>'
     ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-0">All Roles</h3>
                    </div>
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Role Name</th>
                                <th scope="col">Color Code</th>
                                <th scope="col">Member Count</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Updated At</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody class="list">
                            @foreach($roles as $role)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">{{ $role->name }}</span>
                                            </div>
                                        </div>
                                    </th>

                                    <td>
                                    <span class="badge badge-dot mr-4">
                                        <i class="bg-dark" style="background-color: {{ $role->color }} !important;"></i>
                                        <span class="status">{{ $role->color }}</span>
                                    </span>
                                    </td>
                                    <td>
                                        {{ $role->member_count }}
                                    </td>
                                    <td>
                                        {{ date("m/d/y h:i:s", strtotime($role->created_at)) }}
                                    </td>
                                    <td>
                                        {{ date("m/d/y h:i:s", strtotime($role->updated_at)) }}
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>

                                            @if(auth()->user()->hasPermission('i_roles_manage'))
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                @if(auth()->user()->hasPermission('i_roles_view'))
                                                <a class="dropdown-item" href="{{ route('roles.view.perms', ['roleid' => $role->id]) }}">View Perms</a>
                                                @endif

                                                @if(auth()->user()->hasPermission('i_roles_edit'))
                                                <button class="dropdown-item" id="edit_role" data-roleid="{{ $role->id }}" data-prev-name="{{ $role->name }}" data-prev-color="{{ $role->color }}">Edit Role</button>
                                                @endif

                                                @if(auth()->user()->hasPermission('i_roles_delete'))
                                                <button class="dropdown-item" id="delete_role" data-roleid="{{ $role->id }}">Delete Role</button>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Role Modal -->
        <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="edit-form" class="form-horizontal" method="post" action="{{ route('roles.add', ['roleid' => $role->id]) }}" autocomplete="off">
                        @method('put')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Add Role</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="edit-body-content">
                            <div class="card-body">
                                <!-- name -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">Name</label>
                                    <input type="text" name="role-name" class="form-control" id="modal-input-name" required autofocus>
                                </div>
                                <!-- /name -->

                                <!-- value -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-description">Color</label>
                                    <input type="color" name="role-color" class="form-control" id="modal-input-color" required>
                                </div>
                                <!-- /value -->
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
        <!-- /Add Role Modal -->

        <!-- Edit Role Modal -->
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="edit-form" class="form-horizontal" method="post" action="{{ route('roles.edit') }}" autocomplete="off">
                        @method('patch')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Edit Role</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="edit-body-content">
                            <div class="card-body">
                                <!-- id -->
                                <input type="hidden" name="role-id" id="modal-input-id">
                                <!-- /id -->

                                <!-- name -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">Name</label>
                                    <input type="text" name="role-name" class="form-control" id="modal-input-name_edit" required autofocus>
                                </div>
                                <!-- /name -->

                                <!-- value -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-description">Color</label>
                                    <input type="color" name="role-color" class="form-control" id="modal-input-color_edit" required>
                                </div>
                                <!-- /value -->
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
        <!-- /Edit Role Modal -->

        <!-- Delete Role Modal -->
        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="delete-form" class="form-horizontal" method="post" action="{{ route('roles.delete') }}" autocomplete="off">
                        @method('delete')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Delete Role</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button></div>

                        <div class="modal-body" id="edit-body-content">
                            <div class="card-body">
                                <input type="hidden" name="role-id" id="modal-delete-input-id">

                                <p>Are you sure, that you want to delete this role?</p>
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
        <!-- /Edit Role Modal -->

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            /**
             * for showing edit item popup
             */

            $(document).on('click', "#edit_role", function() {
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
                var id = el.data('roleid');
                var name = el.data('prev-name');
                var color = el.data('prev-color');

                // fill the data in the input fields
                $("#modal-input-id").val(id);
                $("#modal-input-name_edit").val(name);
                $("#modal-input-color_edit").val(color);
            })

            // on modal hide
            $('#edit-modal').on('hide.bs.modal', function() {
                $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
                $("#edit-form").trigger("reset");
            })

            ////////////////////////////////////////////////////////////////////////

            $(document).on('click', "#delete_role", function() {
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
                var id = el.data('roleid');

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
