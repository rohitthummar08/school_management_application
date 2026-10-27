<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
    public function index(Request $request): View
    {
        $user = $request->user();
        $announcements = $user && $user->isTeacher()
            ? Announcement::unreadFor($user)->latest()->get()
            : collect();

        return view('home', compact('announcements'));
    }
}
