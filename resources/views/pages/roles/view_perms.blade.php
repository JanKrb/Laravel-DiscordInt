@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
         'title' => 'Permissions',
         'description' => 'Here you can find all permissions of the role ' . $role->name,
         'class' => 'col-lg-12',
         'actions' => '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-modal">Add Permission</button>'
     ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-0">Permissions of {{ $role->name }}</h3>
                    </div>

                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Permission Name</th>
                                <th scope="col">Value</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Updated At</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tr>
                            @foreach($permissions as $permission)
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">{{ $permission->name }}</span>
                                        </div>
                                    </div>
                                </th>
                                <td>
                                    {{ $permission->value }}
                                </td>
                                <td>
                                    {{ date("m/d/y h:i:s", strtotime($permission->created_at)) }}
                                </td>
                                <td>
                                    {{ date("m/d/y h:i:s", strtotime($permission->updated_at)) }}
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>

                                        @if(auth()->user()->hasPermission('i_roles_manage_permissions'))
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                @if(auth()->user()->hasPermission('i_roles_edit_permissions'))
                                                    <button class="dropdown-item" id="edit_permission" data-permid="{{ $permission->id }}" data-prev-name="{{ $permission->name }}" data-prev-value="{{ $permission->value }}">Edit Permission</button>
                                                @endif

                                                @if(auth()->user()->hasPermission('i_roles_delete_permissions'))
                                                    <button class="dropdown-item" id="delete_permission" data-permid="{{ $permission->id }}">Delete Permission</button>
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

        <!-- Add Permission Modal -->
        <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="edit-form" class="form-horizontal" method="post" action="{{ route('roles.perms.add', ['roleid' => $role->id]) }}" autocomplete="off">
                        @method('put')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Add Permission</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="edit-body-content">
                            <div class="card-body">
                                <!-- name -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">Name</label>
                                    <input type="text" name="perm-name" class="form-control" id="modal-input-name" required autofocus>
                                </div>
                                <!-- /name -->

                                <!-- value -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-description">Value</label>
                                    <input type="number" name="perm-value" class="form-control" id="modal-input-value" required>
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
        <!-- /Add Permission Modal -->

        <!-- Edit Permission Modal -->
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="edit-form" class="form-horizontal" method="post" action="{{ route('roles.perms.edit', ['roleid' => $role->id]) }}" autocomplete="off">
                        @method('patch')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Edit Permission</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="edit-body-content">
                            <div class="card-body">
                                <!-- id -->
                                <input type="hidden" name="perm-id" id="modal-input-id">
                                <!-- /id -->

                                <!-- name -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-name">Name</label>
                                    <input type="text" name="perm-name" class="form-control" id="modal-input-name" required autofocus>
                                </div>
                                <!-- /name -->

                                <!-- value -->
                                <div class="form-group">
                                    <label class="col-form-label" for="modal-input-description">Value</label>
                                    <input type="number" name="perm-value" class="form-control" id="modal-input-value" required>
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
        <!-- /Edit Permission Modal -->

        <!-- Delete Permission Modal -->
        <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="delete-form" class="form-horizontal" method="post" action="{{ route('roles.perms.delete', ['roleid' => $role->id]) }}" autocomplete="off">
                        @method('delete')
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="edit-modal-label">Delete Permission</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button></div>

                        <div class="modal-body" id="edit-body-content">
                            <div class="card-body">
                                <input type="hidden" name="perm-id" id="modal-delete-input-id">

                                <p>Are you sure, that you want to delete this permission?</p>
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
        <!-- /Edit Permission Modal -->

        @include('layouts.footers.auth')
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            /**
             * for showing edit item popup
             */

            $(document).on('click', "#edit_permission", function() {
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
                var id = el.data('permid');
                var name = el.data('prev-name');
                var value = el.data('prev-value');

                // fill the data in the input fields
                $("#modal-input-id").val(id);
                $("#modal-input-name").val(name);
                $("#modal-input-value").val(value);
            })

            // on modal hide
            $('#edit-modal').on('hide.bs.modal', function() {
                $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
                $("#edit-form").trigger("reset");
            })

            ////////////////////////////////////////////////////////////////////////

            $(document).on('click', "#delete_permission", function() {
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
                var id = el.data('permid');

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
