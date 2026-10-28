<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $user = auth()->user();
        abort_unless($user->isAdmin() || $user->isTeacher(), 403);

        $students = User::query()
            ->student()
            ->with(['parentUser', 'teacherUser'])
            ->when($user->isTeacher(), fn($q) => $q->where('teacher_id', $user->id))
            ->latest()
            ->paginate(10);

        return view('students.index', compact('students'));
    }

    public function create(): View
    {
        $user = auth()->user();
        abort_unless($user->isAdmin() || $user->isTeacher(), 403);

        $parents = User::parent()
            ->when($user->isTeacher(), fn($q) => $q->where('teacher_id', $user->id))
            ->orderBy('name')
            ->get();

        $teachers = $user->isAdmin() ? User::teacher()->orderBy('name')->get() : collect();

        return view('students.create', compact('parents', 'teachers'));
    }

    public function store(StoreStudentRequest $request): RedirectResponse
    {
        $user = $request->user();
        $teacherId = $user->isTeacher() ? $user->id : $request->teacher_id;

        User::create([
            'role' => Role::STUDENT,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(32)),
            'teacher_id' => $teacherId,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    public function edit(User $student): View
    {
        $user = auth()->user();
        abort_unless($user->isAdmin() || $user->isTeacher(), 403);
        abort_unless($student->isStudent(), 404);

        if ($user->isTeacher()) {
            abort_if($student->teacher_id !== $user->id, 403);
        }

        $parents = User::parent()
            ->when($user->isTeacher(), fn($q) => $q->where('teacher_id', $user->id))
            ->orderBy('name')
            ->get();

        $teachers = $user->isAdmin() ? User::teacher()->orderBy('name')->get() : collect();

        return view('students.edit', compact('student', 'parents', 'teachers'));
    }

    public function update(UpdateStudentRequest $request, User $student): RedirectResponse
    {
        $user = $request->user();
        abort_unless($student->isStudent(), 404);

        if ($user->isTeacher()) {
            abort_if($student->teacher_id !== $user->id, 403);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'parent_id' => $request->parent_id,
        ];

        if ($user->isAdmin() && $request->has('teacher_id')) {
            $data['teacher_id'] = $request->teacher_id;
        }

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(User $student): RedirectResponse
    {
        $user = auth()->user();
        abort_unless($user->isAdmin() || $user->isTeacher(), 403);
        abort_unless($student->isStudent(), 404);

        if ($user->isTeacher()) {
            abort_if($student->teacher_id !== $user->id, 403);
        }

        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
