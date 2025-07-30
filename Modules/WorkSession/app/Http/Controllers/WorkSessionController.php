<?php

namespace Modules\WorkSession\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\WorkSession\Services\WorkSessionService;

class WorkSessionController extends Controller
{
    public function __construct(
        protected WorkSessionService $WorkSessionService
    ) {}

    public function start()
    {
        $this->WorkSessionService->start(Auth::id());

        return back()->with('success', 'تم بدء الدوام.');
    }

    public function end()
    {
        $session = $this->WorkSessionService->end(Auth::id());
        $durationSeconds = $session->duration_seconds ?? 0;

        // Calculate hours, minutes, and remaining seconds
        $hours = floor($durationSeconds / 3600);
        $minutes = floor(($durationSeconds % 3600) / 60);
        $remainingSeconds = $durationSeconds % 60;

        $durationParts = [];

        if ($hours > 0) {
            $durationParts[] = $hours.' ساعة';
        }
        if ($minutes > 0) {
            $durationParts[] = $minutes.' دقيقة';
        }
        if ($remainingSeconds > 0 || ($hours === 0 && $minutes === 0)) { // Include seconds if there are any, or if it's less than a minute
            $durationParts[] = $remainingSeconds.' ثانية';
        }

        // Join the parts with " و " (and)
        $duration = implode(' و ', $durationParts);

        // Fallback for 0 duration
        if (empty($durationParts)) {
            $duration = '0 ثانية';
        }

        return back()->with('success', 'تم إنهاء الدوام. المدة: '.$duration);
    }

    public function status()
    {
        $developer = Auth::user(); // تأكد أنك مسجل دخولك كمطور
        $activeSession = $this->WorkSessionService->getActiveSession($developer->id);

        return view('worksession::admin.timer', compact('activeSession'));
    }
}
