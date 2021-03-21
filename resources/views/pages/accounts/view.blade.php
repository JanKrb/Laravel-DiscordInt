@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
         'title' => 'Accounts',
         'description' => 'Here you can find all accounts with their roles and additional information.',
         'class' => 'col-lg-12'
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
                                <th scope="col">Name</th>
                                <th scope="col">Mail</th>
                                <th scope="col">Discord ID</th>
                                <th scope="col">Role</th>
                                <th scope="col">Verified Mail</th>
                                <th scope="col">Picture</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody class="list">
                                @foreach($accounts as $account)
                                    <tr>
                                        <td>{{ $account->name }}</td>
                                        <td>{{ $account->email }}</td>
                                        <td>{{ $account->discord_id }}</td>
                                        <td>{{ $account->role->name }}</td>
                                        <td>{{ $account->email_verified_at }}</td>
                                        <td><a target="_blank" href="{{ $account->profile_picture }}">Link</a></td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footers.auth')
    </div>
@endsection
