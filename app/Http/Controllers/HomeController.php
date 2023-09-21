<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        return view('contacts');
    }
    public function search()
    {
        $users = User::where('username', 'like', '%' . request('search') . '%')->get();
        if (isset($users)) {
            return view('contactSearch', ['users' => $users]);
        } else {
            return view('contactSearch');
        }
    }
}
