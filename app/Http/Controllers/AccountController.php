<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Tickets;
use App\Models\User;

class AccountController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function view()
    {
        if (!auth()->user()->hasPermission('i_accounts_show')) {
            abort(404);
        }

        $data = array();
        $users = User::all();
        foreach ($users as $user) {
            $user['role'] = Role::where('id', $user->role_id)->first();
        }

        $data['accounts'] = $users;

        return view('pages.accounts.view', $data);
    }
}
