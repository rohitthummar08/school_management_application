<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
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

        $stats = [];
        if ($user && $user->isAdmin()) {
            $stats = [
                'teachers' => User::teacher()->count(),
                'students' => User::student()->count(),
                'parents' => User::parent()->count(),
            ];
        } elseif ($user && $user->isTeacher()) {
            $stats = [
                'students' => $user->managedStudents()->count(),
                'parents' => $user->managedParents()->count(),
            ];
        }

        return view('home', compact('announcements', 'stats'));
    }
}
