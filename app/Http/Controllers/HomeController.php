<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index()
    {
        if (!auth()->user()->hasPermission('i_dashboard')) {
            abort(404);
        }

        $userCount = User::count();

        return view('dashboard', compact('userCount'));
    }
}
