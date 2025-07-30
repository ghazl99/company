<?php

namespace Modules\WorkSession\Repositories;

use Modules\WorkSession\Models\WorkSession;

class WorkSessionModelRepository implements WorkSessionRepository
{
    public function startSession(int $developerId)
    {
        return WorkSession::create([
            'developer_id' => $developerId,
            'start_time' => now(),
        ]);
    }

    public function endSession(int $developerId)
    {
        $session = $this->getActiveSession($developerId);
        if (! $session) {
            return null;
        }

        $endTime = now();
        $duration = $session->start_time->diffInSeconds($endTime);

        $session->update([
            'end_time' => $endTime,
            'duration_seconds' => $duration,
        ]);

        return $session;
    }

    public function getActiveSession(int $developerId)
    {
        return WorkSession::where('developer_id', $developerId)
            ->whereNull('end_time')
            ->latest()
            ->first();
    }
}
