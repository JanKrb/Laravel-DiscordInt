@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
         'title' => 'Board #1',
         'description' => 'This is a sample description for your board',
         'class' => 'col-lg-12'
    ])

    <div class="container-fluid mt--7">
        <div class="form-row">
            <div class="col-md">

                <div class="card mb-3">
                    <h6 class="card-header text-center">New</h6>
                    <div class="kanban-box px-2 pt-2">
                        <div class="ui-bordered p-2 mb-2">
                            Another icon set
                        </div>
                        <div class="ui-bordered p-2 mb-2">
                            iOS application design mockups
                        </div>
                    </div>
                    <div class="card-footer text-center py-2">
                        <a href="javascript:void(0)"><i class="ion ion-md-add"></i>&nbsp; Add task</a>
                    </div>
                </div>

            </div>
            <div class="col-md">

                <div class="card border-info mb-3">
                    <h6 class="card-header text-center text-info">In progress</h6>
                    <div class="kanban-box px-2 pt-2">
                        <div class="ui-bordered p-2 mb-2">
                            Another icon set
                        </div>
                        <div class="ui-bordered p-2 mb-2">
                            iOS application design mockups
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md">

                <div class="card border-warning mb-3">
                    <h6 class="card-header text-center text-warning">Test</h6>
                    <div class="kanban-box px-2 pt-2">
                        <div class="ui-bordered p-2 mb-2">
                            Another icon set
                        </div>
                        <div class="ui-bordered p-2 mb-2">
                            iOS application design mockups
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md">

                <div class="card border-success mb-3">
                    <h6 class="card-header text-center text-success">Done</h6>
                    <div class="kanban-box px-2 pt-2">
                        <div class="ui-bordered p-2 mb-2">
                            Another icon set
                        </div>
                        <div class="ui-bordered p-2 mb-2">
                            iOS application design mockups
                        </div>
                    </div>
                    <div class="card-footer text-center py-2">
                        <a href="javascript:void(0)"><i class="ion ion-md-close"></i>&nbsp; Clear completed tasks</a>
                    </div>
                </div>

            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection

@push('head')
    <link rel="stylesheet" href="{{ asset('argon') }}/vendor/dragula/dist/dragula.min.css">
@endpush

@push('js')
    <script src="{{ asset('argon') }}/vendor/dragula/dist/dragula.min.js"></script>
    <script>
        $(function() {

            // Drag&Drop
            dragula(
                Array.prototype.slice.call(document.querySelectorAll('.kanban-box'))
            );
        });
    </script>
@endpush
