<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreAnnouncementRequest;
use App\Jobs\SendAnnouncementEmailJob;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        abort_unless($user->isTeacher(), 403);

        $announcements = $user->announcements()
            ->latest()
            ->paginate(10);

        return view('teacher.announcements.index', compact('announcements'));
    }

    public function create(): View
    {
        abort_unless(auth()->user()->isTeacher(), 403);

        return view('teacher.announcements.create');
    }

    public function store(StoreAnnouncementRequest $request): RedirectResponse
    {
        $teacher = $request->user();

        $announcement = $teacher->announcements()->create([
            'title' => $request->title,
            'message' => $request->message,
            'roles' => implode(',', $request->roles),
        ]);

        $recipientEmails = [];
        if (in_array(Role::STUDENT->value, $request->roles)) {
            $recipientEmails = array_merge($recipientEmails, $teacher->managedStudents()->pluck('email')->all());
        }
        if (in_array(Role::PARENT->value, $request->roles)) {
            $recipientEmails = array_merge($recipientEmails, $teacher->managedParents()->pluck('email')->all());
        }
        $recipientEmails = array_values(array_unique(array_filter($recipientEmails)));

        if (!empty($recipientEmails)) {
            SendAnnouncementEmailJob::dispatch($announcement, $recipientEmails);
        }

        return redirect()
            ->route('teacher.announcements.index')
            ->with('success', 'Announcement created and notification emails queued successfully.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $user = auth()->user();
        abort_unless($user->isTeacher(), 403);
        abort_if($announcement->user_id !== $user->id, 403);

        $announcement->delete();

        return redirect()
            ->route('teacher.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}
