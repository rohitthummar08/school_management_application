<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementDismissal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnnouncementDismissalController extends Controller
{
    public function dismiss(Request $request, Announcement $announcement): JsonResponse
    {
        AnnouncementDismissal::firstOrCreate([
            'announcement_id' => $announcement->id,
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Announcement dismissed.',
        ]);
    }
}
