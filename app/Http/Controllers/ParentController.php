<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\StoreParentRequest;
use App\Http\Requests\UpdateParentRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ParentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $user = auth()->user();
        abort_unless($user->isAdmin() || $user->isTeacher(), 403);

        $parents = User::query()
            ->parent()
            ->with('teacherUser')
            ->withCount('students')
            ->when($user->isTeacher(), fn($q) => $q->where('teacher_id', $user->id))
            ->latest()
            ->paginate(10);

        return view('parents.index', compact('parents'));
    }

    public function create(): View
    {
        $user = auth()->user();
        abort_unless($user->isAdmin() || $user->isTeacher(), 403);

        $teachers = $user->isAdmin() ? User::teacher()->orderBy('name')->get() : collect();

        return view('parents.create', compact('teachers'));
    }

    public function store(StoreParentRequest $request): RedirectResponse
    {
        $user = $request->user();
        $teacherId = $user->isTeacher() ? $user->id : $request->teacher_id;

        User::create([
            'role' => Role::PARENT,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(32)),
            'teacher_id' => $teacherId,
        ]);

        return redirect()->route('parents.index')->with('success', 'Parent created successfully.');
    }

    public function edit(User $parent): View
    {
        $user = auth()->user();
        abort_unless($user->isAdmin() || $user->isTeacher(), 403);
        abort_unless($parent->isParent(), 404);

        if ($user->isTeacher()) {
            abort_if($parent->teacher_id !== $user->id, 403);
        }

        $teachers = $user->isAdmin() ? User::teacher()->orderBy('name')->get() : collect();

        return view('parents.edit', compact('parent', 'teachers'));
    }

    public function update(UpdateParentRequest $request, User $parent): RedirectResponse
    {
        $user = $request->user();
        abort_unless($parent->isParent(), 404);

        if ($user->isTeacher()) {
            abort_if($parent->teacher_id !== $user->id, 403);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($user->isAdmin() && $request->has('teacher_id')) {
            $data['teacher_id'] = $request->teacher_id;
        }

        $parent->update($data);

        return redirect()->route('parents.index')->with('success', 'Parent updated successfully.');
    }

    public function destroy(User $parent): RedirectResponse
    {
        $user = auth()->user();
        abort_unless($user->isAdmin() || $user->isTeacher(), 403);
        abort_unless($parent->isParent(), 404);

        if ($user->isTeacher()) {
            abort_if($parent->teacher_id !== $user->id, 403);
        }

        $parent->delete();

        return redirect()->route('parents.index')->with('success', 'Parent deleted successfully.');
    }
}
